@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Divisi Kerja</h2>
    {{ Breadcrumbs::render('edit-divisi-kerja') }}
@endsection
@section('content')
<form class="edit-post-form" action="{{route('master.skpd.store')}}" method="post">
    <input type="hidden" value="{{$skpd->id}}" name="id">
    @csrf
    <div class="row">
        <div class="col-md-12">
                <div class="form-group has-validation">
                    <label class="form-label">Kode</label>
                    <input class="form-control @error('kode_skpd') is-invalid @enderror" value="{{$skpd->kode_skpd}}" placeholder="Masukkan Kode" name="kode_skpd">
                    <div class="invalid-feedback">
                        {{ $errors->first('kode_skpd') }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input class="form-control" value="{{$skpd->nama}}" placeholder="Masukkan Nama" name="nama">
                </div>
                <div class="form-group">
                    <label class="form-label">Singkatan</label>
                    <input class="form-control" value="{{$skpd->singkatan}}" placeholder="Masukkan Singkatan" name="singkatan">
                </div>
                {{-- maps --}}

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Koordinat</label>
                            <input class="form-control" name="kordinat" value="{{$skpd->kordinat}}" id="koordinat" placeholder="Masukkan Koordinat">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">Kota</label>
                            <select class="form-control mb-3 select2 @error('code_city') is-invalid @enderror"  value="" placeholder="" name="code_city">
                                <option value="" disabled>Pilih Kabupaten/Kota</option>
                                @foreach ($kabupaten as $kab)
                                    @if ($skpd->code_city == $kab->code)
                                    <option value="{{$kab->code}}" selected>{{$kab->name}}</option>
                                    @else
                                    <option value="{{$kab->code}}">{{$kab->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col d-none">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="customRange1" class="form-label">Jarak Wilayah (m)</label>
                                <input type="range" min="100" max="5000" value="{{$skpd->jarak}}" name="jarak" class="form-range" id="radius">
                            </div>
                            <div class="form-group col-2">
                                <label class="form-label"></label>
                                <input class="form-control" id="radius_count" value="{{$skpd->jarak}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" class="mb-4" style="height: 500px"></div>
                <input type="hidden" name="latitude" value="{{$skpd->latitude}}" id="latitude">
                <input type="hidden" name="longitude" value="{{$skpd->longitude}}" id="longitude">
                <input type="hidden" name="polygon" id="polygon" value="{{$skpd->polygon ?? ''}}">
                {{-- end maps --}}
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                <a href="{{route('master.skpd.index')}}" class="btn btn-light">Kembali</a>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    var ltlgOld = ("{{$skpd->kordinat}}").split(",");
    $(".btn-simpan").click(function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Perhatian !!',
          text: 'pastikan data yang anda masukkan sudah benar termasuk Koordinat dan Kota harus sesuai, karena data ini masuk dalam hitungan Gaji Pegawai',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.value) {
            $(".edit-post-form").submit();
          }
        })
    });
</script>
<script src="{{asset('/')}}maps.js"></script>
@endpush
