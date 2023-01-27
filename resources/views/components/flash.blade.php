@if(session()->has('success'))
    <div 
        x-data="{show:true}" 
        x-show="show" 
        x-init="animate(), setTimeout(() => show = false, 5000)"
        class="fixed bottom-5 right-3 bg-blue-500 text-sm text-white py-2 px-4 rounded-lg"
        id="flash"
    >
        <p>{{session()->get('success')}}</p>
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