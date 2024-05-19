<?php
date_default_timezone_set('Europe/Lisbon');

function elapsedTime($datetime) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->getTimestamp() - $ago->getTimestamp();
    if ($diff < 60) {
        return $diff . ' seconds ago';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' minutes ago';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' hours ago';
    } else {
        return floor($diff / 86400) . ' days ago';
    }

}