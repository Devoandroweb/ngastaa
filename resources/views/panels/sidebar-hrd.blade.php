
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
