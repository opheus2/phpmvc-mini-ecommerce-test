<div x-cloak @keydown.window.escape="openCart = false" x-show="openCart" class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
    <div class="absolute inset-0 overflow-hidden">

        <div x-show="openCart" x-transition:enter="ease-in-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-description="Background overlay, show/hide based on slide-over state." class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openCart = false" aria-hidden="true">
        </div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">

            <div x-show="openCart" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md" x-description="Slide-over panel, show/hide based on slide-over state.">
                <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                    <form @submit.prevent="checkoutCart()">
                        <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                    Shopping cart
                                </h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500" @click="openCart = false">
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" x-description="Heroicon name: outline/x" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-8">
                                <div class="flow-root">
                                    <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <template x-for="(product, index) in Object.values(cart)" :key="index">
                                            <li class="py-6 flex" x-data="{ quantity: product.quantity}">
                                                <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                                    <img :src="`/images/${product.image}`" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="w-full h-full object-center object-cover">
                                                </div>

                                                <div class="ml-4 flex-1 flex flex-col">
                                                    <div>
                                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                                            <h3>
                                                                <a href="#" x-text="product.name"></a>
                                                            </h3>
                                                            <p class="ml-4" x-text="`$${(quantity * product.amount).toFixed(2)}`"></p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500" x-text="product.category"></p>
                                                    </div>
                                                    <div class="flex-1 flex items-end justify-between text-sm">
                                                        <p class="text-gray-500">
                                                            <span class="mr-1">Qty</span>
                                                            <input x-on:change="(e) => {updateProductQuantity(product.id, $event.target.value); quantity = $event.target.value;}" type="number" min="1" :value="`${quantity}`" class="w-14 px-2 py-1 inline-flex shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                                        </p>

                                                        <div class="flex">
                                                            <button x-on:click="removeProductFromCart(product.id)" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <template x-if="Object.values(cart).length > 0">
                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                <div class="flex text-base font-medium text-gray-900 mb-3">
                                    <select x-ref="deliveryMethod" x-on:change="deliveryFee = parseInt($event.target.selectedOptions[0].getAttribute('cost'))" name="delivery_mode" id="delivery_mode" class="max-w-lg block p-2 focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                        <option value="" cost="0">Select delivery method</option>
                                        <option value="pickup" cost="0">Pickup (free)</option>
                                        <option value="home_delivery" cost="5">Shipping UPS ($5)</option>
                                    </select>
                                </div>
                                <div class="flex justify-between text-base font-medium text-gray-900 mt-1">
                                    <p>Subtotal</p>
                                    <p x-text="$store.app.totalItemsCost + deliveryFee"></p>
                                </div>
                                <div class="flex justify-between text-base font-medium text-gray-600 mt-4">
                                    <p>Available Balance</p>
                                    <p x-text="$store.app.user.account_balance"></p>
                                </div>
                                <div class="mt-6">
                                    <button type="submit" class="flex w-full justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Checkout</button>
                                </div>
                                <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                                    <p>
                                        or <button type="button" class="text-indigo-600 font-medium hover:text-indigo-500" @click="openCart = false">Continue Shopping<span aria-hidden="true"> →</span></button>
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1 mb-2">
                                    <template x-for="(error, index) in checkoutErrors" :key="index">
                                        <div class="text-red-500 text-sm" x-text="error"></div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        <template x-if="Object.values(cart).length <= 0">
                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                <div class="flex text-base font-medium text-gray-900 mt-1">
                                    <p>Here is empty!.. </p>
                                </div>
                            </div>
                        </template>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
