<x-layout>
    {{-- hero / carousel --}}
    @include('partials._carousel')

    {{-- TODO: divide sections and display related products for each section --}}
    <main>
        <div class="container mx-auto grid grid-cols-2 gap-x-2 gap-y-4 mb-10 px-2 md:px-6 md:grid-cols-3 lg:grid-cols-4 3xl:grid-cols-6">
            @for($i = 0; $i < 11; ++$i)
            <x-product-card />
            @endfor
        </div>
    </main>
</x-layout>

