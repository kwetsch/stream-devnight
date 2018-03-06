<?php

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

// Redirect('https://www.youtube.com/channel/UClfO4eoUUYEYOHtQuDY4hQg', false);
Redirect('https://www.youtube.com/watch?v=i2mZO5XJq6w', false);
