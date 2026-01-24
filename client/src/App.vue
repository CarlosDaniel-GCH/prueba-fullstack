<script setup>
import { ref, onMounted } from 'vue'
import ItemList from './components/ItemList.vue'

const products = ref([])

const getProduct = async () => {
  try{
    const API_URL = "http://localhost:8000/api/product"
    const response = await fetch(API_URL)
    if(!response.ok) throw new Error("Error en la peticion")
    const data = await response.json()

    products.value = data.data
  }
  catch(e){
    console.log("Error: ", e)
  }
}

onMounted(() => {
  getProduct()
})
</script>

<template>
  <div>
    <h1 class="text-zinc-200 text-3xl mb-4">LISTA DE PRODUCTOS</h1>
    <button class="bg-green-500 rounded-lg px-3 py-2 mb-4">Agregar</button>

    <div class="flex justify-between bg-zinc-800 p-3 text-zinc-300">
      <h1>Nombre</h1>
      <h2>Descripcion</h2>
      <h2>Precio</h2>
      <span>Stock</span>
    </div>

    <div 
      v-for="p in products"
      :key="p.product_id"
      class="flex justify-between bg-zinc-800 p-3 text-zinc-200"
    >
      <ItemList 
        :name="p.name"
        :description="p.description"
        :price="p.price"
        :stock="p.stock"
      />
    </div>
  </div>
</template>