@props(['product'])
<div {{$attributes->merge(['class' => 'sm:flex sm:items-center'])}}>
    <div class="flex">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= round($product->rating_point))
            <x-icon name="star-solid" class="text-yellow-300"/>
            @else
            <x-icon name="star-solid" class="text-gray-300"/>
            @endif
        @endfor
    </div>
    <span class="block text-center text-xs text-gray-600 ml-1">({{$product->reviews->count()}} review)</span>
</div>