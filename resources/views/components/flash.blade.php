@if(session()->has('success'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed flex justify-between items-center z-10 bg-blue-600 text-white bottom-5 right-3 shadow-lg text-sm font-semibold py-2 px-4 rounded-lg"
        id="flash"
    >
        <p>{{session()->get('success')}}</p>
        <span class="ml-1 hover:text-gray-200" x-on:click="show=false">
            <x-icon name="close" />
        </span>
    </div>
@endif

@if(session()->has('warning'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed z-10 bg-yellow-400 text-white bottom-5 right-3 shadow-lg text-sm font-semibold py-2 px-4 rounded-lg"
        id="flash"
    >
        <div class="flex items-center space-x-2">
            <x-icon name="warning" class="text-amber-500" />
            <p>{{session()->get('warning')}}</p>
            <span class="ml-1 hover:text-gray-200" x-on:click="show=false">
                <x-icon name="close" />
            </span>
        </div>
    </div>
@endif

@if(session()->has('delete'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed z-10 bg-gray-700 text-white bottom-5 right-3 shadow-lg text-sm font-semibold py-2 px-4 rounded-lg"
        id="flash"
    >
        <div class="flex items-center space-x-2">
            <p>{{session()->get('delete')}}</p>
            <span class="ml-1 hover:text-gray-200" x-on:click="show=false">
                <x-icon name="close" />
            </span>
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed z-10 bg-red-400 text-white bottom-5 right-3 shadow-lg text-sm font-semibold py-2 px-4 rounded-lg"
        id="flash"
    >
        <div class="flex items-center space-x-2">
            <x-icon name="warning" class="text-amber-500" />
            <p>{{session()->get('error')}}</p>
            <span class="ml-1 hover:text-gray-200" x-on:click="show=false">
                <x-icon name="close" />
            </span>
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