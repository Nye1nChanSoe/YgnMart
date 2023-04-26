@props(['product'])

<div {{ $attributes->merge(['class' => "flex flex-col mx-1 p-4 rounded space-y-3 hover:ring-1 hover:ring-blue-400"]) }}>
    <a href="/products/{{ $product->slug }}">{{$slot}}</a>
</div>