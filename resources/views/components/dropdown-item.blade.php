@props([
    'active' => false
])

@php 
    $classes = 'block text-left px-3 text-sm leading-8 hover:bg-blue-500 hover:text-white focus:bg-blue-500 focus:text-white';

    // decorate the currently selected item 
    if($active) 
    {
        $classes .= ' bg-sky-400 text-white';
    } 
@endphp

<a {{$attributes->merge(['class' => $classes])}}>
    {{$slot}}
</a>