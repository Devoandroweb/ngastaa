<?php

namespace Tests\Feature;

use App\Models\Pegawai\Keluarga;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPmk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $nip = "001000";
        $keluarga = Keluarga::max("id");
        $riwayatKursus = RiwayatKursus::max("id");
        $riwayatOrganisasi = RiwayatOrganisasi::max("id");
        $riwayatPendidikan = RiwayatPendidikan::max("id");
        $id_pendidikan = $riwayatPendidikan;
        $riwayatPmk = RiwayatPmk::max("id");
        $endpoints = [
            "GET" => [
                "api/absen/$nip",
                "api/aktifitas",
                "api/aktifitas/lists-opd",
                "api/calculate-presensi",
                "api/check-status-absen/$nip",
                "api/divisi/list",
                "api/keluarga/semua/delete/$keluarga",
                "api/keluarga/semua/list",
                "api/kursus/delete/$riwayatKursus",
                "api/kursus/list",
                "api/kursus/list-master-kursus",
                "api/list-lokasi-visit",
                "api/organisasi/delete/$riwayatOrganisasi",
                "api/organisasi/list",
                "api/password-check/$nip",
                "api/payroll-client",
                "api/payroll-client/detail",
                "api/pegawai/list-opd",
                "api/pendidikan/delete/$riwayatPendidikan",
                "api/pendidikan/list",
                "api/pendidikan/list-jurusan/$id_pendidikan",
                "api/pendidikan/list-master-pendidikan",
                "api/pengajuan/cuti",
                "api/pengajuan/cuti/detail",
                "api/pengajuan/cuti/lists",
                "api/pengajuan/cuti/lists-opd",
                "api/pengajuan/lembur/detail",
                "api/pengajuan/lembur/lists",
                "api/pengajuan/lembur/lists-opd",
                "api/pengajuan/reimbursement",
                "api/pengajuan/reimbursement/detail",
                "api/pengajuan/reimbursement/lists",
                "api/pengajuan/shift",
                "api/pengajuan/shift/detail",
                "api/pengajuan/shift/list-master-shift/$nip",
                "api/pengajuan/shift/lists",
                "api/pengajuan/shift/lists-opd",
                "api/pengalaman-kerja/delete/$riwayatPmk",
                "api/pengalaman-kerja/list",
                "api/perusahaan",
                "api/presensi",
                "api/presensi/existing-presensi-day/$nip",
                "api/presensi/lists",
                "api/presensi/lists-opd",
                "api/presensi/lokasi",
                "api/presensi/shift",
                "api/profil-detail/$nip",
                "api/profil/$nip",
                "api/riwayat-presensi/$nip",
                "api/total-presensi/$nip",
                "api/visit",
                "api/visit/lokasi",
                "api/whatsapp/check-no-wa",
                // Tambahkan endpoint GET lainnya di sini
            ],
            // 'POST' => [
            //     '/api/endpoint3' => ['param1' => 'value1', 'param2' => 'value2'],
            //     // Tambahkan endpoint POST lainnya di sini
            // ],
            // Tambahkan metode HTTP lainnya jika diperlukan
        ];
        foreach ($endpoints as $method => $routes) {
            foreach ($routes as $route => $params) {
                $start = microtime(true);

                if ($method === 'GET') {
                    $response = $this->json('GET', $route);
                }
                //  elseif ($method === 'POST') {
                //     $response = $this->json('POST', $route, $params);
                // }
                // Tambahkan kondisi untuk metode HTTP lainnya

                $end = microtime(true);
                $duration = $end - $start;
           
                echo "Endpoint: $params ===>, Method: $method, Time: $duration seconds | ".$response->status()."\n";

                // $response->assertStatus(200);
            }
        }
    }
}
