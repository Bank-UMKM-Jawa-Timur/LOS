<?php

return [
    'host' => env('SIPDE_HOST', ''),
    'username' => env('SIPDE_USERNAME', ''),
    'password' => env('SIPDE_PASSWORD', ''),
    'status' => [
        1 => 'Survey',
        2 => 'Analisa',
        3 => 'Disetujui',
        4 => 'Ditolak',
        5 => 'Realisasi',
        6 => 'Selesai',
        7 => 'Dibatalkan',
        8 => 'Ditindaklanjuti'
    ],
    'status_color' => [
        1 => 'text-black',
        2 => 'text-black',
        3 => 'text-green-500',
        4 => 'text-red-500',
        5 => 'text-gray-500',
        6 => 'text-green-500',
        7 => 'text-red-500',
        8 => 'text-secondary'
    ],
    'jenis_usaha' => [
        1 => 'Sektor Pertanian',
        2 => 'Sektor Peternakan',
        3 => 'Sektor Kelautan dan Perikanan',
        4 => 'Sektor Perkebunan',
        5 => 'Sektor Industri',
        6 => 'Sektor Perdagangan',
        7 => 'Sektor Makanan dan Minuman',
        8 => 'Sektor Koperasi',
        9 => 'Sektor Jasa dan Lainnya',
        10 => 'Sektor Lainnya',
    ],
    'tipe_pengajuan' => [
        2 => 'Perorangan',
        3 => 'Badan Usaha',
        4 => 'Kelompok Usaha',
    ],
];
