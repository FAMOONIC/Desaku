<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $sosial = session('sosial', []);
    $totalSosial = count($sosial);

    $thisMonth = date('Y-m');
    $monthCount = 0;
    $perMonth = [];
    foreach ($sosial as $it) {
        $m = date('Y-m', strtotime($it['tanggal'] ?? $it['created_at']));
        if (!isset($perMonth[$m])) $perMonth[$m] = 0;
        $perMonth[$m]++;
        if ($m == $thisMonth) $monthCount++;
    }
    ksort($perMonth);

    return view('dashboard.admin', compact('totalSosial','monthCount','perMonth'));
}


}
