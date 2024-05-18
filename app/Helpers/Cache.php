<?php

use Illuminate\Support\Facades\Cache;

function clearUserHome($nip){
    Cache::forget("home-user-$nip");
}
function clearPengumuman(){
    Cache::forget("pengumuman");
}
