<?php
// =================== Data Utama ======================================
function konfigDataPribadi($nip){
    $arrayColumns = [
        "url" => url("pegawai/jabatan/".$nip. "/datatable"),
        "url_add" => url("pegawai/jabatan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Janis Jabatan','data' => 'jenis_jabatan','name' => 'jenis_jabatan'],
            ['title' => 'Nama Jabatan','data' => 'nama_jabatan','name' => 'nama_jabatan'],
            ['title' => 'Level','data' => 'level','name' => 'level'],
            ['title' => 'Divisi','data' => 'divisi','name' => 'divisi'],
            ['title' => 'TMT Jabatan','data' => 'tanggal_tmt','name' => 'tanggal_tmt'],
            ['title' => 'Tanggal SK','data' => 'tanggal_sk','name' => 'tanggal_sk'],
            ['title' => 'Nomor SK','data' => 'no_sk','name' => 'no_sk'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigPosisiDanJabatan($nip){
    $arrayColumns = [
        "url" => url("pegawai/jabatan/".$nip. "/datatable"),
        "url_add" => url("pegawai/jabatan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Janis Jabatan','data' => 'jenis_jabatan','name' => 'jenis_jabatan'],
            ['title' => 'Nama Jabatan','data' => 'nama_jabatan','name' => 'nama_jabatan'],
            ['title' => 'Level','data' => 'level','name' => 'level'],
            ['title' => 'Divisi','data' => 'divisi','name' => 'divisi'],
            ['title' => 'TMT Jabatan','data' => 'tanggal_tmt','name' => 'tanggal_tmt'],
            ['title' => 'Tanggal SK','data' => 'tanggal_sk','name' => 'tanggal_sk'],
            ['title' => 'Nomor SK','data' => 'no_sk','name' => 'no_sk'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigDataKoordinat($nip){
    $arrayColumns = [
        "url" => url("pegawai/jabatan/".$nip. "/datatable"),
        "url_add" => url("pegawai/jabatan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Janis Jabatan','data' => 'jenis_jabatan','name' => 'jenis_jabatan'],
            ['title' => 'Nama Jabatan','data' => 'nama_jabatan','name' => 'nama_jabatan'],
            ['title' => 'Level','data' => 'level','name' => 'level'],
            ['title' => 'Divisi','data' => 'divisi','name' => 'divisi'],
            ['title' => 'TMT Jabatan','data' => 'tanggal_tmt','name' => 'tanggal_tmt'],
            ['title' => 'Tanggal SK','data' => 'tanggal_sk','name' => 'tanggal_sk'],
            ['title' => 'Nomor SK','data' => 'no_sk','name' => 'no_sk'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}



// =================== Data Riwayat ======================================
function konfigJabatan($nip){
    $arrayColumns = [
        "url" => url("pegawai/jabatan/".$nip. "/datatable"),
        "url_add" => url("pegawai/jabatan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Janis Jabatan','data' => 'jenis_jabatan','name' => 'jenis_jabatan'],
            ['title' => 'Nama Jabatan','data' => 'nama_jabatan','name' => 'nama_jabatan'],
            ['title' => 'Level','data' => 'level','name' => 'level'],
            ['title' => 'Divisi','data' => 'divisi','name' => 'divisi'],
            ['title' => 'TMT Jabatan','data' => 'tanggal_tmt','name' => 'tanggal_tmt'],
            ['title' => 'Tanggal SK','data' => 'tanggal_sk','name' => 'tanggal_sk'],
            ['title' => 'Nomor SK','data' => 'no_sk','name' => 'no_sk'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigGajiPokok($nip){
    $arrayColumns = [
        "url" => url("pegawai/kgb/".$nip. "/datatable"),
        "url_add" => url("pegawai/kgb/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nomor Surat','data' => 'nomor_surat','name' => 'nomor_surat'],
            ['title' => 'Tanggal TMT','data' => 'tanggal_tmt','name' => 'tanggal_tmt'],
            ['title' => 'Gaji Pokok Baru','data' => 'gaji_pokok','name' => 'gaji_pokok'],
            ['title' => 'Masa Kerja','data' => 'masa_kerja','name' => 'masa_kerja'],
            ['title' => 'Private?','data' => 'is_private','name' => 'is_private'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigGTunjangan($nip){
    $arrayColumns = [
        "url" => url("pegawai/tunjangan/".$nip. "/datatable"),
        "url_add" => url("pegawai/tunjangan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nama Tunjangan','data' => 'nama','name' => 'nama'],
            ['title' => 'Nomor SK', 'data' => 'nomor_sk', 'name' => 'nomor_sk'],
            ['title' => 'Tanggal SK', 'data' => 'tanggal_sk', 'name' => 'tanggal_sk'],
            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
            ['title' => 'Private?', 'data' => 'is_private', 'name' => 'is_private'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigPotongan($nip){
    $arrayColumns = [
        "url" => url("pegawai/potongan/".$nip. "/datatable"),
        "url_add" => url("pegawai/potongan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nama Potongan','data' => 'nama','name' => 'nama'],
            ['title' => 'Nomor SK','data' => 'nomor_sk','name' => 'nomor_sk'],
            ['title' => 'Tanggal SK','data' => 'tanggal_sk','name' => 'tanggal_sk'],
            ['title' => 'Status','data' => 'status','name' => 'status'],
            ['title' => 'Private?','data' => 'is_private','name' => 'is_private'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigPendidikan($nip){
    $arrayColumns = [
        "url" => url("pegawai/pendidikan/".$nip. "/datatable"),
        "url_add" => url("pegawai/pendidikan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Tingkat','data' => 'tingkat','name' => 'tingkat'],
            ['title' => 'Jurusan','data' => 'jurusan','name' => 'jurusan'],
            ['title' => 'Tanggal Lulus','data' => 'tanggal_lulus','name' => 'tanggal_lulus'],
            ['title' => 'Nomor Ijazah','data' => 'nomor_ijazah','name' => 'nomor_ijazah'],
            ['title' => 'Nama Sekolah','data' => 'nama_sekolah','name' => 'nama_sekolah'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigKursus($nip){
    $arrayColumns = [
        "url" => url("pegawai/kursus/".$nip. "/datatable"),
        "url_add" => url("pegawai/kursus/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nama Kursus','data' => 'nama','name' => 'nama'],
            ['title' => 'Tempat','data' => 'tempat','name' => 'tempat'],
            ['title' => 'Pelaksana','data' => 'pelaksana','name' => 'pelaksana'],
            ['title' => 'No Sertifikat','data' => 'no_sertifikat','name' => 'no_sertifikat'],
            ['title' => 'Tanggal Sertifikat','data' => 'tanggal_sertifikat','name' => 'tanggal_sertifikat'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}

function konfigCuti($nip){
    $arrayColumns = [
        "url" => url("pegawai/cuti/".$nip. "/datatable"),
        "url_add" => url("pegawai/cuti/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nama Cuti','data' => 'cuti','name' => 'cuti'],
            ['title' => 'Tanggal Surat','data' => 'tanggal_surat','name' => 'tanggal_surat'],
            ['title' => 'Nomor Surat','data' => 'nomor_surat','name' => 'nomor_surat'],
            ['title' => 'Tanggal Mulai','data' => 'tanggal_mulai','name' => 'tanggal_mulai'],
            ['title' => 'Tanggal Selesai','data' => 'tanggal_selesai','name' => 'tanggal_selesai'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigLembur($nip){
    $arrayColumns = [
        "url" => url("pegawai/lembur/".$nip. "/datatable"),
        "url_add" => url("pegawai/lembur/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Tanggal','data' => 'tanggal','name' => 'tanggal'],
            ['title' => 'Jam Mulai','data' => 'jam_mulai','name' => 'jam_mulai'],
            ['title' => 'Jam Selesai','data' => 'jam_selesai','name' => 'jam_selesai'],
            ['title' => 'Keterangan','data' => 'keterangan','name' => 'keterangan'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigReimbursment($nip){
    $arrayColumns = [
        "url" => url("pegawai/reimbursement/".$nip. "/datatable"),
        "url_add" => url("pegawai/reimbursement/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nama Reimbursement','data' => 'nama','name' => 'nama'],
            ['title' => 'Nominal','data' => 'nilai','name' => 'nilai'],
            ['title' => 'Nomor Surat','data' => 'nomor_surat','name' => 'nomor_surat'],
            ['title' => 'Tanggal Surat','data' => 'tanggal_surat','name' => 'tanggal_surat'],
            ['title' => 'Keterangan','data' => 'keterangan','name' => 'keterangan'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigShift($nip){
    $arrayColumns = [
        "url" => url("pegawai/shift/".$nip. "/datatable"),
        "url_add" => url("pegawai/shift/" . $nip . "/add"),
        "data" => [
            ['title' => 'No','data' => 'DT_RowIndex', 'orderable'=> false ,'searchable'=> false],
            ['title' => 'Nama Shift','data' => 'nama','name' => 'nama'],
            ['title' => 'Nomor Surat','data' => 'nomor_surat','name' => 'nomor_surat'],
            ['title' => 'Tanggal Surat','data' => 'tanggal_surat','name' => 'tanggal_surat'],
            ['title' => 'Keterangan','data' => 'keterangan','name' => 'keterangan'],
            ['title' => 'Berkas','data' => 'file','name' => 'file'],
            ['title' => 'Opsi','data' => 'opsi','name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigPenghargaan($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/penghargaan/" . $nip . "/datatable"),
        "url_add" => url("pegawai/penghargaan/" . $nip . "/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama Penghargaan', 'data' => 'penghargaan', 'name' => 'penghargaan'],
            ['title' => 'Oleh', 'data' => 'oleh', 'name' => 'oleh'],
            ['title' => 'Nomor SK', 'data' => 'nomor_sk', 'name' => 'nomor_sk'],
            ['title' => 'Tanggal SK', 'data' => 'tanggal_sk', 'name' => 'tanggal_sk'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}

// ===================================== Data Keluarga ==================================
function konfigSemuaKeluarga($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/keluarga/" . $nip . "/datatable_keluarga"),
        "url_add" => url("pegawai/keluarga/" . $nip . "/0/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama', 'data' => 'nama', 'name' => 'nama'],
            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
            ['title' => 'Tempat, Tanggal Lahir', 'data' => 'tempat_lahir', 'name' => 'tempat_lahir'],
            ['title' => 'File Ktp', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigOrangTua($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/keluarga/" . $nip . "/datatable_orangtua"),
        "url_add" => url("pegawai/keluarga/" . $nip . "/orang-tua/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama', 'data' => 'nama', 'name' => 'nama'],
            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
            ['title' => 'Tempat, Tanggal Lahir', 'data' => 'tempat_lahir', 'name' => 'tempat_lahir'],
            ['title' => 'File Ktp', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigIstri($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/keluarga/" . $nip . "/datatable_istri"),
        "url_add" => url("pegawai/keluarga/" . $nip . "/istri/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama', 'data' => 'nama', 'name' => 'nama'],
            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
            ['title' => 'Tempat, Tanggal Lahir', 'data' => 'tempat_lahir', 'name' => 'tempat_lahir'],
            ['title' => 'File Ktp', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigAnak($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/keluarga/" . $nip . "/datatable_anak"),
        "url_add" => url("pegawai/keluarga/" . $nip . "/anak/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama', 'data' => 'nama', 'name' => 'nama'],
            ['title' => 'Status', 'data' => 'status', 'name' => 'status'],
            ['title' => 'Tempat, Tanggal Lahir', 'data' => 'tempat_lahir', 'name' => 'tempat_lahir'],
            ['title' => 'File Ktp', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
// ===================================== Data Lainya ==================================
function konfigOrganisasi($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/organisasi/" . $nip . "/datatable"),
        "url_add" => url("pegawai/organisasi/" . $nip . "/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama Organisasi', 'data' => 'nama_organisasi', 'name' => 'nama_organisasi'],
            ['title' => 'Jenis Organisasi', 'data' => 'jenis_organisasi', 'name' => 'jenis_organisasi'],
            ['title' => 'Jabatan', 'data' => 'jabatan', 'name' => 'jabatan'],
            ['title' => 'Tanggal Mulai', 'data' => 'tanggal_mulai', 'name' => 'tanggal_mulai'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigPenguasaanBahasa($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/bahasa/" . $nip . "/datatable"),
        "url_add" => url("pegawai/bahasa/" . $nip . "/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Nama Bahasa', 'data' => 'nama_bahasa', 'name' => 'nama_bahasa'],
            ['title' => 'Penguasaan Bahasa', 'data' => 'penguasaan', 'name' => 'penguasaan'],
            ['title' => 'Jenis Bahasa', 'data' => 'jenis', 'name' => 'jenis'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigSptTahunan($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/spt/" . $nip . "/datatable"),
        "url_add" => url("pegawai/spt/" . $nip . "/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Tahunan', 'data' => 'tahun', 'name' => 'tahun'],
            ['title' => 'Jenis SPT', 'data' => 'jenis_spt', 'name' => 'jenis_spt'],
            ['title' => 'Status SPT', 'data' => 'status_spt', 'name' => 'status_spt'],
            ['title' => 'Nominal', 'data' => 'nominal', 'name' => 'nominal'],
            ['title' => 'Tanggal Penyampaian', 'data' => 'tanggal_penyampaian', 'name' => 'tanggal_penyampaian'],
            ['title' => 'Nomor Tanda Terima Elektronik', 'data' => 'nomor_tanda_terima_elektronik', 'name' => 'nomor_tanda_terima_elektronik'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigPengalamanKerja($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/pmk/" . $nip . "/datatable"),
        "url_add" => url("pegawai/pmk/" . $nip . "/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Jenis Perusahaan', 'data' => 'instansi', 'name' => 'instansi'],
            ['title' => 'Nomor SK', 'data' => 'nomor_sk', 'name' => 'nomor_sk'],
            ['title' => 'Tanggal SK', 'data' => 'tanggal_sk', 'name' => 'tanggal_sk'],
            ['title' => 'Massa Kerja', 'data' => 'masa_kerja', 'name' => 'masa_kerja'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}
function konfigRiwayatLainnya($nip)
{
    $arrayColumns = [
        "url" => url("pegawai/lainnya/" . $nip . "/datatable"),
        "url_add" => url("pegawai/lainnya/" . $nip . "/add"),
        "data" => [
            ['title' => 'No', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'Jenis', 'data' => 'kode_lainnya', 'name' => 'kode_lainnya'],
            ['title' => 'Nomor SK', 'data' => 'nomor_sk', 'name' => 'nomor_sk'],
            ['title' => 'Tanggal SK', 'data' => 'tanggal_sk', 'name' => 'tanggal_sk'],
            ['title' => 'Berkas', 'data' => 'file', 'name' => 'file'],
            ['title' => 'Opsi', 'data' => 'opsi', 'name' => 'opsi'],
        ]
    ];
    return $arrayColumns;
}






