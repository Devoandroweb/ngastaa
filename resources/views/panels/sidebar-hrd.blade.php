
<li class="nav-item {{activeMenu("skpd")}}">
    <a class="nav-link" href="{{route('master.skpd.index')}}">
        <span class="nav-icon-wrap">
            <span class="svg-icon">
                {!! icons('users') !!}
            </span>
        </span>
        <span class="nav-link-text">Divisi Kerja</span>
    </a>
</li>
<li class="nav-item {{activeMenu("lokasi")}}">
    <a class="nav-link" href="{{route('master.lokasi.index')}}">
        <span class="nav-icon-wrap">
            <span class="svg-icon">
                {!! icons('users') !!}
            </span>
        </span>
        <span class="nav-link-text">Lokasi Kerja</span>
    </a>
</li>
<li class="nav-item {{activeMenu("visit")}}">
    <a class="nav-link" href="{{route('master.visit.index')}}">
        <span class="nav-icon-wrap">
            <span class="svg-icon">
                {!! icons('users') !!}
            </span>
        </span>
        <span class="nav-link-text">Lokasi Visit</span>
    </a>
</li>
@if($masterDataShift || $masterDataJamKerja)
<li class="nav-item">
    <a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#data_presensi">
        <span class="nav-icon-wrap">
            <span class="svg-icon">
                {!!icons('file-text')!!}
            </span>
        </span>
        <span class="nav-link-text">Data Presensi</span>
    </a>

    <ul id="data_presensi" class="nav flex-column sub2menu collapse  nav-children">
        @if($masterDataShift)
        <li class="nav-item">
            <a class="nav-link" href="{{route('master.shift.index')}}"><span class="nav-link-text">Shift</span></a>
        </li>
        @endif
        @if($masterDataJamKerja)
        <li class="nav-item">
            <a class="nav-link" href="{{route('master.jam_kerja.index')}}"><span class="nav-link-text">Jam Kerja</span></a>
        </li>
        @endif
    </ul>
</li>
@endif
