<?php

use Illuminate\Support\Carbon;

if (!function_exists('dinero')){
    function dinero($s)
    {
        return number_format($s, 2, ',', ' ') . ' €';
    }
}

if (!function_exists('fecha')){
    function fecha($s)
    {
        return (new Carbon($s))->settings([
            'locale' => 'es_ES',
        ])->setTimeZone('Europe/Madrid')->format('d-m-Y');
    }
}

if (!function_exists('fecha_hora')){
    function fecha_hora($s)
    {
        return (new Carbon($s))->settings([
            'locale' => 'es_ES',
        ])->setTimeZone('Europe/Madrid')->format('d-m-Y H:i:s');
    }
}

if (!function_exists('tiempo')) {
    function tiempo($t)
    {
        $hours = floor($t / 3600);
        $minutes = floor(($t % 3600) / 60);
        $seconds = $t % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
