@if(request()->filled('search') || request()->filled('category'))
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">

        <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-base text-gray-700 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results for') !!}
                    @if (request('search') ?? false)
                        <span class="font-semibold">"{{request('search')}}"</span>
                    @endif
                    @if (request('category') ?? false)
                    {!! __('category') !!}
                        <span class="font-semibold">"{{request('category')}}"</span>
                    @endif
                </p>
            </div>
        </div>
    </nav>
@endif
