<?php

use Carbon\Carbon;

if (! function_exists('formatTanggal')) {
    function formatTanggal($date, $withTime = true): string
    {
        if (! $date) {
            return '-';
        }

        $date = Carbon::parse($date)->timezone('Asia/Jakarta');

        return $withTime
            ? $date->translatedFormat('d F Y, H:i:s').' WIB'
            : $date->translatedFormat('d F Y');
    }
}
