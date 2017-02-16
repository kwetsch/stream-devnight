<?php
/*
 * This script gets the current and last event from the github API
 * and writes the urls as a HTML redirect file.
 */
require_once("vendor/autoload.php");

/**
 * Generates the files.
 *
 * @param $payload
 * @param $action
 * @param $config
 */
function generateFiles($payload, $action, $config){
	if($payload || $action == $config->secret) {
		// gets the result of the api call
		$request = queryURL($config->url);

		// convert json to a collection
		$repos = collect(json_decode($request, true));

		// sort all repos and filter out all repos which don't contain content from a /dev/night
		$repos = $repos->sortBy('created_at')
				->reverse()
				->filter(function($val, $key) {
					return containsDate($val['name']);
				});

		// get the data for this (now) and the last event
		$now = $repos->shift();
		$last = $repos->shift();

		// write the redirect files
		writeRedirectFile($config->this_file, $now['html_url']);
		writeRedirectFile($config->last_file, $last['html_url']);

		d($now['html_url']);
		d($last['html_url']);
	}
}

/**
 * Writes a file in $path which redirects to the given $url.
 *
 * @param $path
 * @param $url
 */
function writeRedirectFile($path, $url) {
	$file = fopen($path, "w");
	$html = '
<html>
	<head>
		<meta http-equiv="refresh" content="0; url='.$url.'" />
	</head>
</html>';
	fwrite($file, $html);
	fclose($file);
}

/**
 * Querys a $url and returns the result.
 *
 * @param $url
 * @return mixed
 */
function queryURL($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_URL, $url);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}

/**
 * Checks if a string contains a date. (1991-12-31)
 *
 * @param $str
 * @return bool
 */
function containsDate($str) {
	return preg_match('/(?<!\d)\d{4}-\d{2}-\d{2}(?!\d)/', $str) ? true : false;
}
