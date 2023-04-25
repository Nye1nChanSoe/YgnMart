<section>
    <div x-data="{
            images: ['Promo 1', 'Promo 2', 'Event 1', 'Event 2'],
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
                }, 5000);
            },
        }" 
        class="relative h-72 bg-slate-100 mb-10 md:h-96"
    >
        <template x-for="image in images">
            {{-- TODO: add carousel images that are wide enough --}}
            <div x-show="activeImage === image" class="flex h-full items-center justify-center slide">
                {{-- <img x-bind:src="image" alt="" style="width: 100%; height:100%; object-fit:fit"> --}}
                <p x-text=image class="text-4xl tracking-wide font-bold md:text-6xl md:tracking-widest"></p>
            </div>
        </template>

        {{-- carousel navigations --}}
        <div>
            <a href="#" @@click.prevent="prev" class="absolute text-gray-600 cursor-pointer hover:text-gray-900 left-0 top-1/2 -translate-y-1/2 md:left-4">
                <svg class="h-6 w-6 md:h-10 md:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>
            <a href="#" @@click.prevent="next" class="absolute text-gray-600 cursor-pointer hover:text-gray-900 right-0 top-1/2 -translate-y-1/2 md:right-4">
                <svg class="h-6 w-6 md:h-10 md:w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        </div>

        {{-- carousel indicators --}}
        <div class="absolute flex justify-center left-1/2 bottom-4 -translate-x-1/2 space-x-1 z-10">
            <template x-for="image in images">
                <button 
                    class="bg-slate-300 py-[3px] px-2.5 rounded-2xl"
                    x-bind:class="{'bg-black': activeImage === image}"
                    x-on:click = "selectItem(image)"
                >
                </button>
            </template>
        </div>
    </div>
</section>