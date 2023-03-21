@props([
    'categories'
])

<x-layout>
    <x-slot:title>
        {{$product->name}}
    </x-slot:title>
    <x-container x-data="charts">
        {{-- TODO: breadcrumbs --}}

        {{-- product view --}}
        <div class="flex items-center justify-center space-x-2 my-10">
            <div class="basis-1/3">
                <img src="{{$product->image ? asset($product->image) : asset('images/no-image.png')}}" alt="">
            </div>

            {{-- product info --}}
            <div class="basis-1/2 p-10 bg-slate-50 rounded-lg space-y-3">
                <div class="flex items-center">
                    @foreach ($product->categories as $category)
                        <div class="text-xs text-slate-600 px-3 py-1 border border-blue-400 rounded-full hover:text-black hover:border-blue-600">
                            {{$category->sub_type}}
                        </div>
                    @endforeach
                </div>
                <div>
                    <h3 class="font-semibold text-xl py-2">{{$product->name}}</h3>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex justify-center items-center">
                        <template x-for="star in stars">
                            <x-icon name="star-solid" x-bind:class="{'text-yellow-400' : star <= Math.round(point), 'text-slate-300': star > Math.round(point)}" />
                        </template>
                        <div class="text-xs text-gray-700 ml-1">(<span x-text="totalReviews"></span>)</div>
                        <a href="#reviews" class="text-sm ml-2 py-1.5 px-2 bg-slate-100 rounded-lg text-blue-500 hover:bg-slate-200">Leave Review</a>
                    </div>
                    <div class="text-blue-500 hover:text-blue-700">
                        <a href="#">Visit the Vendor</a>
                    </div>
                </div>
                <div class="flex items-center pt-4">
                    <h5 class="px-2.5 py-[3px] bg-yellow-300 text-black font-semibold rounded-xl w-32 text-xl text-center">{{number_format($product->price, 0, '.', ',')}} <span class="text-sm">MMK</span></h5>
                    <div class="ml-3">Save 10% for current promotion</div>
                </div>
                <div class="pt-4 text-zinc-800">
                    <h3 class="font-semibold mb-2">Product Description</h3>
                    <p class="indent-10 leading-7 text-sm">{{$product->description}}</p>
                </div>

                {{-- add to cart --}}
                <div 
                    x-data="{
                        open: false,
                        quantity: 1,
                    }"
                    class="flex items-center pt-4 space-x-4"
                >
                    <form action="{{ route('products.add') }}" method="POST">
                        @csrf
                        {{-- x-model is two-way bound, meaning it both "sets" and "gets". In addition to changing data, if the data itself changes, the element will reflect the change. --}}
                        <input type="hidden" name="quantity" x-model="quantity">
                        <input type="hidden" name="product" value="{{$product->id}}">
                        <x-button class="rounded-full shadow-lg bg-blue-400" @@click="addToCart">
                            <x-icon name="cart" />
                        </x-button>
                    </form>
                    
                    <div class="relative">
                        <button @@click="open = !open" class="flex items-center bg-gray-200 text-xs px-2 py-1 rounded-full ring-1 ring-slate-200 focus:ring-2 focus:ring-blue-400">
                            <div class="font-medium mr-1.5">
                                Qty: <span x-text="quantity"></span>
                            </div>
                            <x-icon name="chevron-right" class="w-3.5 h-3" x-bind:class="{ 'rotate-90 transition-all duration-400':open }"/>
                        </button>
                    
                        <div x-show="open" @@click.outside="open = false" class="absolute py-2 mt-1 bg-white shadow-lg w-20 max-h-56 overflow-auto scrollbar rounded-xl border border-slate-200 z-10" x-cloak x-transition>
                            <ul>
                                @for ($i = 0; $i < 100; $i++)
                                <li>
                                    <x-dropdown-item 
                                        class="leading-6" 
                                        x-on:click="quantity = {{$i}}, open = false"
                                    >
                                        {{$i}}
                                    </x-dropdown-item>
                                </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="pt-4 space-y-1">
                    <div class="flex text-sm items-center space-x-2 ">
                        <span>Delivery Available</span>
                        <x-icon name="check" />
                    </div>
                    <div class="flex text-sm items-center space-x-2 ">
                        <span>Multipayment Available</span>
                        <x-icon name="check" />
                    </div>
                </div>
            </div>
        </div>

        {{-- TODO: Add Carousel effect --}}
        <x-related-products :related-products="$relatedProducts" :product="$product" class="py-2 border-t" />

        {{-- Reviews --}}
        <div id="reviews" class="flex flex-col gap-y-10 px-4 border-t pt-10 md:flex-row md:gap-x-20">
            <div class="basis-2/5 flex flex-col gap-y-6">
                <section>
                    <div id="review" class="text-center">
                        <div class="text-md font-medium">Reviews</div>
                        <div class="text-4xl font-semibold" x-text="point"></div>
                        <div class="flex justify-center my-2">
                            <template x-for="star in stars">
                                <x-icon name="star-solid" x-bind:class="{'text-yellow-400' : star <= Math.round(point), 'text-slate-300': star > Math.round(point)}" />
                            </template>
                        </div>
                        <div class="text-sm">Based on <span x-text="totalReviews"></span> reviews</div>
                    </div>
    
                    <!-- Horizontal Scoreboard -->
                    <div class="space-y-2 mt-4 drop-shadow-md">
                        <template x-for="(count, index) in reviews.slice().reverse()">
                            <div class="flex items-center justify-evenly space-x-2">
                                <span class="text-xs drop-shadow-none" x-text="([5,4,3,2,1][index]) + ' star'" x-bind:class="textColors[index]"></span>
                                <div class="flex justify-between bg-gray-300 h-5 w-[70%] rounded">
                                    <div class="rounded" x-bind:class="bgColors[index]" x-bind:style="'width:' + (count / totalReviews * 100) + '%'">
                                    </div>
                                </div>
                                <span class="text-xs drop-shadow-none w-10" x-text="(isNaN((count / totalReviews * 100)) ? Number(0) : (count / totalReviews * 100)).toFixed(1) + '%'" x-bind:class="textColors[index]"></span>
                            </div>
                        </template>
                    </div>
                </section>

                <!-- Review box -->
                <section x-data="rate" class="mt-8">
                    <div class="border border-yellow-300 rounded-lg p-3 bg-slate-50 text-sm">
                        <h2 class="font-medium text-yellow-500">
                            <x-icon name="warning" class="inline mr-1" /> Warning
                        </h2>
                        <p class="mt-1">
                            Manipulating or misleading reviews is strictly prohibited. We value honest and authentic feedback from our users. Any user found to be manipulating reviews may face account suspension or termination. Please ensure that all reviews submitted are truthful and based on genuine experiences
                        </p>
                    </div>
                    <div class="mt-4">
                        <form id="review-form" action="{{route('products.review', ['product' => $product->slug])}}" method="POST" class="bg-slate-50 p-3 border rounded-lg space-y-4">
                            @csrf
                            <div>
                                <label for="" class="font-medium">Rate the product</label>
                                <div class="flex mt-1.5">
                                    <template x-for="star in stars">
                                        <x-icon name="star-solid" 
                                        x-on:click="selected = star" 
                                        x-on:mouseover="rating = star" 
                                        x-on:mouseleave="rating = 0" 
                                        x-bind:class="colorStar(star)" 
                                        />
                                    </template>
                                </div>
                                <input type="hidden" name="star_rating" id="star-rating" value="" x-model="selected">
                            </div>
                            <div>
                                <label class="font-medium">Write Your Review</label>
                                <textarea name="comment" id="comment" class="w-full resize-none border rounded-lg mt-1 p-2 h-24 focus:outline-blue-400" placeholder="Would you like to write anything about this product?"></textarea>
                            </div>
                            <button type="submit" id="review-submit" class="w-full px-3 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600" x-on:click.prevent="submitReview">Submit Review</button>
                            <div id="review-loading" class="flex justify-center items-center w-full px-3 py-2 bg-blue-50 rounded-lg space-x-2">
                                <span class="text-gray-500">Submitting</span>
                                <div class="spinner"></div>
                            </div>
                            <span id="error" class="inline-block text-red-500"></span>
                        </form>
                    </div>
                </section>
            </div>

            <!-- comments -->
            <template x-if="totalReviews === 0">
                <div class="flex flex-col flex-1 self-center items-center space-y-4 border-none">
                    <img src="{{asset('images/comment.png')}}" alt="" width="80">
                    <p class="text-center text-gray-600">No comments on this product yet</p>
                </div>
            </template>

            <section id="comments" class="flex-1 divide-y divide-slate-300 space-y-3" x-show="totalReviews > 0">
                @foreach ($product->reviews as $review)
                <div class="flex p-2 pt-3">
                    <img src="{{asset('images/no-image.png')}}" alt="" width="40" height="40" class="self-start border border-slate-100 p-1 py-1.5 rounded-full">
                    <div class="flex-1 ml-4">
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                                <div class="font-medium text-sm">{{$review->user->name}}</div>
                                <div class="flex items-center mt-1">
                                    <template x-for="star in {{$review->rating ?? '0'}}">
                                        <x-icon name="star-solid" class="text-yellow-400"/>
                                    </template>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500"><time>{{$review->created_at->diffForHumans()}}</time></span>
                        </div>
                        <p class="mt-3 text-gray-800 text-sm md:text-base px-2 py-2 bg-slate-50 rounded-lg">
                            {{$review->comment}}
                        </p>
                    </div>
                </div>
                @endforeach
            </section>
        </div>
        <div id="success-message" class="hidden fixed top-4 left-1/2 -translate-x-1/2 bg-green-50 border border-green-200 px-4 py-2 rounded-lg">
        </div>
        <div id="error-message" class="hidden fixed top-4 left-1/2 -translate-x-1/2 bg-red-50 border border-red-200 px-4 py-2 rounded-lg">
        </div>
    </x-container>
</x-layout>


<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('charts', () => ({
        stars: [1, 2, 3, 4, 5],             // value for each star
        reviews: [],                        // number of user reviews in ordered sequence as above stars
        totalReviews: 0,
        bgColors:['bg-green-500', 'bg-lime-500', 'bg-yellow-500', 'bg-orange-500', 'bg-red-500'],
        textColors:['text-green-600', 'text-lime-600', 'text-yellow-600', 'text-orange-600', 'text-red-600'],
        point: 0,           // total ratings point [0.0 to 5.0]

        avgStarPoint() {
            this.totalReviews = this.reviews.reduce((total, count) => total + count);
            var starValue = 0;
            for(var i = 0; i < 5; ++ i)
            {
                starValue += this.stars[i] * this.reviews[i];
            }
            starValue = starValue/ this.totalReviews;
            if(isNaN(starValue)) {
                return Number(0).toFixed(1);
            }
            return starValue.toFixed(1);
        },

        init()
        {
            @foreach($ratings as $rating)
                @if($rating->count == 0)
                    this.reviews.push(0);
                @else
                    this.reviews.push({{$rating->count}})
                @endif
            @endforeach
            this.point = this.avgStarPoint();
        },

    }));

    /* for rating form */
    Alpine.data('rate', () => ({
        rating: 0,
        selected: 0,
        colorStar(star) {
            if(star <= this.selected) {
                return 'text-yellow-400';
            } else if (this.rating >= star) {
                return 'text-yellow-300';
            } else {
                return 'text-gray-300';
            }
        }
    }));
});
</script>

<script>
var errorDisplay = document.getElementById('error');
var commentsSection = document.getElementById('comments');

var successMessage = document.getElementById('success-message');
var errorMessage = document.getElementById('error-message');

var reviewForm = document.getElementById('review-form');
var reviewSubmit = document.getElementById('review-submit');
var reviewLoading = document.getElementById('review-loading');

reviewLoading.style.display = 'none';

/** function triggered by AlpineJS x-on:click */
function submitReview()
{
    var rating = document.getElementById('star-rating');
    var comment = document.getElementById('comment');

    reviewSubmit.style.display = 'none';
    reviewLoading.style.display = 'flex';

    if(rating.value == 0 || comment.value.trim() == '')
    {
        showAlert('error', 'Rating and comment are required in order to submit a review');

        reviewSubmit.style.display = 'block';
        reviewLoading.style.display = 'none';
    }
    else 
    {
        fetch('/products/{{ $product->id }}/review', {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json',
                        
                // The CSRF TOKEN is embedded in the meta tag 
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                rating: rating.value,
                comment: comment.value,
                point: this.avgStarPoint(),
            }),
        })
        .then(response => {
            if(!response.ok) {
                errorDisplay.innerHTML = response.error;
                throw new Error('Network was not ok');
            }
                    
            return response.json();
        })
        .then(data => {
            console.log('Data object: ', data);
            if(data.message === 'success')
            {
                // get all the reviews count for start 1, 2, 3, 4, 5 in order
                this.reviews = data.ratings.map(obj => obj.count);
                this.totalReviews = this.reviews.reduce((accumulator, value) => accumulator + value, 0);
                this.point = this.avgStarPoint();
                
                createComment(data, this.selected);
                this.selected = 0;

                showAlert(data.message, 'Thank you for your valuable feedback');

                fetch('/products/{{ $product->id }}/review', {
                    method: 'PATCH', 
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        point: this.point,
                    }),
                })
                .then(function(response) {
                    if(!response.ok) {
                        throw new Error('Interal Server Error: Failed to update the products table');
                    }
                    return response.json();
                })
                .then(function(data) {
                    console.log(data.message);
                })
                .catch(function(error) {
                    console.error(error.message);
                });
            }
            else 
            {
                showAlert(data.message, 'You cannot review a single product twice')
            }
            
            reviewSubmit.style.display = 'block';
            reviewLoading.style.display = 'none';
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            errorDisplay.innerHTML = error.message;

            /** 
             * Laravel will redirect user if they are not authenticated, 
             * this condition check whether the server response as intended or redirecting back the user 
             */
            if(error.message.includes('Unexpected token'))
            {
                window.location.href = "{{ route('login') }}";
            }

            reviewSubmit.style.display = 'block';
            reviewLoading.style.display = 'none';
        });
    }
}

/* create comment dynamically and append them in start of the comment section */
function createComment(data, stars)
{
    const newComment = `
      <div class="flex p-2 pt-3">
        <img src="{{asset('images/no-image.png')}}" alt="" width="40" height="40" class="self-start border border-slate-100 p-1 py-1.5 rounded-full">
        <div class="flex-1 ml-4">
          <div class="flex justify-between items-center">
            <div class="flex flex-col">
              <div class="font-medium text-sm">${data.user.name}</div>
              <div class="flex items-center mt-1">
                ${Array(stars).fill(`<x-icon name="star-solid" class="text-yellow-400"></x-icon>`).join('')}
              </div>
            </div>
            <span class="text-sm text-gray-500"><time>Now</time></span>
          </div>
          <p class="mt-3 text-gray-800 text-sm md:text-base">
            ${data.comment}
          </p>
        </div>
      </div>
    `;

    /* 
     add new comment at the end of the comment section 
     beforeend argument specifies that the new HTML should be inserted just before the closing tag of the element
    */
    commentsSection.insertAdjacentHTML('beforeend', newComment);
    reviewForm.reset();
}

function showAlert(message, info = '')
{
    if(message === 'success') {
        successMessage.style.display = 'block';
        successMessage.innerHTML = info;
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    } else {
        errorMessage.style.display = 'block';
        errorMessage.innerHTML = info;
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);
    }
}
</script>

