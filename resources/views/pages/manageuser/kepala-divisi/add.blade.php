@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Management User Kepala Divisi</h2>
    {{ Breadcrumbs::render('tambah-management-user-divisi') }}
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
@endphp
<form class="edit-post-form" action="{{route('users.manager.store')}}" method="post">
    @csrf
    <div class="row">
        <div class="col-xxl-12 col-lg-12">
            <div class="form-group">
                <label class="form-label">Pilih Pegawai</label>
                <select class="form-control pegawai" name="pegawai[]"  multiple="multiple" required>

                    @foreach(\App\Models\User::role('pegawai')->orderBy('name')->get() as $s)
                    @php
                        $json = [
                            "value" => $s->nip,
                            "label" => $s->name,
                            "kode_suku" => $s->kode_suku,
                            "kode_status" => $s->kode_status,
                            "nip" => $s->nip,
                        ];
                    @endphp
                    <option value="{{json_encode($json)}}">{{$s->name}}</option>
                    {{-- @if ($data != null)
                        @if(searchId($s->id,$data))
                            <option selected value="{{json_encode($json)}}">{{$s->name}}</option>
                        @else
                            <option value="{{json_encode($json)}}">{{$s->name}}</option>
                        @endif
                    @else
                    @endif --}}

                    @endforeach
                </select>
            </div>
        </div>


    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{route('users.manager.index')}}" class="btn btn-light">Kembali</a>

</form>
@endsection
@push('js')
<script>
    $(".pegawai").select2({allowClear: true});
</script>
@endpush
