<?php
include "admin/includes/config.php";

$result = $pdo->prepare("SELECT url FROM link");
$result->execute();

/* Fetch all of the remaining rows in the result set */
while ($row = $result->fetch(PDO::FETCH_ASSOC))
{
    $youtube = $row['url'];
}
function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}
Redirect($youtube, false);
?>