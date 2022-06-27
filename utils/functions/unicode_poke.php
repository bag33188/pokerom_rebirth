<?php

if (!function_exists('unicode_poke')) {
    function unicode_poke(string $text)
    {
        return preg_replace("/Poke/i", "Pok" . _EACUTE, $text);
    }
}

if (!function_exists('ununicode_poke')) {
    function ununicode_poke(string $text)
    {
        return preg_replace("/Pok\x{e9}/iu", "Poke", $text);
    }
}
