<?php
/**
 * Fonction qui formate une date donnée
 *
 * @param string $origDate
 * @return string
 */
function formatDate(string $origDate): string
{
    // On définit la langue du site
    setlocale(LC_TIME, 'FR_fr');

    // On formate la date dans la langue choisie
    $newdate = strftime('%A %d %B %Y - %T', strtotime($origDate));

    // On encode en UTF-8 pour gérer les caractères spéciaux
    $newdate = utf8_encode($newdate);

    // On retourne la date formatée
    return $newdate;
}