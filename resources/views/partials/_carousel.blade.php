<section>
    <div x-data="{
            images: [
                '{{ asset('images/banner/veges.png') }}',
                '{{ asset('images/banner/meats.png') }}',
                '{{ asset('images/banner/household.png') }}',
                '{{ asset('images/banner/drinks.png') }}',
            ],
            activeImage: null,

            prev() 
            {
                let index = this.images.indexOf(this.activeImage);
                if(index === 0) 
                {
                    index = this.images.length;
                }
                this.activeImage = this.images[index - 1];
            },
            next() 
            {
                let index = this.images.indexOf(this.activeImage);
                if(index == this.images.length - 1) 
                {
                    index = -1;
                }
                this.activeImage = this.images[index + 1];
            },
            selectItem(item)
            {
                this.activeImage = item
            },
            init() 
            {
                this.activeImage = this.images.length > 0 ? this.images[0] : null
                var self = this;
                setInterval(function(){
                    self.next();
                }, 10000);
            },
        }" 
        class="relative h-72 bg-slate-100 md:h-96 dark:bg-slate-400"
    >
        <template x-for="image in images">
            {{-- TODO: add carousel images that are wide enough --}}
            <div x-show="activeImage === image" class="flex h-full w-full px-10 bg-gray-50 items-center justify-center slide overflow-hidden dark:bg-gray-800" x-cloak>
                <img x-bind:src="image" alt="" class="w-full h-full object-cover shrink-0">
            </div>
        </template>

        {{-- carousel navigations --}}
        <div>
            <a href="#" @@click.prevent="prev" class="absolute text-gray-600 cursor-pointer hover:text-gray-900 left-0 top-1/2 -translate-y-1/2">
                <svg class="h-6 w-6 md:h-10 md:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <a href="#" @@click.prevent="next" class="absolute text-gray-600 cursor-pointer hover:text-gray-900 right-0 top-1/2 -translate-y-1/2">
                <svg class="h-6 w-6 md:h-10 md:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>

        {{-- carousel indicators --}}
        <div class="absolute flex justify-center left-1/2 bottom-4 z-10 -translate-x-1/2 space-x-1 z-10">
            <template x-for="image in images">
                <button 
                    class="bg-slate-300 py-[3px] px-2.5 rounded-2xl"
                    x-bind:class="{'bg-slate-800': activeImage === image}"
                    x-on:click = "selectItem(image)"
                >
                </button>
            </template>
        </div>
    </div>
</section>