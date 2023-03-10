@if(session()->has('success'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed z-10 bg-white bottom-5 right-3 shadow-lg text-sm font-semibold py-2 px-4 rounded-lg"
        id="flash"
    >
        <p>{{session()->get('success')}}</p>
    </div>
@endif

@if(session()->has('warning'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed z-10 bg-white bottom-5 right-3 shadow-lg text-sm font-semibold py-2 px-4 rounded-lg"
        id="flash"
    >
        <div class="flex items-center space-x-2">
            <x-icon name="warning" class="text-amber-500" />
            <p>{{session()->get('warning')}}</p>
        </div>
    </div>
@endif

<script>
    function animate()
    {
        let elem = document.querySelector('#flash');
        setTimeout(() => {
            elem.classList.add('slide-out');
        }, 4360);
    }
</script>