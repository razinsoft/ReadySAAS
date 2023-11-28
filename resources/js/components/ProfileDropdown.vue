<template>
    <Menu as="div" class="relative inline-block text-left">
        <div>
            <MenuButton class="w-12 h-12 md:w-14 md:h-14 rounded-full overflow-hidden transition">
                <img :src="image" alt="" class="w-full h-full">
            </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems
                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none divide-y divide-gray-100">
                <div class="py-1">
                    <MenuItem v-slot="{ active }">
                    <a href="/"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Dashboard</a>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                    <a href="#"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Support</a>
                    </MenuItem>
                    <MenuItem v-slot="{ active }">
                    <a href="#"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">License</a>
                    </MenuItem>
                </div>
                <MenuItem v-slot="{ active }">
                <button @click="logout()"
                    :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full px-4 py-2 text-left text-sm']">Sign
                    out</button>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { onMounted, ref } from 'vue';
onMounted(() => {
    getData()
});

const image = ref('');

const getData = () => {
    const getImage = localStorage.getItem('image');

    if (getImage) {
        image.value = getImage;
    } else {
        return window.location.href = '/'
    }

}

const logout = () => {
    localStorage.removeItem('token');
    window.location.href = '/signout';
}
</script>
