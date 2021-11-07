<?php
$this->title = "Shop";
?>
<div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Products of the day!</h2>

    <div x-show="productsLoading" class="py-24">
        <div class="flex items-center justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-9 w-9 text-purple-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
    <div x-show="!productsLoading" class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        <template x-for="(product, index) in Object.values($store.app.products)" :key="index">
            <div class="group relative">
                <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                    <img :src="`/images/${product.image}`" alt="Front of men&#039;s Basic Tee in black." class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                </div>
                <div class="mt-4 flex justify-between">
                    <div>
                        <h3 class="text-sm text-gray-700">
                            <a href="#" x-text="product.name"></a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500" x-text="product.category"></p>
                    </div>
                    <p class="text-sm font-medium text-gray-900" x-text="`${product.currency.symbol}${product.amount}`"></p>
                </div>
                <div class="mt-4 flex justify-between">
                    <div>
                        <h3 class="text-sm text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </h3>
                    </div>
                    <button @click="() => {addProductToCart(product.id)}" type="button" class="flex justify-center items-center px-2 py-1 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                        </svg>
                    </button>
                </div>
                <div class="mt-4 flex justify-between">
                    <!-- Allow rating if user haven't rated before -->
                    <template x-if="() => {return allowProductRating(index)}">
                        <div x-data="{ temp: 0, orig: 0 }" class="flex cursor-pointer text-4xl" @click="orig = temp; rateProduct(product.id, temp, index);">
                            <input type="number" :value="orig" class="hidden" />
                            <template x-for="item in [1,2,3,4,5]">
                                <span @mouseenter="temp = item" @mouseleave="temp = orig" class="text-gray-300 text-base" :class="{'text-purple-600': (temp >= item)}">★</span>
                            </template>
                        </div>
                    </template>

                    <!-- Don't Allow rating if user have rated before -->
                    <template x-if="() => {return !allowProductRating(index)}">
                        <div x-data="{ temp: product.average_rating, orig: product.average_rating }" class="flex text-4xl">
                            <input type="number" :value="orig" class="hidden" />
                            <template x-for="item in [1,2,3,4,5]">
                                <span class="text-gray-300 text-base" :class="{'text-purple-600': (product.average_rating >= item)}">★</span>
                            </template>
                        </div>
                    </template>

                    <template x-if="product.average_rating == 0">
                        <p class="text-sm text-gray-700">leave a rating</p>
                    </template>
                    <template x-if="product.average_rating > 0">
                        <p class="text-sm text-gray-700" x-text="`${product.average_rating} avg rating`"></p>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>
<script>
    var user = <?= $user ?>;
    document.addEventListener("alpine:init", () => {
        Alpine.store('app').user = user
    });
</script>
<?php include 'includes/shop/cart.view.php' ?>
<?php include 'includes/shop/success-modal.view.php' ?>
