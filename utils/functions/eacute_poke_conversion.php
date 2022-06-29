<?php

if (!function_exists('unicode_poke')) {
    /**
     * Converts the **e** to **&eacute;** in the word _Poke_
     *
     * @param string $text
     * @return string
     */
    function unicode_poke(string $text): string
    {
        return preg_replace("/Poke/i", "Pok" . _EACUTE, $text);
    }
}

if (!function_exists('ununicode_poke')) {
    /**
     * Converts the **&eacute;** to **e** in the word _Pok&eacute;_
     *
     * @param string $text
     * @return string
     */
    function ununicode_poke(string $text): string
    {
        return preg_replace("/Pok\x{e9}/iu", "Poke", $text);
    }
}
