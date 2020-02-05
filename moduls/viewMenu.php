<?php

function sortMenuItemsDecrease ($firstItems, $secondItems) {
    if ($firstItems['sort'] == $secondItems['sort']) {
        return 0;
    }
    return ($firstItems['sort'] > $secondItems['sort']) ? -1 : 1;
}

function sortMenuItemsIncrease ($firstItems, $secondItems) {
    if ($firstItems['sort'] == $secondItems['sort']) {
        return 0;
    }
    return ($firstItems['sort'] < $secondItems['sort']) ? -1 : 1;
}

function checkUrl ($myLink) {
    return $myLink == parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

function menuShort ($title, $len = 15) {
    if (mb_strlen($title) > $len) {
        $title = mb_substr($title, 0, $len - 3) . "...";
        return $title;
    } else {
         return $title;
    }
}

function viewMenu ($menuItems, $sortBy , $ulClass) {
    uasort($menuItems, $sortBy == 'Increase' ? 'sortMenuItemsIncrease' : 'sortMenuItemsDecrease' );
    include $_SERVER['DOCUMENT_ROOT'].'/template/menu.php';
}
