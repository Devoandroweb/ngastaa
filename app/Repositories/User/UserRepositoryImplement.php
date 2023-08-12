<?php

namespace App\Repositories\User;

use App\Models\MJadwalShift;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\Pegawai\RiwayatShift;
use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

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

    public function __construct(
        User $mUser,
        RiwayatJamKerja $mRiwayatKerja,
        RiwayatShift $mRiwayatShift,
        MJadwalShift $mJadwalShift,
    )
    {
        $this->mUser = $mUser;
        $this->mRiwayatKerja = $mRiwayatKerja;
        $this->mRiwayatShift = $mRiwayatShift;
        $this->mJadwalShift = $mJadwalShift;
    }
    function getUserWithIndentity($nip){
        $user = User::role('pegawai')->where('nip', $nip)->with('jabatan_akhir','jamKerja')->has('jabatan_akhir')->first();
        //code...
        $kode_tingkat = "-";
        $jabatan = array_key_exists('0', $user->jabatan_akhir->toArray()) ? $user->jabatan_akhir[0] : null;

        if( $jabatan == null){
            $jabatan = "-";
        }else{
            $kode_tingkat = $jabatan->tingkat?->kode_tingkat;

            $jabatan = ((is_null($jabatan->tingkat?->nama)) ? "-" : $jabatan->tingkat?->nama);
        }

        $jadwalShift = $this->mJadwalShift->where(['tanggal'=>date('Y-m-d'),'nip'=>$nip])->first();
        $RjamKerja = $this->mRiwayatKerja::with('jamKerja')->where('is_akhir',1)->where('nip',$nip)->orderBy('created_at','desc')->first();
        $shift = $this->mRiwayatShift::with('shift')->where('is_akhir',1)->where('nip',$nip)->orderBy('created_at','desc')->first();

        $namaShift = "-";
        $jamShift = "-";

        if($jadwalShift){
            $namaShift = (is_null($jadwalShift)) ? "-" : $jadwalShift->shift?->nama;
            $jamShift = (is_null($jadwalShift)) ? "-" : date("H:i",strtotime($jadwalShift->shift?->jam_tepat_datang))." - ".date("H:i",strtotime($jadwalShift->shift?->jam_tepat_pulang));
        }elseif($RjamKerja != null){
            if($RjamKerja->jamKerja != null){
                $namaShift = (is_null($RjamKerja)) ? "-" : $RjamKerja->jamKerja?->nama;
                $jamShift = (is_null($RjamKerja)) ? "-" : date("H:i",strtotime($RjamKerja->jamKerja?->jam_tepat_datang))." - ".date("H:i",strtotime($RjamKerja->jamKerja?->jam_tepat_pulang));
            }
        }elseif($shift != null){
            if($shift->shift != null){
                $namaShift = (is_null($shift)) ? "-" : $shift->shift?->nama;
                $jamShift = (is_null($shift)) ? "-" : date("H:i",strtotime($shift->shift?->jam_tepat_datang))." - ".date("H:i",strtotime($shift->shift?->jam_tepat_pulang));
            }
        }
        if(file_exists(public_path($user->image))){
            $image = url("public/{$user->image}");
        }else{
            $image = asset("/dist/img/logo_lets_work_greyscale.png");
        }
        $data = [
            'nama' => $user->getFullName(),
            'foto' => $image,
            'jabatan' => $jabatan,
            'kode_tingkat' => $kode_tingkat,
            'nama_shift' => $namaShift,
            'jam_shift' => $jamShift,
            'waktu_server' => hari(date('N')).", ".tanggal_indo(date("Y-m-d"))
        ];
        return $data;
    }
    // Write something awesome :)
}
