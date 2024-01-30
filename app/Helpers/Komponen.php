<?php

function optionStatusPegawai($v = null)
{
    $html = "";
    foreach (\App\Models\Master\StatusPegawai::orderBy('nama')->get() as $s) {
        if ($v == $s->id) {
            $html .= "<option selected value='{$s->id}'>{$s->nama}</option>";
        } else {
            $html .= "<option value='{$s->id}'>{$s->nama}</option>";
        }
    }
    return $html;
}
function optionGolonganDarah($v = null)
{
    $options = [
        [ 'value' => 'A', 'golongan_darah'=> 'A', 'label'=> 'A'],
        [ 'value' => 'B', 'golongan_darah'=> 'B', 'label'=> 'B'],
        [ 'value' => 'AB', 'golongan_darah'=> 'AB', 'label'=> 'AB'],
        [ 'value' => 'O', 'golongan_darah'=> 'O', 'label'=> 'O'],
    ];
    $html = "";
    foreach ($options as $s) {
        if($v == $s['value']){
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        }else{
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function optionStatusKawin($v = null)
{
    $options = [
        [ 'value' => 'belum menikah', 'kode_kawin'=> 'belum menikah', 'label'=> 'Belum Menikah'],
        [ 'value' => 'menikah', 'kode_kawin'=> 'menikah', 'label'=> 'Menikah'],
        [ 'value' => 'cerai_hidup', 'kode_kawin'=> 'cerai_hidup', 'label'=> 'Cerai Hidup'],
        [ 'value' => 'cerai_mati', 'kode_kawin'=> 'cerai_mati', 'label'=> 'Cerai Mati'],
        // [ 'value' => 'duda', 'kode_kawin'=> 'duda', 'label'=> 'Duda'],
    ];
    $html = "";
    foreach ($options as $s) {
        if ($v == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function optionAgama($v = null)
{
    $options = [
        ['value'  => 'islam', 'kode_agama' => 'islam', 'label' => 'Islam' ],
        ['value'  => 'protestan', 'kode_agama' => 'protestan', 'label' => 'Protestan' ],
        ['value'  => 'katholik', 'kode_agama' => 'katholik', 'label' => 'Katholik' ],
        ['value'  => 'hindu', 'kode_agama' => 'hindu', 'label' => 'Hindu' ],
        ['value'  => 'budha', 'kode_agama' => 'budha', 'label' => 'Budha' ],
        ['value'  => 'konghucu', 'kode_agama' => 'konghucu', 'label' => 'Konghucu' ],
        ['value'  => 'lainnya', 'kode_agama' => 'lainnya', 'label' => 'Lainnya' ],
    ];
    $html = "";
    foreach ($options as $s) {
        if ($v == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function optionKeluarga($v = null, $status = '')
{

   if ($status == 'orang-tua') {
    $options = [
      ["value"=> 'ayah', "status"=> 'ayah', "label"=> 'Ayah' ],
      ["value"=> 'ibu', "status"=> 'ibu', "label"=> 'Ibu' ],
    ];
  } else {
    $options = [
      ["value"=> 'ayah', "status"=> 'ayah', "label"=> 'Ayah' ],
      ["value"=> 'ibu', "status"=> 'ibu', "label"=> 'Ibu' ],
      ["value"=> 'suami/istri', "status"=> 'suami/istri', "label"=> 'Suami / Istri' ],
      ["value"=> 'anak', "status"=> 'anak', "label"=> 'Anak' ],
    ];
  }
  $html = "";
    foreach ($options as $s) {
        if ($v == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}

function optionJenisJabatan($v = null)
{

    $options = [
        ["value"=> '1', "jenis_jabatan"=> '1', "label"=> 'Struktural' ],
        ["value"=> '2', "jenis_jabatan"=> '2', "label"=> 'Fungsional' ],
        ["value"=> '4', "jenis_jabatan"=> '4', "label"=> 'Pelaksana' ],
    ];

    $html = "";
    foreach ($options as $s) {
        if ($v == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function optionTipeGaji($v = null)
{
    $options = [
        ["value"=> '1', "tipe_gaji"=> '1', "label"=> 'UMK' ],
        ["value"=> '2', "tipe_gaji"=> '2', "label"=> 'Non-UMK' ],
    ];

    $html = "";
    foreach ($options as $s) {
        if ($v == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}

function makeOpsiTable($menu = ""){
    return '<div class="btn-group dropdown">
        <a href="#" class="text-secondary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-ellipsis-h fa-lg"></i>
        </a>
        <div class="dropdown-menu dropdown-bordered shadow">
            '.$menu.'
        </div>
    </div>';
}

function opttionJenisBahasa($bahasa = null)
{
    $options = [
        ["value" => 'asing', "jenis"=> 'asing', "label"=> 'Asing' ],
        ["value" => 'daerah', "jenis"=> 'daerah', "label"=> 'Daerah' ],
    ];

    $html = "";
    foreach ($options as $s) {
        if ($bahasa == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function optionPenguasaanBahasa($penguasaan = null)
{

    $options = [
        [ "value" => 'pasif', "penguasaan"=> 'pasif', "label"=> 'Pasif' ],
        [ "value" => 'aktif', "penguasaan"=> 'aktif', "label"=> 'Aktif' ],
    ];

    $html = "";
    foreach ($options as $s) {
        if ($penguasaan == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}

function optionJenisSpt($jenisspt = null)
{

    $options = [
        [ "value" => '1770 S', "jenis_spt"=> '1770 S', "label"=> '1770 S' ],
        [ "value" => '1770 SS', "jenis_spt"=> '1770 SS', "label"=> '1770 SS' ],
    ];

    $html = "";
    foreach ($options as $s) {
        if ($jenisspt == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function optionJenisInstansi($jenisinstansi = null)
{

    $options = [
        [ "value" => 'negeri', "jenis_pmk"=> 'negeri', "label"=> 'Negeri' ],
        [ "value" => 'swasta', "jenis_pmk"=> 'swasta', "label"=> 'Swasta' ],
    ];

    $html = "";
    foreach ($options as $s) {
        if ($jenisinstansi == $s['value']) {
            $html .= "<option selected value='{$s['value']}'>{$s['label']}</option>";
        } else {
            $html .= "<option value='{$s['value']}'>{$s['label']}</option>";
        }
    }
    return $html;
}
function checkBoxDay($days = [],$col = 1){
    $html = "<div class='row'>";
    for ($i=1; $i <= 7; $i++) {
        $checked = "";
        if(in_array($i,$days)){
            $checked = "checked";
        }
        $html .= '<div class="col mb-1">
            <div class="form-check form-switch">
                <input type="checkbox" id="day-'.$i.'" name="hari[]" class="form-check-input" '.$checked.' value="'.$i.'">
                <label class="form-check-label" for="day-'.$i.'">'.hari($i).'</label>
            </div>
        </div>';
    }
    $html .= "</div>";
    return $html;
}
function buildBadge($tipe,$text,$class="")
    {
        return '<span class="badge badge-'.$tipe.' ms-3 '.$class.' d-md-inline-block text-capitalize d-none">'.$text.'</span>';
    }
