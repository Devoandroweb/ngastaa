@if(!isset($dashboard))
<!-- Page Header -->
<div class="hk-pg-header pg-header-wth-tab pt-4 mb-2 pb-3">
    <div class="d-flex">
        <div class="d-flex flex-wrap justify-content-between flex-1">
            <div class="mb-lg-0 mb-2 me-8">
                
                @yield('breadcrumps')
            </div>
            <div class="pg-header-action-wrap">
                @yield('header_action')
            </div>
        </div>
    </div>
</div>
@else
<div class="mb-3"></div>
<!-- /Page Header -->
@endif

