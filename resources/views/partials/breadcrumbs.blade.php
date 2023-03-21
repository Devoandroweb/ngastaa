 {{-- resources/views/partials/breadcrumbs.blade.php --}}

@unless ($breadcrumbs->isEmpty())
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if (!is_null($breadcrumb->url) && !$loop->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                {{-- <a class="text-dark" href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a> --}}
            @else
                {{-- <small class="text-muted"> / {{ $breadcrumb->title }} </small> --}}
		        <li class="breadcrumb-item text-muted" aria-current="page">{{ $breadcrumb->title }}</li>

            @endif

        @endforeach
	</ol>
</nav>
@endunless
