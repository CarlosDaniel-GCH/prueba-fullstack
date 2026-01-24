<script setup>
defineProps({
    name: String,
    description: String,
    price: String,
    stock: Number
})
</script>

<template>
    <h1>{{ name }}</h1>
    <h2>{{ description }}</h2>
    <h2>{{ price }}</h2>
    <span>{{ stock }}</span>
</template>