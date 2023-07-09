@extends('app')
@section('breadcrumps')
    <h2 class="pg-title">Role Menu Management</h2>
    {{ Breadcrumbs::render('role-menu') }}
@endsection
@section('header_action')
<div class="input-group">
    <span class="input-affix-wrapper">
        <label for="">Nama Divisi : <span class="bulan badge badge-dark me-2">{{$tingkat->skpd?->nama}}</span></label>
        <label for="">Kode Tingkat : <span class="bulan badge badge-danger me-2">{{$tingkat->kode_tingkat}}</span></label>
        <label for="">Nama Tingkat : <span class="bulan badge badge-primary">{{$tingkat->nama}}</span></label>
    </span>
</div>
@endsection
@section('content')
@php
// dd($roleMenu);
    function checkRoleMenu($roleMenus,$kodeMenu){
        foreach ($roleMenus as $key => $value) {
            if($value->kode_menu == $kodeMenu){
                return true;
            }
        }
        return false;
    }
    function checkRoleMenuPermission($roleMenus,$kodeMenu,$permission){
        foreach ($roleMenus as $key => $value) {
            if($value->kode_menu == $kodeMenu){
                $subMenu = explode(",",$value->has_permission);
                if(in_array($permission,$subMenu)){
                    return true;
                }
            }
        }
        return false;
    }
@endphp
<div class="invoice-list-view">
    <form action="{{route('setting.role-menu.manage-save')}}" method="POST">
        @csrf
        <input type="hidden" name="kode_tingkat" value="{{$tingkat->kode_tingkat}}">
        <div class="row">
            @foreach ($menus as $menu)
            @php
                $subMenus = explode(",",$menu->sub_menu)
            @endphp
            <div class="col-md-3 mb-5 menu">
                <label for="formFile" class="form-label fw-bold">{{$menu->nama}}</label>
                <input type="checkbox" name="kode_menu[]" value="{{$menu->kode_menu}}" class="kode_menu d-none" {{checkRoleMenu($roleMenu,$menu->kode_menu) ? 'checked' : ''}}>
                @foreach ($subMenus as $subMenu)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input sub-menu" name="sub_menu[{{$menu->kode_menu}}][]" value="{{$subMenu}}" id="{{$subMenu}}" {{checkRoleMenuPermission($roleMenu,$menu->kode_menu,$subMenu) ? 'checked' : ''}}>
                        <label class="form-check-label" for="{{$subMenu}}">{{convertTextCrud($subMenu)}}</label>
                    </div>
                @endforeach
            </div>
            @endforeach
        </div>
        <hr>
        <input type="submit" class="btn btn-info" value="Simpan">
        <a href="{{route('setting.role-menu.index')}}" class="btn btn-default">Kembali</a>
    </form>
</div>
@endsection

@push('js')
<script>
    $(".sub-menu").click(function(){
        checkCrud($(this))
    })
    function checkCrud(el){
        // el.closest('.menu').find(".sub-menu").prop('checked',true)
        var menu = el.closest('.menu').find(".kode_menu")
        var result = false;
        console.log(menu)
        var subMenu = el.closest('.menu').find(".sub-menu")
        for (let index = 0; index < subMenu.length; index++) {
            if(subMenu[index].checked){
                result = true;
            }
        }
        if(result){
            menu.prop('checked',true)
        }else{
            menu.prop('checked',false)
        }



    }
</script>

@endpush
