<template>
    <div class="text-sm sm:text-xl font-bold tracking-tight leading-tight" id="dateTimeSection">
        {{ moment().format("DD MMM, yyyy") }} |
        {{ hours }} <span class="animated-element sm:text-2xl leading-3">:</span> {{ minutes }}
    </div>
</template>

<script setup>
import moment from "moment";
import { ref, onMounted, onBeforeMount } from "vue";

const hours = ref(0);
const minutes = ref(0);

const updateTime = () => {
    const now = new Date();
    hours.value = now.getHours().toString().padStart(2, "0");
    minutes.value = now.getMinutes().toString().padStart(2, "0");
};

onMounted(() => {
    updateTime();
});

onBeforeMount(() => {
    updateTime();
    setInterval(updateTime, 1000); // Update the time every second
});

</script>
<style>
.animated-element {
    color: #1f2937;
    animation: myAnimation 1s ease-in-out infinite;
    transition: 1s ease-in-out;
}

@keyframes myAnimation {
    0% {
        color: #d1d5db;
    }
    100% {
        color: #1f2937;
    }
}
@media (max-width:420px) {
    #dateTimeSection{
        display: none;
    }
}
</style>
