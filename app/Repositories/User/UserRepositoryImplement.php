<?php

namespace App\Repositories\User;

use App\Models\Master\Eselon;
use App\Models\MJadwalShift;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\Pegawai\RiwayatShift;
use App\Repositories\JamKerja\JamKerjaRepository;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImplement extends Eloquent implements UserRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property User|mixed $mUser;
    */
    protected $mUser;
    protected $mRiwayatKerja;
    protected $mRiwayatShift;
    protected $mJadwalShift;
    protected $jamKerjaRepository;

    public function __construct(
        User $mUser,
        RiwayatJamKerja $mRiwayatKerja,
        RiwayatShift $mRiwayatShift,
        MJadwalShift $mJadwalShift,
        JamKerjaRepository $jamKerjaRepository,
    )
    {
        $this->mUser = $mUser;
        $this->mRiwayatKerja = $mRiwayatKerja;
        $this->mRiwayatShift = $mRiwayatShift;
        $this->mJadwalShift = $mJadwalShift;
        $this->jamKerjaRepository = $jamKerjaRepository;
    }
    function getUserWithIndentity($user){
        $nip = $user->nip;
        $jabatan = null;
        $kode_tingkat = "-";
        if($user){
            $jabatan = array_key_exists('0', $user?->jabatan_akhir->toArray()) ? $user?->jabatan_akhir[0] : null;
        }
        if($jabatan == null){
            $jabatan = "-";
        }else{
            $kode_tingkat = $jabatan->tingkat?->kode_tingkat;

            $jabatan = ((is_null($jabatan->tingkat?->nama)) ? "-" : $jabatan->tingkat?->nama);
        }

        $jadwalShift = $this->mJadwalShift->where(['tanggal'=>date('Y-m-d'),'nip'=>$nip])->first();

        $namaShift = "-";
        $jamShift = "-";

        if($jadwalShift){
            $namaShift = (is_null($jadwalShift)) ? "-" : $jadwalShift->shift?->nama;
            $jamShift = (is_null($jadwalShift)) ? "-" : date("H:i",strtotime($jadwalShift->shift?->jam_tepat_datang))." - ".date("H:i",strtotime($jadwalShift->shift?->jam_tepat_pulang));
        }else{
            $RjamKerja = $this->mRiwayatKerja::where('is_akhir',1)->where('nip',$nip)->first(["kode_jam_kerja"]);
            if($RjamKerja != null){
                $jamKerja = $RjamKerja->jamKerja;
                if($jamKerja != null){
                    $jamKerjaHariIni = $this->jamKerjaRepository->searchHariJamKerja($RjamKerja->kode_jam_kerja,date("N"));
                    $namaShift = (is_null($jamKerjaHariIni)) ? "-" : $jamKerja?->nama;

                    $jamShift = (is_null($jamKerjaHariIni)) ? "-" : date("H:i",strtotime($jamKerjaHariIni?->jam_tepat_datang))." - ".date("H:i",strtotime($jamKerjaHariIni?->jam_tepat_pulang));
                }
            }else{
                $shift = $this->mRiwayatShift::with('shift')->where('is_akhir',1)->where('nip',$nip)->first();
                if($shift->shift != null){
                    $namaShift = (is_null($shift)) ? "-" : $shift->shift?->nama;
                    $jamShift = (is_null($shift)) ? "-" : date("H:i",strtotime($shift->shift?->jam_tepat_datang))." - ".date("H:i",strtotime($shift->shift?->jam_tepat_pulang));
                }
            }
        }
        if(file_exists(public_path($user->image))){
            $image = url("public/{$user->image}");
        }else{
            $image = asset("/dist/img/logo_lets_work_greyscale.png");
        }
        $data = [
            'nip' => $user->nip,
            'nama' => $user->getFullName(),
            'foto' => $image,
            'jabatan' => $jabatan,
            'kode_tingkat' => $kode_tingkat,
            'nama_shift' => $namaShift,
            'jam_shift' => $jamShift,
            'waktu_server' => hari(date('N')).", ".tanggal_indo(date("Y-m-d")),
            'status_password'=>!Hash::check($nip, $user->password),
            'access_opd'=>$this->eselonVeryLow($user)
        ];
        return $data;
    }
    function eselonVeryLow($user){
        $maksLevelJabatan = Eselon::max('kode_eselon');
        if((int)$user->getEselon() < (int)$maksLevelJabatan){
            return true;
        }
        return false;
    }
    // Write something awesome :)
}
