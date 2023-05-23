<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanApiController extends Controller
{
    public function index()
    {
        $qr = Pengumuman::latest()->get();
        // dd($qr);
        $qr = PengumumanResource::collection($qr);

        return response()->json(buildResponseSukses($qr),200);
    }

    public function count()
    {
        $count = Pengumuman::whereDate('created_at', date('Y-m-d'))->count();
        return response()->json(buildResponseSukses(['count' => $count]),200);
    }

    public function detail(Pengumuman $pengumuman)
    {
        $pengumuman = PengumumanResource::make($pengumuman);
        return response()->json(buildResponseSukses($pengumuman),200);
    }
}
