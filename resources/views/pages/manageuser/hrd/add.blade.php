@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Management User BUK</h2>
    {{ Breadcrumbs::render('tambah-management-user-hrd') }}
@endsection
@section('content')
@php
function searchId($id,$data)
{
    foreach ($data as $item):
        if($item['id'] == $id):
            return true;
        endif;
    endforeach;
    return false;
}
$data = \App\Models\User::role('pegawai')->orderBy('name')->get();
// dd($data[0]->role('buk'));
@endphp
<form class="edit-post-form" action="{{route('users.hrd.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Pilih Pegawai</label>
                <select class="form-control select2" name="pegawai[]" multiple="multiple" required>

                    @foreach($data as $s)

                    @php

                        $json = [
                            "value" => $s->nip,
                            "label" => $s->name,
                            "kode_suku" => $s->kode_suku,
                            "kode_status" => $s->kode_status,
                            "nip" => $s->nip,
                        ];
                        $namaJabatan = $s->jabatan_akhir()?->first()?->tingkat?->nama ?? "Tidak ada jabatan";
                    @endphp
                    <option value="{{json_encode($json)}}">{{$s->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('users.hrd.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection

