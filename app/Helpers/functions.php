<?php

class functions
{
    public static function split($query)
    {
        $array = array();
        for ($i = 0; $i < mb_strlen($query, 'utf-8'); $i++) {
            $array[] = mb_substr($query, $i, 1, 'utf-8');
        }
        $str = "%";
        for ($i = 0; $i < count($array); $i++) {
            $str .= $array[$i] . '%';
        }
        return $str;
    }
}