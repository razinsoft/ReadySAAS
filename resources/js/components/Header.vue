<template>
    <div class="print:hidden">
        <div class="h-[65px] px-8 bg-white shadow justify-between items-center flex gap-1 print:hidden">
            <div class="flex items-center gap-6">
                <a href="/" class="w-32 md:w-40 transition">
                    <img :src="logoPath" alt="" class="w-full" />
                </a>
            </div>
            <div class="flex items-center gap-8">
                <!-- time -->
                <Time />
                <div class="hidden sm:flex rounded-full justify-center items-center cursor-pointer" @click="backHome()">
                    <img src="/icons/home.svg" alt="" class="w-8 h-8" />
                </div>
                <div class="hidden sm:flex rounded-full justify-center items-center cursor-pointer" @click="backDraft()">
                    <img src="/icons/draft.svg" alt="" class="w-8 h-8" />
                </div>
                <div class="hidden md:flex items-center gap-6 transition">
                    <button @click="storeWalletModal">
                        <img src="/icons/wallet.svg" alt="" class="w-8 h-8" />
                    </button>
                </div>

                <div class="hidden md:flex items-center gap-6 transition">
                    <button @click="zoom">
                        <img :src="isFullscreen
                                ? '/icons/zoom-out.svg'
                                : '/icons/zoom-in.svg'
                            " alt="" class="w-8 h-8" />
                    </button>
                </div>

                <div class="grow-0 rounded-full flex justify-center items-center cursor-pointer"
                    @click="logoutConfirm = true">
                    <img src="/icons/logout.svg" alt="" class="w-8 h-8" />
                </div>
            </div>
        </div>

        <!-- Store Wallet Modal -->
        <TransitionRoot as="template" :show="openStoreWalletModal">
            <Dialog as="div" class="relative z-10" @close="openStoreWalletModal = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
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
                                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 md:max-w-2xl">
                                <div class="bg-white">
                                    <DialogTitle as="h3"
                                        class="text-slate-800 font-semibold leading-6 border-b px-5 py-4 flex justify-between">
                                        Deposit POS Cash
                                        <XMarkIcon class="w-6 h-6 cursor-pointer bg-slate-200 rounded-full p-1" @click="
                                            openStoreWalletModal = false
                                            " />
                                    </DialogTitle>
                                </div>
                                <div class="px-5 py-3">
                                    <div class="flex justify-between flex-wrap gap-2 bg-slate-100 p-3 rounded-lg">
                                        <div class="text-lg">
                                            <span class="text-slate-500">Available Amount :
                                            </span>
                                            <span class="text-sky-500 font-semibold">{{ balance }}</span>
                                        </div>
                                        <div class="text-lg">
                                            <span class="text-slate-500">Today's Sale :
                                            </span>
                                            <span class="text-sky-500 font-semibold">{{ todaySale }}</span>
                                        </div>
                                    </div>
                                    <div :class="form.payment_method == 'Cash'
                                            ? 'grid gap-4 md:grid-cols-2 mt-2 w-full'
                                            : 'grid gap-4 md:grid-cols-3 mt-2 w-full'
                                        ">
                                        <div class="mt-3">
                                            <label class="text-slate-500" for="payment_method">Payment Method<span
                                                    class="text-red-500">*</span></label>
                                            <select id="payment_method" v-model="form.payment_method"
                                                class="border-slate-200 bg-slate-50 rounded-lg text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                :class="{
                                                    'border-red-400 focus:ring-red-400':
                                                        errors.payment_method,
                                                }">
                                                <option value="Cash">
                                                    Cash
                                                </option>
                                                <option value="Bank">
                                                    Bank
                                                </option>
                                            </select>
                                            <span v-if="errors.payment_method" class="text-red-600 text-sm">{{
                                                errors.payment_method[0]
                                            }}</span>
                                        </div>
                                        <div :class="{
                                                    hidden:
                                                        form.payment_method ==
                                                        'Cash',
                                                }" class="mt-3">
                                            <label class="text-slate-500" for="account_id">Account<span
                                                    class="text-red-500">*</span></label>
                                            <select id="account_id" v-model="form.account_id"
                                                class="border-slate-200 bg-slate-50 rounded-lg text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                :class="{
                                                    'border-red-400 focus:ring-red-400':
                                                        errors.account_id,
                                                }">
                                                <option value="" selected disabled>
                                                    Select a account
                                                </option>
                                                <option v-for="account in accounts" :key="account.id" :value="account.id">
                                                    {{ account.name }}
                                                </option>
                                            </select>
                                            <span v-if="errors.customer_group_id" class="text-red-600 text-sm">{{
                                                errors.customer_group_id[0]
                                            }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <label class="text-slate-500" for="amount">Amount
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" id="amount" v-model="form.amount"
                                                class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                :class="{
                                                    'border-red-400 focus:ring-red-400':
                                                        errors.amount,
                                                }" placeholder="Enter amount" />
                                            <span v-if="errors.amount" class="text-red-600 text-sm">{{ errors.amount[0]
                                            }}</span>
                                        </div>
                                    </div>
                                    <div class="grid gap-4 md:grid-cols-2 mt-2 w-full">
                                        <div class="mt-3">
                                            <label class="text-slate-500" for="purpose">Purpose</label>
                                            <input type="text" id="purpose" v-model="form.purpose"
                                                class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                :class="{
                                                    'border-red-400 focus:ring-red-400':
                                                        errors.purpose,
                                                }" placeholder="Enter purpose" />
                                            <span v-if="errors.amount" class="text-red-600 text-sm">{{ errors.purpose[0]
                                            }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <label class="text-slate-500" for="name">Date
                                                <span class="text-red-500">*</span></label>
                                            <input type="date" id="date" v-model="form.date"
                                                class="border-slate-200 bg-slate-50 rounded-lg placeholder:text-slate-400 text-slate-400 focus:ring-slate-300 focus:border-transparent focus:ring-1 w-full mt-2"
                                                :class="{
                                                    'border-red-400 focus:ring-red-400':
                                                        errors.date,
                                                }" />
                                            <span v-if="errors.amount" class="text-red-600 text-sm">{{ errors.date[0]
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-5 py-3 sm:flex sm:flex-row-reverse border-t">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-sky-400 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-sky-600 sm:ml-3 sm:w-auto"
                                        @click="balanceTransfer">
                                        Submit
                                    </button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                        @click="openStoreWalletModal = false" ref="cancelButtonRef">
                                        Cancel
                                    </button>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>

        <!-- logout modal -->
        <TransitionRoot as="template" :show="logoutConfirm">
            <Dialog as="div" class="relative z-10" @close="logoutConfirm = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                    leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
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
                                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div
                                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                                        </div>
                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                            <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">
                                                Logout account</DialogTitle>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-500">
                                                    Are you sure you want to
                                                    Logout your account?
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                                    <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto"
                                        @click="logout()">
                                        Logout
                                    </button>
                                    <button type="button"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-5 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                        @click="logoutConfirm = false" ref="cancelButtonRef">
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
</template>

<script setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    ArrowRightOnRectangleIcon,
    ExclamationTriangleIcon,
    HomeIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline";
import screenfull from "screenfull";
import { onMounted, ref } from "vue";
import { useToast } from "vue-toastification";
import ProfileDropdown from "./ProfileDropdown.vue";
import Time from "./Time.vue";

onMounted(() => {
    getToken(), getData(), getAccounts(), getBalance();
});

const key = ref("");

const isFullscreen = ref(false);
const logoutConfirm = ref(false);

const logoPath = ref("/logo/logo.png");

const name = ref("");

const role = ref("");

const balance = ref(0);

const todaySale = ref(0);

const openStoreWalletModal = ref(false);

const accounts = ref([]);

const errors = ref([]);

const getData = () => {
    const getName = localStorage.getItem("name");
    const getRole = localStorage.getItem("role");

    if (getName || getRole) {
        name.value = getName;
        role.value = getRole;
    } else {
        return (window.location.href = "/");
    }
};

const zoom = () => {
    if (screenfull.isEnabled) {
        screenfull.toggle();
        screenfull.on("change", () => {
            screenfull.isFullscreen
                ? (isFullscreen.value = true)
                : (isFullscreen.value = false);
        });
    }
};

const storeWalletModal = () => {
    openStoreWalletModal.value = true;
};

const form = ref({
    account_id: "",
    amount: "",
    payment_method: "Cash",
    purpose: "",
    date: "",
});

const backHome = () => {
    return (window.location.href = "/");
};

const backDraft = () => {
    return (window.location.href = "/sales/draft");
};

const getToken = () => {
    const token = localStorage.getItem("token");
    if (token) {
        return (key.value = `Bearer ${token}`);
    }
    backHome();
};

const getAccounts = () => {
    axios
        .get(`/api/accounts`, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            accounts.value = response.data.data.accounts;
            logoPath.value = response.data.data.logo_path;
        })
        .catch(function (error) {
            useToast().error("Something is wrong!");
        });
};
const getBalance = () => {
    axios
        .get(`/api/balance`, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            balance.value = response.data.data.balance;
            todaySale.value = response.data.data.todaySale;
        })
        .catch(function (error) {
            useToast().error("Something is wrong!");
        });
};

const balanceTransfer = () => {
    axios
        .post(`/api/balance/transfer`, form.value, {
            headers: {
                Authorization: key.value,
            },
        })
        .then(function (response) {
            balance.value = response.data.data.balance;
            useToast().success(response.data.message);
        })
        .catch(function (error) {
            useToast().error(error.response.data.message);
        });
};

const logout = () => {
    localStorage.removeItem("token");
    window.location.href = "/signout";
};
</script>

<style lang="scss" scoped></style>
