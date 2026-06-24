<?php

function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) return "hace unos segundos";
    if ($time < 3600) return "hace " . floor($time / 60) . " min";
    if ($time < 86400) return "hace " . floor($time / 3600) . " h";
    return "hace " . floor($time / 86400) . " días";
}