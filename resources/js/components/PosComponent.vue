<template>
    <div class="min-h-screen bg-blue-50">
        <Header />
        <div class="py-[8px] px-4 bg-blue-50 print:hidden">
            <div class="grid gap-x-2 gap-y-5 xl:gap-y-0 grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 2xl:grid-cols-5">
                <!-- category -->
                <div class="col-span-1">
                    <div
                        class="px-2 py-3 bg-white rounded-tl-3xl text-center text-sky-400 text-2xl font-bold leading-[28.80px] mb-2">
                        Categories
                    </div>
                    <div class="md:max-h-[83vh] overflow-y-scroll customScroll">
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
                            <div class="relative" v-for="category in categories" :key="category.id">
                                <input type="radio" :id="category.name" name="category" class="peer sr-only"
                                    :value="category.id" @click="categoryId(category.id)" />
                                <label :for="category.name"
                                    class="w-full p-2 bg-slate-50 justify-center items-center gap-2 flex flex-wrap m-0 border-2 border-slate-50 cursor-pointer hover:bg-sky-100 hover:border-sky-100 peer-checked:bg-white peer-checked:border-sky-400">
                                    <div class="items-center flex overflow-hidden">
                                        <img class="rounded-[7px] max-h-32" :src="category.thumbnail" />
                                    </div>
                                    <span class="text-cyan-900 text-base font-medium leading-tight w-[150px] text-center">
                                        {{ category.name }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product -->
                <div class="col-span-1 sm:col-span-2 flex flex-col gap-2">
                    <div class="px-2 py-3 bg-white text-center text-sky-400 text-2xl font-bold leading-[28.80px]">
                        Products
                    </div>
                    <div class="relative">
                        <input type="text" placeholder="Scan/Search featured product by name  or code"
                            v-model="featuredProduct" @keyup="searchFeaturedProduct"
                            class="form-input h-12 px-4 py-2.5 bg-white focus:ring-2 focus:ring-sky-500 outline-none border-none w-full" />

                        <div v-if="featuredProduct > 0 && featuredProduct"
                            class="absolute w-full p-3 shadow-lg border border-slate-200 bg-white flex flex-col gap-2 z-10">
                            <div v-for="product in featuredProducts" :key="product.id"
                                class="border border-slate-200 bg-slate-50 rounded p-2 cursor-pointer hover:bg-slate-200"
                                @click="addProductToBasket(product)">
                                {{ product.name }}
                            </div>
                        </div>
                    </div>

                    <!-- product list -->
                    <div class="overflow-y-scroll customScroll md:max-h-[77vh]">
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
                            <div v-for="product in featuredProducts" :key="product.id"
                                class="group p-2 bg-white flex-col justify-center items-center gap-1 flex relative border-2"
                                :class="filterProduct(product).length
                                    ? 'border-teal-400'
                                    : 'border-transparent'
                                    ">
                                <div class="items-center flex overflow-hidden">
                                    <img class="rounded-[7px] max-h-36" :src="product.thumbnail" />
                                </div>
                                <div class="flex-col justify-center items-center gap-0.5 flex w-full pt-1">
                                    <div class="text-cyan-900 text-xs font-bold leading-tight truncate w-full text-center">
                                        {{ product.name }}
                                    </div>
                                    <div class="text-slate-500 text-[10px] font-normal leading-3">
                                        {{ product.code }}
                                    </div>
                                    <div class="text-cyan-900 text-xs font-medium leading-[14.40px]">
                                        In Stock: {{ product.stock }}
                                    </div>
                                </div>

                                <div class="bg-cyan-900/60 h-full w-full group-hover:flex transition justify-center items-center absolute"
                                    :class="!filterProduct(product).length
                                        ? 'hidden'
                                        : 'flex'
                                        ">
                                    <div v-if="product.stock > 0" class="flex justify-center items-center gap-4 grow">
                                        <button class="w-8 h-8 bg-white rounded-[5px] flex justify-center items-center"
                                            @click="
                                                decrimentProductToBasket(product)
                                                ">
                                            <MinusIcon class="w-4 h-4 text-slate-600" />
                                        </button>
                                        <span class="text-white text-lg font-semibold leading-snug tracking-tight">{{
                                            filterProduct(product)[0]?.qty ?? 0
                                        }}</span>
                                        <button class="w-8 h-8 bg-white rounded-[5px] flex justify-center items-center"
                                            @click="addProductToBasket(product)">
                                            <PlusIcon class="w-4 h-4 text-slate-600" />
                                        </button>
                                    </div>
                                    <div v-else class="bg-slate-200 py-1 px-2 rounded-full text-sm text-red-600">
                                        Out of Stock
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- column three -->
                <div class="col-span-1 sm:col-span-3 lg:col-span-3 2xl:col-span-2">
                    <div class="relative">
                        <div class="flex gap-2 mb-2">
                            <div class="flex grow relative">
                                <img src="/icons/user-tie-solid.svg"
                                    class="w-6 h-6 absolute top-2/4 transform -translate-y-2/4 left-3" />
                                <input type="text" placeholder="Enter Customer name or phone number"
                                    v-model="searchCustomers" @keyup="searchCustomer()"
                                    class="form-input pl-11 px-4 py-3.5 bg-white focus:ring-2 focus:ring-sky-500 outline-none border-none w-full" />
                            </div>

                            <button class="h-13 bg-white px-4 rounded-tr-3xl" @click="addCustomerModal">
                                <PlusIcon class="w-6 h-6 text-sky-400" />
                            </button>
                        </div>

                        <div v-if="customers.length > 0 && searchCustomers"
                            class="absolute w-full p-3 shadow-lg border border-slate-200 bg-white flex flex-col gap-2 z-10 max-h-96 overflow-y-auto">
                            <div v-for="customer in customers" :key="customer.id"
                                class="border border-slate-200 bg-slate-50 rounded p-2 cursor-pointer hover:bg-slate-200"
                                @click="addCustomer(customer)">
                                {{ customer.name }}
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <input type="text" placeholder="Scan/Search product by name  or code" v-model="searchProduct"
                            @input="productSearch()"
                            class="form-input h-12 px-4 py-2.5 bg-white focus:ring-2 focus:ring-sky-500 outline-none border-none w-full" />

                        <div v-if="products.length > 0 && searchProduct"
                            class="absolute w-full p-3 shadow-lg border border-slate-200 bg-white flex flex-col gap-2 z-10 max-h-96 overflow-y-auto">
                            <div v-for="product in products" :key="product.id"
                                class="border border-slate-200 bg-slate-50 rounded p-2 cursor-pointer hover:bg-slate-200"
                                @click="addProductToBasket(product)">
                                {{ product.name }}
                            </div>
                        </div>
                    </div>

                    <div class="lg:max-h-[64vh] lg:min-h-[300px] mt-2 overflow-y-scroll overflow-x-auto customScroll"
                        id="procusctTable">
                        <!-- product table -->
                        <table class="table-auto w-full">
                            <thead class="bg-sky-200 sticky top-0">
                                <tr>
                                    <th class="p-2 text-left font-bold pl-4 text-cyan-900 text-base">
                                        Product
                                    </th>
                                    <th class="p-2 text-center text-cyan-900 text-base font-bold">
                                        Discount
                                    </th>
                                    <th class="p-2 text-center text-cyan-900 text-base font-bold">
                                        Tax
                                    </th>
                                    <th class="p-2 text-center text-cyan-900 text-base font-bold">
                                        Price
                                    </th>
                                    <th class="p-2 text-center text-cyan-900 text-base font-bold">
                                        Qty
                                    </th>
                                    <th class="p-2 w-24 text-right text-cyan-900 text-base font-bold">
                                        Subtotal
                                    </th>
                                    <th class="w-12"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in productBasket" :key="product.id">
                                    <td class="p-2 h-12 text-cyan-900 text-base font-normal border-b border-sky-200">
                                        <div class="truncate w-44 clip text-ellipsis">
                                            {{ product.name }}
                                        </div>
                                    </td>
                                    <td
                                        class="p-2 h-12 text-center text-cyan-900 text-base font-normal border-b border-sky-200">
                                        {{
                                            currency +
                                            product.discount.toFixed(1)
                                        }}
                                    </td>
                                    <td
                                        class="p-2 h-12 text-center text-cyan-900 text-base font-normal border-b border-sky-200">
                                        {{ currency + product.tax.toFixed(1) }}
                                    </td>
                                    <td
                                        class="p-2 h-12 text-center text-cyan-900 text-base font-normal border-b border-sky-200">
                                        {{
                                            currency + product.price.toFixed(1)
                                        }}
                                    </td>
                                    <td
                                        class="p-2 h-12 text-center text-cyan-900 text-base font-normal border-b border-sky-200">
                                        <div class="flex justify-center items-center gap-2">
                                            <button class="w-4 h-4 bg-sky-400 rounded-sm flex justify-center items-center"
                                                @click="
                                                decrimentProductToBasket(
                                                    product
                                                )
                                                    ">
                                                <MinusIcon class="w-4 h-4 text-white/100" />
                                            </button>
                                            <span class="text-cyan-900 text-base font-normal tracking-tight">
                                                {{ product.qty }}
                                            </span>
                                            <button class="w-4 h-4 bg-sky-400 rounded-sm flex justify-center items-center"
                                                @click="
                                                    addProductToBasket(product)
                                                    ">
                                                <PlusIcon class="w-4 h-4 text-white/100" />
                                            </button>
                                        </div>
                                    </td>
                                    <td
                                        class="p-2 h-12 w-24 text-right text-cyan-900 text-base font-normal border-b border-sky-200">
                                        {{
                                            currency +
                                            product.subtotal.toFixed(1)
                                        }}
                                    </td>
                                    <td class="w-12 h-12 border-b border-sky-200 text-center">
                                        <div class="p-0 m-auto flex w-5 h-5 bg-red-400 rounded-full justify-center items-center cursor-pointer"
                                            @click="removeProduct(index)">
                                            <img src="/icons/remove.svg" class="w-2 h-2" />
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="!productBasket.length">
                                    <td colspan="7" class="h-12 border-b border-sky-200 text-center">
                                        No products available in the list
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="sticky bottom-0 bg-white">
                                <tr>
                                    <td colspan="5"
                                        class="p-2 h-12 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium">
                                        Total Items:
                                    </td>
                                    <td
                                        class="text-right p-2 h-12 w-24 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium">
                                        {{ productBasket.length }}({{
                                            totalqty
                                        }})
                                    </td>
                                    <td class="p-2 w-12 h-12 bg-sky-50 border-b border-sky-100"></td>
                                </tr>

                                <tr>
                                    <td colspan="5"
                                        class="p-2 h-12 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium">
                                        Total amount:
                                    </td>
                                    <td
                                        class="text-right p-2 h-12 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium">
                                        {{ currency + totalProductPrice }}
                                    </td>
                                    <td class="p-2 w-12 h-12 bg-sky-50 border-b border-sky-100"></td>
                                </tr>

                                <tr>
                                    <td colspan="5"
                                        class="p-2 h-12 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium">
                                        Discount
                                    </td>
                                    <td
                                        class="text-right p-2 h-12 bg-sky-50 border-b border-sky-100 text-rose-400 text-base font-medium">
                                        <span>-{{
                                            currency +
                                            totalDiscount.toFixed(1)
                                        }}</span>
                                    </td>
                                    <td class="p-2 w-12 h-12 bg-sky-50 border-b border-sky-100"></td>
                                </tr>

                                <tr>
                                    <td class="p-2 h-12 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium"
                                        colspan="5">
                                        <div class="flex gap-2">
                                            <span>Coupon</span>

                                            <div v-if="showCoupon" class="relative">
                                                <input v-model="couponCode" type="text"
                                                    class="w-[198.88px] h-8 pl-2 pr-1 py-1 bg-sky-100 rounded-[5px] text-gray-500 text-base font-normal border-slate-300 outline-none"
                                                    placeholder="Coupon code.." />
                                                <button
                                                    class="absolute right-1 top-2/4 -translate-y-2/4 bg-green-500 rounded-[3px] w-6 h-6 flex justify-center items-center">
                                                    <CheckIcon class="w-6 h-6 text-white" @click="
                                                        applyCoupon(true)
                                                        " />
                                                </button>
                                                <button v-show="!couponCode"
                                                    class="absolute right-1 top-2/4 -translate-y-2/4 bg-red-100 w-6 h-6 flex justify-center items-center">
                                                    <XMarkIcon @click="
                                                        showCoupon = false
                                                        " class="w-6 h-6 text-red-500" />
                                                </button>
                                            </div>

                                            <button v-else
                                                class="w-8 h-8 rounded-md bg-blue-50 cursor-pointer flex justify-center items-center"
                                                @click="showCoupon = true">
                                                <PlusIcon class="w-6 h-6 text-blue-500" />
                                            </button>
                                        </div>
                                    </td>
                                    <td
                                        class="p-2 h-12 bg-sky-50 border-b border-sky-100 text-cyan-900 text-base font-medium text-right">
                                        {{
                                            currency + totalDiscount.toFixed(1)
                                        }}
                                    </td>
                                    <td class="p-2 w-12 h-12 bg-sky-50 border-b border-sky-100"></td>
                                </tr>
                                <tr>
                                    <td class="bg-sky-400 p-2 pr-0" colspan="5">
                                        <div class="w-full justify-end inline-flex text-blue-50 text-base font-bold">
                                            <span>Grand Total:</span>
                                        </div>
                                    </td>
                                    <td class="bg-sky-400 p-2 text-right">
                                        <div class="text-blue-50 text-base font-bold">
                                            {{
                                                currency +
                                                (
                                                    totalProductPrice -
                                                    totalDiscount
                                                ).toFixed(1)
                                            }}
                                        </div>
                                    </td>
                                    <td class="bg-sky-400 p-2 w-12 h-12"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Method -->
                    <div class="flex gap-2 flex-wrap mt-3">
                        <div class="grow relative">
                            <input type="radio" v-model="form.payment_method" name="payment" value="Cash" id="cash"
                                class="peer sr-only" @change="paymentMethod" checked />
                            <label for="cash"
                                class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed text-teal-400 bg-sky-100 h-12 border-2 border-transparent peer-checked:border-teal-400 cursor-pointer">
                                <img src="/icons/cash.svg" alt="" />
                                <span>Cash</span>
                            </label>
                        </div>

                        <div class="grow relative">
                            <input type="radio" v-model="form.payment_method" name="payment" id="card" value="Card"
                                class="peer sr-only" @change="paymentMethod" disabled />
                            <label for="card"
                                class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed text-blue-500 bg-blue-100 h-12 border-2 border-transparent peer-checked:border-blue-500 cursor-pointer peer-disabled:text-blue-300 peer-disabled:cursor-not-allowed"
                                @click="comminsoon()">
                                <img src="/icons/card.svg" alt="" />
                                <span>Card</span>
                            </label>
                        </div>

                        <div class="grow relative">
                            <input type="radio" v-model="form.payment_method" name="payment" id="paypal" value="PayPal"
                                class="peer sr-only" @change="paymentMethod" disabled />
                            <label for="paypal"
                                class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed bg-slate-200 text-indigo-900 h-12 border-2 border-transparent peer-checked:border-indigo-900 cursor-pointer peer-disabled:text-indigo-300 peer-disabled:cursor-not-allowed"
                                @click="comminsoon()">
                                <img src="/icons/paypal.svg" alt="" />
                                <span>PayPal</span>
                            </label>
                        </div>

                        <div class="grow relative">
                            <input type="radio" v-model="form.payment_method" name="payment" id="Cheque" value="Cheque"
                                class="peer sr-only" @change="paymentMethod" disabled />
                            <label for="Cheque"
                                class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed bg-red-100 text-red-400 h-12 border-2 border-transparent peer-checked:border-red-400 cursor-pointer peer-disabled:text-red-300 peer-disabled:cursor-not-allowed"
                                @click="comminsoon()">
                                <img src="/icons/cheque.svg" alt="" />
                                <span>Cheque</span>
                            </label>
                        </div>

                        <div class="grow relative">
                            <input type="radio" v-model="form.payment_method" name="payment" id="Gift" value="Gift Card"
                                class="peer sr-only" @change="paymentMethod" disabled />
                            <label for="Gift"
                                class="flex justify-center items-center gap-2 p-2 text-base font-semibold leading-relaxed bg-violet-100 text-violet-700 h-12 border-2 border-transparent peer-checked:border-violet-700 cursor-pointer peer-disabled:text-violet-300 peer-disabled:cursor-not-allowed"
                                @click="comminsoon()">
                                <img src="/icons/gift.svg" alt="" />
                                <span>Gift Card</span>
                            </label>
                        </div>
                    </div>

                    <!-- action button -->
                    <div class="flex flex-wrap gap-2 mt-4">
                        <button
                            class="h-12 px-4 text-base font-medium leading-tight tracking-tight grow text-red-600 bg-rose-100"
                            @click="cancelAll">
                            Cancel
                        </button>
                        <button @click="saveSaleDraft"
                            class="h-12 px-4 text-base font-medium leading-tight tracking-tight grow text-blue-50 bg-amber-300">
                            Draft
                        </button>
                        <button @click="saveSalePrint"
                            class="h-12 px-4 text-base font-medium leading-tight tracking-tight grow text-blue-50 bg-sky-400">
                            Save & Complate
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="print:hidden">
            <!-- Customer Create Modal -->
            <TransitionRoot as="template" :show="open">
                <Dialog as="div" class="relative z-10" @close="open = false">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                        enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                    </TransitionChild>

                    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                            <TransitionChild as="template" enter="ease-out duration-300"
                                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                leave-from="opacity-100 translate-y-0 sm:scale-100"
                                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <DialogPanel
                                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 md:max-w-2xl lg:max-w-3xl">
                                    <div class="bg-white">
                                        <div class="sm:mt-0">
                                            <DialogTitle as="h3"
                                                class="text-slate-800 font-semibold leading-6 border-b px-5 py-4 flex justify-between gap-2">
                                                Customer Create
                                                <XMarkIcon class="w-6 h-6 cursor-pointer bg-slate-200 rounded-full p-1"
                                                    @click="open = false" />
                                            </DialogTitle>

                                            <div class="grid md:grid-cols-2 gap-4 px-5 py-3 w-full">
                                                <div>
                                                    <label class="text-slate-500" for="customer_group_id">Customer Group
                                                        <span class="text-red-500">*</span></label>
                                                    <select id="customer_group_id" v-model="form.customer_group_id
                                                        "
                                                        class="border-slate-200 bg-slate-50 rounded-lg text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.customer_group_id,
                                                        }">
                                                        <option value="" selected disabled>
                                                            Select customer
                                                            group
                                                        </option>
                                                        <option v-for="customerGroup in customerGroups" :key="customerGroup.id
                                                            " :value="customerGroup.id
        ">
                                                            {{
                                                                customerGroup.name
                                                            }}
                                                        </option>
                                                    </select>
                                                    <span v-if="errors.customer_group_id
                                                        " class="text-red-600 text-sm">
                                                        {{
                                                            errors
                                                                .customer_group_id[0]
                                                        }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="name">Name
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="text" id="name" v-model="form.name"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.name,
                                                        }" placeholder="Enter name" />
                                                    <span v-if="errors.name" class="text-red-600 text-sm">{{
                                                        errors.name[0]
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="phone_number">Phone Number</label>
                                                    <input type="number" id="phone_number" v-model="form.phone_number
                                                            "
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.phone_number,
                                                        }" placeholder="Enter phone number" />
                                                    <span v-if="errors.phone_number
                                                        " class="text-red-600 text-sm">
                                                        {{
                                                            errors
                                                                .phone_number[0]
                                                        }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="email">Email <span
                                                            class="text-red-500">*</span></label>
                                                    <input type="email" id="email" v-model="form.email"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.email,
                                                        }" placeholder="Enter email" />
                                                    <span v-if="errors.email" class="text-red-600 text-sm">{{
                                                        errors.email[0]
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="password">Password</label>
                                                    <input type="password" id="password" v-model="form.password"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.password,
                                                        }" placeholder="Enter password" />
                                                    <span v-if="errors.password" class="text-red-600 text-sm">{{
                                                        errors.password[0]
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="tax_number">Tax Number</label>
                                                    <input type="text" id="tax_number" v-model="form.tax_number
                                                            "
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.tax_number,
                                                        }" placeholder="Enter customer tax number" />
                                                    <span v-if="errors.tax_number" class="text-red-600 text-sm">{{
                                                        errors.tax_number[0]
                                                    }}</span>
                                                </div>
                                                <div class="col-span-2">
                                                    <label class="text-slate-500" for="address">Address
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="text" id="address" v-model="form.address"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.address,
                                                        }" placeholder="Enter customer address" />
                                                    <span v-if="errors.address" class="text-red-600 text-sm">{{
                                                        errors.address[0]
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="country">Country
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="text" id="country" v-model="form.country"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.country,
                                                        }" placeholder="Enter country" />
                                                    <span v-if="errors.country" class="text-red-600 text-sm">{{
                                                        errors.country[0]
                                                    }}</span>
                                                </div>

                                                <div>
                                                    <label class="text-slate-500" for="city">City
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="text" id="city" v-model="form.city"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.country,
                                                        }" placeholder="Enter city" />
                                                    <span v-if="errors.city" class="text-red-600 text-sm">{{
                                                        errors.city[0]
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="state">State</label>
                                                    <input type="text" id="state" v-model="form.state"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.tax_number,
                                                        }" placeholder="Enter state" />
                                                    <span v-if="errors.state" class="text-red-600 text-sm">{{
                                                        errors.state[0]
                                                    }}</span>
                                                </div>
                                                <div>
                                                    <label class="text-slate-500" for="post_code">Post Code</label>
                                                    <input type="text" id="post_code" v-model="form.post_code"
                                                        class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                        :class="{
                                                            'border-red-400 focus:ring-red-400':
                                                                errors.post_code,
                                                        }" placeholder="Enter post code" />
                                                    <span v-if="errors.post_code" class="text-red-600 text-sm">{{
                                                        errors.post_code[0]
                                                    }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 border-t px-4 py-4 sm:flex sm:flex-row-reverse sm:px-5">
                                        <button type="button"
                                            class="inline-flex w-full justify-center rounded-md bg-sky-400 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-600 sm:ml-3 sm:w-auto"
                                            @click="submitCustomer">
                                            Submit
                                        </button>
                                        <button type="button"
                                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                            @click="open = false" ref="cancelButtonRef">
                                            Cancel
                                        </button>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    MinusIcon,
    PlusIcon,
    ChevronLeftIcon,
    XMarkIcon,
    CheckIcon,
    PhoneIcon,
    GlobeAltIcon,
} from "@heroicons/vue/20/solid";
import { useToast } from "vue-toastification";
import Header from "./Header.vue";
onMounted(() => {
    getToken(), posSale(), draftGetData();
});

const key = ref("");

const form = ref({
    customer_id: "",
    payment_method: null,
    brand: "",
    customer_group_id: "",
    name: "",
    phone_number: "",
    email: "",
    address: "",
    country: "",
    city: "",
    state: "",
    post_code: "",
    tax_number: "",
    password: "",
});

const saleData = ref({
    date: new Date(),
    customer_id: "",
    product_ids: "",
    qty: "",
    coupon_id: "",
    paid_amount: "",
    draft_id: null
});

const showCoupon = ref(false);

const couponCode = ref("");

const open = ref(false);

const products = ref([]);

const productId = ref([]);

const categories = ref([]);

const brands = ref([]);

const customers = ref([]);

const customerGroups = ref([]);

const searchCustomers = ref("");

const searchProduct = ref();

const featuredProducts = ref([]);

const featuredProduct = ref([]);

const productBasket = ref([]);

const totalqty = ref(0);

const totalDiscount = ref(0);

const totalProductPrice = ref("0.0");

const currency = ref("$");

const errors = ref([]);

const draftGetData = () => {
    const queryString = window.location.search;
    const params = new URLSearchParams(queryString);
    saleData.value.draft_id = params.get('id');
    if (saleData.value.draft_id) {
        axios
            .get(`/api/draft/details/${saleData.value.draft_id}`, {
                headers: {
                    Authorization: key.value,
                },
            })
            .then(function (response) {
                response.data.data.products.forEach((product) => {
                    addProductToBasket(product)
                })
            })
            .catch(function (error) {
                useToast().error("Something is wrong!");
            });
    }
};

const getToken = () => {
    const token = localStorage.getItem("token");
    if (token) {
        return (key.value = `Bearer ${token}`);
    }
    return (window.location.href = "/");
};

const categoryId = (id) => {
    axios
        .get(`/api/category/product/${id}`, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            featuredProducts.value = response.data.data.products;
        })
        .catch(function (error) {
            useToast().error("Something is wrong!");
        });
};

const comminsoon = () => {
    useToast().error("Comming Soon!");
};

const filterProduct = (product) => {
    return productBasket.value.filter((pr) => pr.id === product.id);
};

const addProductToBasket = (product) => {
    new Audio("/beep.wav").play();
    let selectedProduct = filterProduct(product);
    if (!selectedProduct.length && (product.stock > 0)) {
        productBasket.value.push(product);
        productId.value.push(product.id);
        product.qty = 1;
    } else {
        if (product.stock > 0 && selectedProduct[0].qty < product.stock) {
            selectedProduct[0].qty = Number(selectedProduct[0].qty) + 1;
            const productprice =
                Number(selectedProduct[0].price) -
                Number(selectedProduct[0].discount) +
                Number(selectedProduct[0].tax);
            const subtotal = Number(selectedProduct[0].qty) * productprice;
            selectedProduct[0].subtotal = subtotal;
        }
    }

    searchProduct.value = "";
    featuredProduct.value = "";
    products.value = [];
    totalcount();
    if (couponCode.value != "") {
        applyCoupon();
    }

    var container = document.getElementById("procusctTable");
    container.scrollTop = container.scrollHeight;
};

const decrimentProductToBasket = (product) => {
    const selectedProduct = filterProduct(product);
    if (selectedProduct[0]?.qty > 1) {
        new Audio("/beep.wav").play();
        selectedProduct[0].qty = selectedProduct[0].qty - 1;

        const productprice =
            Number(selectedProduct[0].price) -
            Number(selectedProduct[0].discount) +
            Number(selectedProduct[0].tax);
        const subtotal = Number(selectedProduct[0].qty) * productprice;
        selectedProduct[0].subtotal = subtotal;
        selectedProduct[0].subtotal = subtotal;
    } else {
        const index = productBasket.value
            .map((product) => product.id)
            .indexOf(product.id);
        productBasket.value.splice(index, 1);
    }
    totalcount();
    if (couponCode.value != "") {
        applyCoupon();
    }
};

const removeProduct = (index) => {
    productBasket.value.splice(index, 1);
    totalcount();
    if (couponCode.value != "") {
        applyCoupon();
    }
};

const totalcount = () => {
    let totalQuantity = 0;
    let totalPrice = 0;
    for (let product in productBasket.value) {
        totalQuantity = totalQuantity + productBasket.value[product].qty;
        totalPrice = totalPrice + Number(productBasket.value[product].subtotal);
    }
    totalqty.value = totalQuantity;
    totalProductPrice.value = totalPrice.toFixed(1);
};

const addCustomerModal = () => {
    open.value = true;
};

const addCustomer = (customer) => {
    searchCustomers.value = customer.name;
    saleData.value.customer_id = customer.id;
    customers.value = [];
};

const posSale = () => {
    axios
        .get(`/api/pos`, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            categories.value = response.data.data.categories;
            featuredProducts.value = response.data.data.featuredProducts;
            brands.value = response.data.data.brands;
            customerGroups.value = response.data.data.customerGroups;
            currency.value = response.data.data.currency;
        })
        .catch(function (error) {
            useToast().error("Something is wrong!");
        });
};

const productSearch = () => {
    let searchValue = searchProduct.value;

    if(isNumber(searchValue)){
        // When search value is INT
        if(searchValue.length == 8){
            console.log(searchValue.length);
            searchAndCart();
        }
    }else{
        // When search value is string
        searchAndCart();
    }
    
};

const searchAndCart = () => {
    axios.get(`/api/product/search?search=${searchProduct.value}`, {
        headers: {
            Authorization: key.value,
        },
    })
    .then(function (response) {
        if (response.data.data.products.length == 1) {
            return addProductToBasket(response.data.data.products[0]);
        } else {
            products.value = response.data.data.products;
        }
    })
    .catch(function (error) {
        useToast().error("Something is wrong!");
    });
}

function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); } 

const searchFeaturedProduct = () => {
    axios
        .get(
            `/api/product/search?search=${featuredProduct.value}&is_featured=1`,
            {
                headers: {
                    Authorization: key.value,
                },
            }
        )
        .then(function (response) {
            featuredProducts.value = response.data.data.products;
        })
        .catch(function (error) {
            useToast().error("Something is wrong!");
        });
};

const searchCustomer = () => {
    axios
        .get(`/api/customer/search?search=${searchCustomers.value}`, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            customers.value = response.data.data.customers;
        })
        .catch(function (error) {
            useToast().error("Something is wrong!");
        });
};

const submitCustomer = () => {
    axios
        .post(`/api/customer/store`, form.value, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            searchCustomers.value = response.data.data.customer.name;
            open.value = false;
            useToast().success(response.data.message);
        })
        .catch(function (error) {
            errors.value = error.response.data.errors;
            useToast().error("Something is wrong!");
        });
};

const paymentMethod = () => {
    if (form.value.payment_method != "Cash") {
        useToast().info("Comming Soon!");
    }
};

const applyCoupon = (showToast = false) => {
    const data = { code: couponCode.value, price: totalProductPrice.value };
    axios
        .post(`/api/apply/promo/code`, data, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            totalDiscount.value = Number(response.data.data.discount);
            saleData.value.coupon_id = response.data.data.id;
            if (showToast) {
                useToast().success(response.data.message);
            }
        })
        .catch(function (error) {
            totalDiscount.value = 0;
            if (showToast) {
                useToast().error(error.response.data.message);
            }
        });
};
const saveSaleDraft = () => {
    if (!productBasket.value.length) {
        return useToast().error("Please select a products");
    }
    const qty = [];
    productBasket.value.forEach((product) => {
        qty.push(product.qty);
    });

    saleData.value.paid_amount = totalProductPrice.value;
    saleData.value.product_ids = productId.value;
    saleData.value.qty = qty;
    saleData.value.type = 'Draft';
    axios
        .post(`/api/pos/store`, saleData.value, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            productBasket.value = [];
            productId.value = [];
            totalProductPrice.value = 0;
            totalDiscount.value = 0;
            totalqty.value = 0;
            saleData.value = {};
            const queryString = window.location.search;
            const params = new URLSearchParams(queryString);
            params.delete('id');
            const newURL = window.location.pathname + '?' + params.toString();
            window.history.replaceState({}, '', newURL);
            useToast().success(response.data.message);
        })
        .catch(function (error) {
            useToast().error(error.response.data.message);
        });
}
const saveSalePrint = () => {
    if (!productBasket.value.length) {
        return useToast().error("Please select a products");
    }
    const qty = [];
    productBasket.value.forEach((product) => {
        qty.push(product.qty);
    });
    saleData.value.paid_amount = totalProductPrice.value;
    saleData.value.product_ids = productId.value;
    saleData.value.qty = qty;
    saleData.value.type = 'Sales';
    axios
        .post(`/api/pos/store`, saleData.value, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            productBasket.value = [];
            productId.value = [];
            totalProductPrice.value = 0;
            totalDiscount.value = 0;
            totalqty.value = 0;
            saleData.value = {};
            const queryString = window.location.search;
            const params = new URLSearchParams(queryString);
            params.delete('id');
            const newURL = window.location.pathname + '?' + params.toString();
            window.history.replaceState({}, '', newURL);
            window.location.href = `/sales/invoice/${response.data.data.sale.id}`;
        })
        .catch(function (error) {
            useToast().error(error.response.data.message);
        });
};

const cancelAll = () => {
    productBasket.value = [];
    productId.value = [];
    totalProductPrice.value = "0.0";
    totalDiscount.value = 0;
    totalqty.value = 0;
    saleData.value = {};
    useToast().success("Cancel all sale history");
};
</script>

<style scoped>
.customScroll::-webkit-scrollbar {
    width: 5px !important;
}

.customScroll::-webkit-scrollbar-thumb {
    border-radius: 8px;
    background: #ddd;
}

tfoot {
    background-color: #f0f0f0;
    display: table-footer-group;
}

tfoot::before {
    content: '';
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    background: #f0f0f0;
}

@media print {
    * {
        font-size: 12px;
        line-height: 20px;
    }

    body[data-pdfjsprinting] {
        overflow-y: visible;
        width: 100%;
        height: 100%;
    }

    td,
    th {
        padding: 5px 0;
    }

    @page {
        margin: 1.5cm 0.5cm 0.5cm;
        page-break-after: always;
        page-break-inside: avoid;
        page-break-before: avoid;
    }

    @page: first {
        margin-top: 0.5cm;
    }
}
</style>
