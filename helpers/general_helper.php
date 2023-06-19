<?php

function isLogin() {
    return !empty($_SESSION['id']);
}

function belongsTo($ad) {
    if (!empty($_SESSION)) {
    return ($_SESSION['id'] === $ad->getIdUser());
    }
    return false;
}

function isAdmin() {
    if (!empty($_SESSION)) {
        return ($_SESSION['isAdmin'] == true);
    }
    return false;
}