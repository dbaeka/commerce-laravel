<template>
    <div>
        <h2 class="sr-only">Checkout</h2>

        <form class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
            <div>
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Contact information</h2>

                    <div class="mt-4">
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Email address</label>
                        <div class="mt-1">
                            <input type="email" id="email-address" name="email-address" autocomplete="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div class="mt-10 border-t border-gray-200 pt-10">
                    <h2 class="text-lg font-medium text-gray-900">Shipping information</h2>

                    <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div>
                            <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                            <div class="mt-1">
                                <input type="text" id="first-name" name="first-name" autocomplete="given-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                            <div class="mt-1">
                                <input type="text" id="last-name" name="last-name" autocomplete="family-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <div class="mt-1">
                                <input type="text" name="address" id="address" autocomplete="street-address" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="apartment" class="block text-sm font-medium text-gray-700">Apartment, suite, etc.</label>
                            <div class="mt-1">
                                <input type="text" name="apartment" id="apartment" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <div class="mt-1">
                                <input type="text" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <div class="mt-1">
                                <select id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700">State / Province</label>
                            <div class="mt-1">
                                <input type="text" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="postal-code" class="block text-sm font-medium text-gray-700">Postal code</label>
                            <div class="mt-1">
                                <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <div class="mt-1">
                                <input type="text" name="phone" id="phone" autocomplete="tel" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order summary -->
            <div class="mt-10 lg:mt-0">
                <h2 class="text-lg font-medium text-gray-900">Order summary</h2>

                <div class="mt-4 rounded-lg border border-gray-200 bg-white shadow-sm">
                    <h3 class="sr-only">Items in your cart</h3>
                    <ul role="list" class="divide-y divide-gray-200">
                        <li class="flex py-6 px-4 sm:px-6">
                            <div class="flex-shrink-0">
                                <img src="/images/t-shirt-black.jpg" alt="T-Shirt in black." class="w-20 rounded-md">
                            </div>

                            <div class="ml-6 flex flex-1 flex-col">
                                <div class="flex">
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm">
                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800">Basic Tee</a>
                                        </h4>
                                        <p class="mt-1 text-sm text-gray-500">Black</p>
                                    </div>
                                </div>

                                <div class="flex flex-1 items-end justify-between pt-2">
                                    <p class="mt-1 text-sm font-medium text-gray-900">$32.00</p>

                                    <div class="ml-4">
                                        <label for="quantity" class="sr-only">Quantity</label>
                                        <select id="quantity" name="quantity" class="rounded-md border border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                            <option value="1">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="flex py-6 px-4 sm:px-6">
                            <div class="flex-shrink-0">
                                <img src="/images/t-shirt-gray.jpg" alt="T-Shirt in gray." class="w-20 rounded-md">
                            </div>

                            <div class="ml-6 flex flex-1 flex-col">
                                <div class="flex">
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm">
                                            <a href="#" class="font-medium text-gray-700 hover:text-gray-800">T-Shirt</a>
                                        </h4>
                                        <p class="mt-1 text-sm text-gray-500">Gray</p>
                                    </div>
                                </div>

                                <div class="flex flex-1 items-end justify-between pt-2">
                                    <p class="mt-1 text-sm font-medium text-gray-900">$32.00</p>

                                    <div class="ml-4">
                                        <label for="quantity" class="sr-only">Quantity</label>
                                        <select id="quantity" name="quantity" class="rounded-md border border-gray-300 text-left text-base font-medium text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm">
                                            <option value="1">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <dl class="space-y-6 border-t border-gray-200 py-6 px-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900">$64.00</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm">Shipping</dt>
                            <dd class="text-sm font-medium text-gray-900">$5.00</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                            <dt class="text-base font-medium">Total</dt>
                            <dd class="text-base font-medium text-gray-900">$69.00</dd>
                        </div>
                    </dl>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                        <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 py-3 px-4 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Submit order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {}
</script>
