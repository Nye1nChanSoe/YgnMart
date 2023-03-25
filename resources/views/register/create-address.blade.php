<x-layout>
    <x-container>
        <form action="{{ route('register.store.address') }}" method="POST" class="flex items-center justify-center p-2 md:p-10">
            @csrf
            <div class="bg-white rounded-lg shadow-lg px-4 py-4 w-80 md:px-10 md:w-128">
                <h3 class="text-lg font-bold text-center">Address</h3>
                <div class="px-3 py-2 border rounded-lg my-3 md:my-5">
                    <x-icon name="info" class="text-blue-500 inline-block"/>
                    <span class="text-gray-600 text-xs md:text-sm">You can skip this for now and fill them out later when you're ready to make a purchase</span></p>
                </div>
                <div>
                    <div class="space-y-1.5 md:space-y-2.5">
                        <div>
                            <label for="street" class="block mb-1">Street</label>
                            <input type="text" id="street" name="street" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('street')}}" placeholder="Street...">
                            <x-input-error field="street"></x-input-error>
                        </div>
                        <div>
                            <label for="ward" class="block mb-1">Ward</label>
                            <input type="text" id="ward" name="ward" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('ward')}}" placeholder="Ward...">
                            <x-input-error field="ward"></x-input-error>
                        </div>
                        <div>
                            <label for="township" class="block mb-1">Township</label>
                            <input type="text" id="township" name="township" class="w-full border-2 border-blue-200 p-1.5 rounded-lg outline-1 outline-blue-400" value="{{old('township')}}" placeholder="Township...">
                            <x-input-error field="township"></x-input-error>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="p-1.5 px-3 text-base rounded text-white bg-blue-500 w-fit hover:bg-blue-700">Add Address</button>
                        <button id="btn-skip" type="button" class="text-amber-500 hover:text-amber-700 text-sm md:text-base">
                            <span>Skip</span>
                            <x-icon name="arrow-right" class="inline" />
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </x-container>
</x-layout>

<script>
    const skip = document.getElementById('btn-skip');
    skip.addEventListener('click', function(event) {
        console.log('skio');
        window.location.href = '{{ route("register.address.skip") }}';
    })
</script>