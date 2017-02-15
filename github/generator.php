<?php

	require_once("vendor/autoload.php");

	// init api call
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/orgs/dev-night/repos');
	$result = curl_exec($ch);
	curl_close($ch);

	// convert json to a collection
	$repos =  collect(json_decode($result, true));

	// function to determine wheter a string contains a date or not
	function _containsDate($str) {
		return preg_match('/(?<!\d)\d{4}-\d{2}-\d{2}(?!\d)/', $str) ? true : false;
	}

	// sort all repos and filter out all repos which don't contain content from a /dev/night
	$repos = $repos->sortBy('created_at')->reverse()->filter(function($val, $key) {
		return _containsDate($val['name']);
	});

	$now = $repos->shift();
	$last = $repos->shift();

	d($now['html_url']);
	d($last['html_url']);


