<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $majors = [
            ['name' => 'Teknik Informatika', 'field' => 'Teknologi', 'desc' => 'Mempelajari pemrograman, jaringan, dan pengembangan sistem.'],
            ['name' => 'Sistem Informasi', 'field' => 'Teknologi', 'desc' => 'Menggabungkan teknologi informasi dengan kebutuhan bisnis.'],
            ['name' => 'Kedokteran', 'field' => 'Kesehatan', 'desc' => 'Mempelajari ilmu medis dan perawatan pasien.'],
            ['name' => 'Keperawatan', 'field' => 'Kesehatan', 'desc' => 'Mempelajari asuhan keperawatan dan pelayanan kesehatan.'],
            ['name' => 'Manajemen', 'field' => 'Bisnis', 'desc' => 'Mempelajari pengelolaan organisasi dan bisnis.'],
            ['name' => 'Akuntansi', 'field' => 'Bisnis', 'desc' => 'Mempelajari pencatatan dan analisis keuangan.'],
            ['name' => 'Psikologi', 'field' => 'Sosial', 'desc' => 'Mempelajari perilaku dan proses mental manusia.'],
            ['name' => 'Desain Komunikasi Visual', 'field' => 'Seni & Desain', 'desc' => 'Mempelajari desain grafis, ilustrasi, dan komunikasi visual.'],
        ];

        if ($q = trim((string) $request->query('q'))) {
            $majors = array_filter($majors, fn ($m) =>
                stripos($m['name'], $q) !== false || stripos($m['field'], $q) !== false
            );
        }

        return view('majors.index', compact('majors'));
    }
}