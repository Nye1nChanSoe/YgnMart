@props(['field'])

@error($field)
    <div>
        <p class="text-sm text-red-500 mt-1">{{$message}}</p>
    </div>
@enderror