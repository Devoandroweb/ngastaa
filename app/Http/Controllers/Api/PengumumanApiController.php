<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use App\Repositories\Pengumuman\PengumumanRepository;
use Illuminate\Http\Request;

class PengumumanApiController extends Controller
{
    protected $pengumumanRepository;
    function __construct(
        PengumumanRepository $pengumumanRepository,
    ){
        $this->pengumumanRepository = $pengumumanRepository;

    }
    public function index()
    {
        $data = $this->pengumumanRepository->getPengumuman();
        return response()->json(buildResponseSukses($data),200);
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
