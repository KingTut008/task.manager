<?php

function viewTitle ($menuItems) {
    for ($i = 0; $i < count($menuItems) ; $i++) {
        if (checkUrl ($menuItems[$i]['path'])) {
            return $menuItems[$i]['title'];
        }
    }
}
