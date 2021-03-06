<!--content start-->
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html class="h-full">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Php Demo Store | <?= $this->title ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/app.css">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="h-full" x-data="mainData()">
    <!--[if lt IE 7]>
            <p class=" browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <?php if (app()->session->getFlash('success')) : ?>
        <div class="alert alert-success">
            <?php echo app()->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white">
        <!--
    Mobile menu

    Off-canvas menu for mobile, show/hide based on off-canvas menu state.
  -->
        <div x-show="showMobileMenu" class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true">

            <div x-show="showMobileMenu" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="showMobileMenu" class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true">
            </div>

            <div x-show="showMobileMenu" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative max-w-xs w-full bg-white shadow-xl pb-12 flex flex-col overflow-y-auto">
                <div class="px-4 pt-5 pb-2 flex">
                    <button type="button" @click="showMobileMenu = false" class="-m-2 p-2 rounded-md inline-flex items-center justify-center text-gray-400">
                        <span class="sr-only">Close menu</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Links -->
                <div class="border-t border-gray-200 py-6 px-4 space-y-6">
                    <div class="flow-root">
                        <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Company</a>
                    </div>

                    <div class="flow-root">
                        <a href="#" class="-m-2 p-2 block font-medium text-gray-900">Stores</a>
                    </div>
                </div>
                <div class="border-t border-gray-200 py-6 px-4">
                    <a href="#" class="-m-2 p-2 flex items-center">
                        <img src="/images/united-states.svg" alt="" class="w-5 h-auto block flex-shrink-0">
                        <span class="ml-3 block text-base font-medium text-gray-900">
                            USD
                        </span>
                        <span class="sr-only">, change currency</span>
                    </a>
                </div>
            </div>
        </div>

        <header class="relative bg-white">
            <p class="bg-indigo-600 h-10 flex items-center justify-center text-sm font-medium text-white px-4 sm:px-6 lg:px-8">
                Get it free on pickup orders
            </p>

            <nav aria-label="Top" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="border-b border-gray-200">
                    <div class="h-16 flex items-center">
                        <!-- Mobile menu toggle, controls the 'mobileMenuOpen' state. -->
                        <button type="button" @click="showMobileMenu = true" class="bg-white p-2 rounded-md text-gray-400 lg:hidden">
                            <span class="sr-only">Open menu</span>
                            <!-- Heroicon name: outline/menu -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Logo -->
                        <div class="ml-4 flex lg:ml-0">
                            <a href="#">
                                <span class="sr-only">Workflow</span>
                                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=indigo&shade=600" alt="">
                            </a>
                        </div>

                        <!-- Flyout menus -->
                        <div class="hidden lg:ml-8 lg:block lg:self-stretch">
                            <div class="h-full flex space-x-8">
                                <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Company</a>

                                <a href="#" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-800">Stores</a>
                            </div>
                        </div>

                        <div class="ml-auto flex items-center">

                            <div class="hidden lg:ml-8 lg:flex">
                                <a href="#" class="text-gray-700 hover:text-gray-800 flex items-center">
                                    <img src="/images/united-states.svg" alt="" class="w-5 h-auto block flex-shrink-0">
                                    <span class="ml-3 block text-sm font-medium">
                                        USD
                                    </span>
                                    <span class="sr-only">, change currency</span>
                                </a>
                            </div>

                            <!-- Cart -->
                            <div class="ml-4 flow-root lg:ml-6">
                                <a href="#" class="group -m-2 p-2 flex items-center">
                                    <!-- Heroicon name: outline/shopping-bag -->
                                    <button @click="fetchCart()">
                                        <svg class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </button>
                                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800" x-text="$store.app.totalCartItems"></span>
                                    <span class="sr-only">items in cart, view bag</span>
                                </a>
                            </div>
                            <div class="ml-4 flow-root lg:ml-6">
                                <button @click="handleLogout()" type="button" class="group -m-2 p-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="sr-only">items in cart, view bag</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
    </div>
    <div x-init="fetchProducts()">
        {{content}}
    </div>

    <script type="module" src="/js/app.js" async defer></script>
    <script>
        var BASE_URL = window.location.origin;

        function mainData() {
            return {
                openCart: false,
                showMobileMenu: false,
                showProductModal: false,
                showSuccessModal: false,
                productsLoading: true,
                orderReady: true,
                cart: [],
                checkoutErrors: [],
                deliveryFee: 0,
                updateStoreData(cartItems, ItemsCost) {
                    Alpine.store('app').totalCartItems = cartItems
                    Alpine.store('app').totalItemsCost = ItemsCost
                },
                allowProductRating(index) {
                    const data = {
                        ...Alpine.store('app').products[index]
                    }
                    const filter = data.ratings.filter(rating => rating.user_id == Alpine.store('app').user.id)
                    return (Object.keys(filter).length === 0)
                },
                handleLogout() {
                    Alpine.store('app').user = {}
                    Alpine.store('app').totalCartItems = 0
                    Alpine.store('app').totalItemsCost = 0
                    fetch(`${BASE_URL}/logout`, {
                        method: 'POST',
                        body: {},
                    })
                    location.replace('/login')
                },
                async fetchUser() {
                    await fetch(`${BASE_URL}/user`)
                        .then((response) => response.json())
                        .then(data => {
                            Alpine.store('app').user = data.user
                        })
                        .catch((error) => console.log(error))
                },
                async fetchProducts() {
                    await fetch(`${BASE_URL}/products`)
                        .then((response) => response.json())
                        .then(data => {
                            Alpine.store('app').products = data.products
                            this.productsLoading = false
                        })
                        .catch((error) => console.log(error))
                },
                async addProductToCart(id) {
                    await fetch(`${BASE_URL}/carts/add?id=${id}`)
                        .then((response) => response.json())
                        .then(data => {
                            Alpine.store('app').totalCartItems += 1
                            this.updateStoreData(data.total_cart_items, data.total_items_cost)
                        })
                },
                async fetchCart() {
                    this.deliveryFee = 0
                    await fetch(`${BASE_URL}/carts`)
                        .then((response) => response.json())
                        .then(data => {
                            this.cart = data.cart
                            this.updateStoreData(data.total_cart_items, data.total_items_cost)
                            this.openCart = true
                        })
                        .catch((error) => console.log(error))
                },
                async removeProductFromCart(id) {
                    await fetch(`${BASE_URL}/carts/remove?id=${id}`)
                        .then((response) => response.json())
                        .then(data => {
                            this.updateStoreData(data.total_cart_items, data.total_items_cost)
                            this.cart = Object.values(this.cart).filter(p => p.id !== id)
                        })
                        .catch((error) => console.log(error))
                },
                async updateProductQuantity(id, quantity) {
                    await fetch(`${BASE_URL}/carts/update?id=${id}&quantity=${quantity}`)
                        .then((response) => response.json())
                        .then(data => {
                            this.updateStoreData(data.total_cart_items, data.total_items_cost)
                        })
                        .catch((error) => console.log(error))

                },
                async rateProduct(id, rating, index) {
                    const formData = new FormData()
                    formData.append('id', id)
                    formData.append('rating', rating)
                    await fetch(`${BASE_URL}/products/rate`, {
                            method: 'POST',
                            body: formData,
                        }).then((response) => response.json())
                        .then(data => {
                            if (data.status) {
                                Alpine.store('app').products[index] = data.product
                            }
                        })
                        .catch((error) => console.log(error))
                },
                async checkoutCart() {
                    const formData = new FormData()
                    formData.append('delivery_method', this.$refs.deliveryMethod.value)
                    await fetch(`${BASE_URL}/shop/checkout`, {
                            method: 'POST',
                            body: formData,
                        }).then((response) => response.json())
                        .then(data => {
                            if (data.status !== true) {
                                this.checkoutErrors = data.checkout_errors
                                return
                            }
                            this.fetchUser()
                            this.updateStoreData(data.total_cart_items, data.total_items_cost)
                            this.openCart = false
                            this.showSuccessModal = true
                            this.checkoutErrors = []
                            this.cart = {}
                        })
                }
            };
        }
    </script>
</body>

</html>
