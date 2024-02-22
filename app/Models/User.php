<?php

namespace App\Models;

use App\Models\Master\StatusPegawai;
use App\Models\Master\Suku;
use App\Models\Payroll\DataPayroll;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPengajuanLembur;
use App\Models\Pegawai\Keluarga;
use App\Models\Pegawai\RiwayatBahasa;
use App\Models\Pegawai\RiwayatGolongan;
use App\Models\Pegawai\RiwayatJabatan;
use App\Models\Pegawai\RiwayatJamKerja;
use App\Models\Pegawai\RiwayatKgb;
use App\Models\Pegawai\RiwayatKursus;
use App\Models\Pegawai\RiwayatOrganisasi;
use App\Models\Pegawai\RiwayatPendidikan;
use App\Models\Pegawai\RiwayatPenghargaan;
use App\Models\Pegawai\RiwayatPmk;
use App\Models\Pegawai\RiwayatShift;
use App\Models\Pegawai\RiwayatStatus;
use App\Models\Presensi\TotalCutiDetail;
use App\Models\Presensi\TotalPresensi;
use App\Models\Presensi\TotalPresensiDetail;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes, CreatedUpdatedBy;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'images',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'nip';
    }

    public function riwayat_golongan()
    {
        return $this->hasMany(RiwayatGolongan::class, 'nip', 'nip');
    }

    public function riwayat_jabatan()
    {
        return $this->hasMany(RiwayatJabatan::class, 'nip', 'nip');
    }

    public function riwayat_pendidikan()
    {
        return $this->hasMany(RiwayatPendidikan::class, 'nip', 'nip')->orderByDesc('kode_pendidikan');

    }

    public function riwayat_shift()
    {
        return $this->hasMany(RiwayatShift::class, 'nip', 'nip')->orderByDesc('kode_shift');
    }
    public function riwayat_pmk()
    {
        return $this->hasMany(RiwayatPmk::class, 'nip', 'nip');
    }
    public function riwayat_kursus()
    {
        return $this->hasMany(RiwayatKursus::class, 'nip', 'nip');
    }
    public function riwayat_organisasi()
    {
        return $this->hasMany(RiwayatOrganisasi::class, 'nip', 'nip');
    }
    public function riwayat_penghargaan()
    {
        return $this->hasMany(RiwayatPenghargaan::class, 'nip', 'nip');
    }
    public function riwayat_bahasa()
    {
        return $this->hasMany(RiwayatBahasa::class, 'nip', 'nip');
    }
    public function keluarga()
    {
        return $this->hasMany(Keluarga::class, 'nip', 'nip');
    }

    public function riwayat_status()
    {
        return $this->hasMany(RiwayatStatus::class, 'nip', 'nip');
    }

    public function pengajuan_cuti()
    {
        return $this->hasMany(DataPengajuanCuti::class, 'nip', 'nip');
    }

    public function pengajuan_lembur()
    {
        return $this->hasMany(DataPengajuanLembur::class, 'nip', 'nip');
    }

    public function data_payroll()
    {
        return $this->hasMany(DataPayroll::class, 'nip', 'nip');
    }

    public function suku()
    {
        return $this->belongsTo(Suku::class, 'kode_suku', 'kode_suku');
    }

    public function jabatan_akhir()
    {
        return $this->riwayat_jabatan()->where('is_akhir', 1);
    }

    public function pendidikan_akhir()
    {
        return $this->riwayat_pendidikan()->where('is_akhir', 1);
    }
    public function shift_akhir()
    {
        return $this->riwayat_shift()->where('is_akhir', 1);
    }

    public function golongan_akhir()
    {
        return $this->riwayat_golongan()->where('is_akhir', 1);
    }
    public function getFullName()
    {
        $gelar_depan = ($this->gelar_depan != "") ? $this->gelar_depan." " :"";
        $gelar_belakang = ($this->gelar_belakang != "") ? " ".$this->gelar_belakang :"";
        return "{$gelar_depan}{$this->name}{$gelar_belakang}";
    }
    function getNamaJabatan(){
        $jabatan = array_key_exists('0', $this->jabatan_akhir->toArray()) ? $this->jabatan_akhir[0] : null;
        if( $jabatan != null){
            return  ((is_null($jabatan->tingkat?->nama)) ? null : $jabatan->tingkat?->nama);
        }
        return null;
    }
    function getNamaDivisi(){
        $jabatan = array_key_exists('0', $this->jabatan_akhir->toArray()) ? $this->jabatan_akhir[0] : null;
        if( $jabatan != null){
            $skpd = $jabatan?->skpd?->nama;
            return $skpd;
        }
        return null;
    }
    function getJabatan(){
        $jabatan = array_key_exists('0', $this->jabatan_akhir->toArray()) ? $this->jabatan_akhir[0] : null;
        if( $jabatan != null){
            return  ((is_null($jabatan->tingkat)) ? null : $jabatan->tingkat);
        }
        return null;
    }
    function getDivisi(){
        $jabatan = array_key_exists('0', $this->jabatan_akhir->toArray()) ? $this->jabatan_akhir[0] : null;
        if( $jabatan != null){
            $skpd = $jabatan?->skpd;
            return $skpd;
        }
        return null;

    }

    function getRiwayatLokasiKerja(){
        // return $this->hasMany(Lokasi::class,'kode_lokasi','')
    }
    public function getImagesAttribute()
    {
        return $this->image ? asset("storage/$this->image") : asset("no-image.png");
    }
    function totalPresensi(){
        return $this->hasOne(TotalPresensi::class,'nip','nip');
    }
    function totalPresensiDetail(){
        return $this->hasMany(TotalPresensiDetail::class,'nip','nip');
    }
    // function totalIzinDetail(){
    //     return $this->hasMany(TotalCutiDetail::class,'nip','nip');
    // }
    function statusPegawai(){
        return $this->hasOne(StatusPegawai::class,'kode_status','kode_status');
    }
    // function jamKerja(){
    //     return $this->hasOne(MJamKerja::class,'nip','nip');
    // }

    function jamKerja(){
        return $this->hasMany(RiwayatJamKerja::class,'nip','nip');
    }
    function shift(){
        return $this->hasMany(RiwayatShift::class,'nip','nip');
    }
    function jadwalShift(){
        return $this->hasMany(MJadwalShift::class,'nip','nip');
    }
    function foto(){
        $jk = str_replace(" ","",$this->jenis_kelamin);
        $foto = $this->image;
        // dd($foto,file_exists(public_path("../$foto")));
        if($foto == null || $foto == "" || $foto == "NULL" || !file_exists(public_path("../$foto"))){
            if(strtolower($jk) == "laki-laki"){
                return asset('/dist/img/man.png');
            }elseif(strtolower($jk) == "perempuan"){
                return asset('/dist/img/woman.png');
            }else{
                return asset('/dist/img/man.png');
            }
        }
        return url("$foto");
        // return $foto;
    }
    function lokasiKerja(){
        return $this->hasOne(MapLokasiKerja::class,'nip','nip');
    }

}
