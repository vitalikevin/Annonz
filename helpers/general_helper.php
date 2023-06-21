<?php

// Fonction pour déterminer si un utilisateur est connecté
function isLogin() {
    return !empty($_SESSION['id']);
}

// Fonction pour déterminer si une annonce a été publiée par l'utilisateur connecté
function belongsTo($ad) {
    if (!empty($_SESSION)) {
    return ($_SESSION['id'] === $ad->getIdUser());
    }
    return false;
}
// Fonction pour déterminer si l'utilisateur connecté est un administrateur
function isAdmin() {
    if (!empty($_SESSION)) {
        return ($_SESSION['isAdmin'] == true);
    }
    return false;
}
