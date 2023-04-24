@props(['field'])

@error($field)
    <div>
        <p {{$attributes->merge(['class' => 'text-sm text-red-500 mt-1'])}}>{{$message}}</p>
    </div>
@enderror