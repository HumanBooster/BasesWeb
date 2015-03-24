<?php

/**
 * Who needs functions when you have classes ?
 */

/**
 * Underscore to camelCase
 * 
 * @param string $str String to convert
 * @return string Converted string to camelCase
 */
function us2cc($str) {
// si la chaine ne contient pas de "_", on la renvoie telle quelle
    if (strpos($str, "_") === false)
        return $str;

// sinon on explose la chaine dans un tableau
// autour du délimiteur "_"
    $words = explode("_", $str);

// le compteur permet de différencier le premier mot (0)
    $count = 0;
// puis on concatène en camelCase
    foreach ($words as $word) {
// premier mot ) prendre tel quel
        if ($count == 0)
            $result = $word;
// mots suivants à capitaliser
        else
            $result .= ucfirst($word);
        $count++;
    }
    return $result;
}

/**
 * CamelCase to Underscore
 * 
 * @param string $str camelCase string to convert
 * @return string string converted to underscore
 */
function cc2us($str) {
// this is clearly black magic !
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $str, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}
