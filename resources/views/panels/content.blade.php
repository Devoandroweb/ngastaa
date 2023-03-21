@if(isset($noHeader))
    @if(!$noHeader)
        @include('panels.page-header')
    @endif
@else
    @include('panels.page-header')
@endif
{{-- Page Header --}}
{{-- End Page Header --}}
<!-- Page Body -->
<div class="hk-pg-body pt-2">
    @yield('content')
</div>
<!-- /Page Body -->	
