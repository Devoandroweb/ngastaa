<?php

use App\Models\Perusahaan;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

function role($string)
{
    // auth()->user()->assignRole('pegawai');
    $arrayRole = auth()->user()->getRoleNames()->toArray();
    
    // dd($arrayRole);
    if(in_array($string, $arrayRole)){
        return true;
    }else{
        return false;
    }
}

function storage($file)
{
    return $file ? asset("storage/$file") : asset("no-image.png");
}

function jenis_jabatan($kode)
{
    switch ($kode) {
        case '1':
            return "Struktural";
            break;
        case '2':
            return "Fungsional";
            break;
        case '4':
            return "Pelaksana";
            break;

        default:
            return "Err";
            break;
    }
}

function status($kode)
{
    switch ($kode) {
        case '0':
            return "Diajukan";
            break;
        case '1':
            return "Diterima";
            break;
        case '2':
            return "Ditolak";
            break;

        default:
            return "Err";
            break;
    }
}

function status_web($kode)
{
    switch ($kode) {
        case '0':
            return "<span class='badge badge-primary'>Diajukan</span>";
            break;
        case '1':
            return "<span class='badge badge-success'>Diterima</span>";
            break;
        case '2':
            return "<span class='badge badge-danger'>Ditolak</span>";
            break;

        default:
            return "Err";
            break;
    }
}

function is_aktif($kode)
{
    switch ($kode) {
        case '0':
            return "<span class='badge badge-danger'>Tidak Aktif</span>";
            break;
        case '1':
            return "<span class='badge badge-success'>Aktif</span>";
            break;

        default:
            return "Err";
            break;
    }
}


function limitdecimal($number, $limit = 2)
{
    return number_format((float)$number, $limit, '.', '');
}

function pembulatan($number, $limit = -2)
{
    return round($number, $limit);
}

function number_to_sql($num)
{
    if ($num == '') {
        return 0;
    }
    $exp = explode('.', $num);
    if(strlen($exp[count($exp) - 1]) == 2 && strlen($num) > 2){
        $num = substr($num, 0, -3);
    }
    $delDot = str_replace('.', '', $num);
    $delCom = str_replace(',', '.', $delDot);
    return (double) $delCom;
}

function number_indo($num, $des = 0)
{
    if($des == 0){
        if($num <= 100){
            $des = 2;
        }
    }

    return number_format($num, $des, ',', '.');
}

function tanggal_indo($date)
{
    if($date != ""){
        $tgl = date('d', strtotime($date));
        $bulan = date('m', strtotime($date));
        $tahun = date('Y', strtotime($date));
    
        return $tgl . " " . bulan($bulan) . " " . $tahun;
    }else{
        return " - ";
    }
}

function getAgama()
{
    return [
        'islam',
        'protestan',
        'katholik',
        'hindu',
        'budha',
        'konghucu',
        'lainnya',
    ];
}

function hari($hari)
{
    switch ($hari) {
        case 1:
            return "Senin";
            break;
        case 2:
            return "Selasa";
            break;
        case 3:
            return "Rabu";
            break;
        case 4:
            return "Kamis";
            break;
        case 5:
            return "Jumat";
            break;
        case 6:
            return "Sabtu";
            break;
        case 0:
            return "Minggu";
            break;
    }
}

function bulan($bln)
{
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function terbilang($x)
{
    $abil = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    if ($x < 12)
        return " " . $abil[$x];
    elseif ($x < 20)
        return Terbilang($x - 10) . " Belas";
    elseif ($x < 100)
        return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
    elseif ($x < 200)
        return " Seratus" . Terbilang($x - 100);
    elseif ($x < 1000)
        return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
    elseif ($x < 2000)
        return " Seribu" . Terbilang($x - 1000);
    elseif ($x < 1000000)
        return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
    elseif ($x < 1000000000)
        return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
    elseif ($x < 1000000000000)
        return Terbilang($x / 1000000000) . " Milyar" . Terbilang($x % 1000000000);
    elseif ($x < 1000000000000000)
        return Terbilang($x / 1000000000000) . " Triliyun" . Terbilang($x % 1000000000000);
}

function hitung_tahun($start, $end)
{
    $date = new DateTime($start);
    $now = new DateTime($end);
    $interval = $now->diff($date);
    return $interval->y;
}

function hitung_jam_menit($start, $end)
{
    $date = new DateTime($start);
    $now = new DateTime($end);
    $interval = $now->diff($date);
    $jam = $interval->h;
    if($interval->i > 30){
        $jam += 1;
    }
    return $jam;
}

function get_jam($tanggal)
{
    return $tanggal ? date("H:i", strtotime($tanggal)) : "-";
}

function getBetweenDates($startDate, $endDate)
{

    $rangArray = [];
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate);

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }

    return $rangArray;
}

function arrayToString($array)
{
    $wNin = "";
    foreach ($array as $k => $w) {
        if (count($array) - 1 == $k) {
            $wNin .= "'$w'";
        } else {
            $wNin .= "'$w', ";
        }
    }

    return $wNin;
}

function satuan($id)
{
    switch ($id) {
        case '1':
            return "Rupiah";
            break;
        case '2':
            return "Persen";
            break;
        
        default:
            return "";
            break;
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateUUID() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

function getPerusahaan()
{
    return Perusahaan::first() ?? new Perusahaan();
}
function includeAsJsString($template,$data = null)
{
    $string = view(strtolower($template),['data'=>$data]);
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
}
function GenerateOptionMont($b=0) 
{
    $htmlOption = "";
    for ($i=1; $i<13 ; $i++) { 
        $bln = bulan($i);
        if ($i==$b) {
            $htmlOption .= "<option value='".$i."' selected>".$bln."</option>";
        }else{
            $htmlOption .= "<option value='".$i."'>".$bln."</option>";
        }

    }
    return $htmlOption;

}


function GenerateOptionYear($t=0)
{
    $yearOption = "";
    $tahun = date('Y');
    if($t == 0){
        $t = $tahun;
    }
    for ($i=2000; $i <= $tahun; $i++) { 
        if ($i==$t) {
            $yearOption .= "<option value='".$i."' selected>Tahun ".$t."</option>";
        }else{
            $yearOption .= "<option value='".$i."'>Tahun ".$i."</option>";
        }
    } 
    return $yearOption;
}

function GenerateKetarangan($keterangan = "")
{
    $options = [
        [ "value"=>'0', "keterangan"=>'semua', "label"=>'Semua Pegawai' ],
        [ "value"=>'1', "keterangan"=>'1', "label"=>'Pegawai Tertentu' ],
        [ "value"=>'2', "keterangan"=>'2', "label"=>'Tingkat Jabatan' ],
        [ "value"=>'3', "keterangan"=>'3', "label"=>'Level Jabatan' ],
        [ "value"=>'4', "keterangan"=>'4', "label"=>'Divisi Kerja' ],
    ];
    $htmlOption = "";
    foreach ($options as $s) {
        
        if ($keterangan == $s['value']) {
            $htmlOption .= "<option value='" . $s['value'] . "' selected>" . $s['label'] . "</option>";
        } else {
            $htmlOption .= "<option value='" . $s['value'] . "'>" . $s['label'] . "</option>";
        }
    }
    return $htmlOption;
}
function generateJenisOrganisasi($jenisorganisasi = '' )
{
    
    $options = [
        [ "value" => 'sosial', "jenis_organisasi"=> 'sosial', "label"=> 'Sosial' ],
        [ "value" => 'profesi', "jenis_organisasi"=> 'profesi', "label"=> 'Profesi'],
    ];
    $htmlOption = "";
    foreach ($options as $s) {
        
        if ($jenisorganisasi  == $s['value']) {
            $htmlOption .= "<option value='" . $s['value'] . "' selected>" . $s['label'] . "</option>";
        } else {
            $htmlOption .= "<option value='" . $s['value'] . "'>" . $s['label'] . "</option>";
        }
    }
    return $htmlOption;
}
function formatPhone($phone_no){
    $format_phone =
    substr($phone_no, -10, -7) . "-" .
    substr($phone_no, -7, -4) . "-" .
    substr($phone_no, -4);
    return $phone_no;
}
function formatDateIndo($date = null){
    if(!is_null($date)){
        return date("d/m/Y", strtotime($date));
    }
    return date("d/m/Y");
}
function isPrivateBagde($value = 0){
    return ($value == 0) ? "<span class='badge badge-danger'>Tidak</span>":"<span class='badge badge-success'>Ya</span>";
}
function isActifBagde($value = 0){
    return ($value == 0) ? "<span class='badge badge-danger'>Tidak Aktif</span>":"<span class='badge badge-success'>Aktif</span>";
}
function activeMenu($key = "")
{
    $urlPath = Request::path();
    $urlPathArray = explode("/",$urlPath);
    if("presensi" == $key){
        $menuIngore = ["laporan-pegawai","laporan-divisi","total_presensi","rekapabsen","laporan-visit"];
        foreach ($menuIngore as $v) {
            $index = array_search($v,$urlPathArray);
            if($index){
                return "";
            }
        }
        // dd("ini presensi");
        // dd(in_array($key,$urlPathArray));
        if(in_array($key,$urlPathArray)){
            return "active";
        }
    }
    if(in_array("presensi",$urlPathArray)){
        unset($urlPathArray[0]);
        $urlPathArray[0] = "presensi";
        if(in_array($key,$urlPathArray)){
            return "active";
        }
    }
    if($key == "payroll"){
        if(in_array("master",$urlPathArray)){
            return "";
        }
    }
    if(in_array($key,$urlPathArray)){
        return "active";
    }
    
    return "";
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function getColor($index)
{

    $color = [
        '#ff0000',
        '#008FFB',
        '#e92990',
        '#c02ff3',
        '#7429f8',
        '#F5EAEA',
        '#FFB84C',
        '#F16767',
        '#A459D1',
        '#9A1663',
        '#E0144C',
        '#FF5858',
        '#FF97C1',
        '#EA047E',
        '#FF6D28',
        '#FCE700',
        '#00F5FF',
        '#243763',
        '#FF6E31',
        '#FFEBB7',
        '#AD8E70',
    ];
    return $color[$index];
}
function generateStatusAbsen($status)
{
    switch ($status) {
        case 1:
            return '<span class="badge badge-success badge-pill badge-outline">Masuk</span>';
            break;
        case 2:
            return '<span class="badge badge-warning badge-pill badge-outline">Telat</span>';
            break;
        case 3:
            return '<span class="badge badge-danger badge-pill badge-outline">Tidak Masuk</span>';
            break;
        case 4:
            return '<span class="badge badge-dark badge-pill badge-outline">Izin</span>';
            break;
        default:
            break;
    }
}
function convertStatusAbsen($status)
{
    switch ($status) {
        case 1:
            return 'Masuk';
            break;
        case 2:
            return 'Telat';
            break;
        case 3:
            return 'Tidak Masuk';
            break;
        case 4:
            return 'Izin';
            break;
        default:
            break;
    }
}
function Generatewilayah($t=0)
{
    $yearOption = "";
    $tahun = date('Y');
    if($t == 0){
        $t = $tahun;
    }
    for ($i=2000; $i <= $tahun; $i++) { 
        if ($i==$t) {
            $yearOption .= "<option value='".$i."' selected>Tahun ".$t."</option>";
        }else{
            $yearOption .= "<option value='".$i."'>Tahun ".$i."</option>";
        }
    } 
    return $yearOption;
}


function buildResponseSukses($data){
    return [
        'status' => TRUE,
        'message' => "Success",
        'data' => $data
    ];
}
function buildResponseGagal($data){
    return [
        'status' => FALSE,
        'message' => "Failed",
        'data' => $data
    ];
}
function uploadImage($dir, $file)
{
    $result = null;
    $namaFile = time() . "_" . $file->getClientOriginalName();
    // $ext = $file->getClientOriginalExtension();
    $filename = $file->move($dir, $namaFile);
    $result = $filename->getFileName();
    return $result;
}