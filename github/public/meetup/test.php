<?php

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

Redirect('https://google.com', false);
// Redirect('https://www.meetup.com/de-DE/dev_night/events/242557041/', false);