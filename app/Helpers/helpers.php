<?php

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka, $prefix = 'Rp ')
    {
        return $prefix . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($tanggal, $format = 'd M Y')
    {
        if (!$tanggal) return '-';
        return \Carbon\Carbon::parse($tanggal)->translatedFormat($format);
    }
}

if (!function_exists('format_tanggal_indo')) {
    function format_tanggal_indo($tanggal)
    {
        if (!$tanggal) return '-';
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $date = \Carbon\Carbon::parse($tanggal);
        return $date->day . ' ' . $bulan[$date->month] . ' ' . $date->year;
    }
}