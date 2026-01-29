<script setup>
import { ref, onMounted } from 'vue'
import { productService } from '../services/productService'
import { categoryService } from '../services/categoryService';

const product = ref([])
const category = ref([])
const date = new Date()
const fecha = date.toLocaleDateString()

const getProduct = async () => {
    try {
        const data = await productService.getAll()
        product.value = data;
    } catch (e) {
        console.log("Error: ", e)
    }
}

const getCategory = async () => {
    try {
        const data = await categoryService.getAll()
        category.value = data;
    } catch (e) {
        console.log("Error: ", e)
    }
}

onMounted(() => {
    getProduct();
    getCategory();
})
</script>

<template>
    <div class="flex gap-4 text-white">
        <div class="w-1/3 p-4 rounded-lg bg-zinc-700">Productos Totales: {{ product.length }}</div>
        <div class="w-1/3 p-4 rounded-lg bg-zinc-700">Categorias Totales: {{ category.length }}</div>
        <div class="w-1/3 p-4 rounded-lg bg-zinc-700">Fecha: {{ fecha }}</div>
    </div>

    <div class="flex gap-4 mt-4">
        <div class="w-1/2 text-white">
            <div class="flex justify-around border border-zinc-500 px-12 py-4 bg-zinc-700">
                <h1 class="w-1/4 font-bold">Categoria</h1>
                <span class="w-2/4 font-bold">Descripcion</span>
            </div>
            <div v-for="c in category" class="flex justify-around border border-zinc-500 px-12 py-4 bg-zinc-800 hover:bg-zinc-700">
                <h1 class="w-1/4">{{ c.name }}</h1>
                <span class="w-2/4">{{ c.description }}</span>
            </div>
        </div>
        
        <div class="w-1/2 text-white">
            <div class="flex justify-around border border-zinc-500 px-12 py-4 bg-zinc-700">
                <h1 class="w-2/4 font-bold">Producto</h1>
                <span class="w-1/4 font-bold">Precio</span>
                <span class="w-1/4 font-bold">Stock</span>
            </div>
            <div v-for="p in product" class="flex justify-around border border-zinc-500 px-12 py-4 bg-zinc-800 hover:bg-zinc-700">
                <h1 class="w-2/4">{{ p.name }}</h1>
                <span class="w-1/4">{{ p.price }}</span>
                <span class="w-1/4">{{ p.stock }}</span>
            </div>
        </div>
    </div>
</template>