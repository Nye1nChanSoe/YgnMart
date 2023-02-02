@if(session()->has('success'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed bottom-5 right-3 bg-blue-50 text-sm text-blue-800 py-2 px-4 rounded-lg dark:bg-gray-800 dark:text-blue-400"
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
        class="fixed bottom-5 right-3 bg-yellow-50 text-sm text-yellow-800 py-2 px-4 rounded-lg dark:bg-gray-800 dark:text-yellow-300"
        id="flash"
    >
        <p>{{session()->get('warning')}}</p>
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