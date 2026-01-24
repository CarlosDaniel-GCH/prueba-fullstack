<script setup>
import { ref, reactive, onMounted } from 'vue'
import ItemList from './components/ItemList.vue'

const products = ref([])
const addProduct = reactive({
  name: '',
  description: '',
  price: 0,
  stock: 0
})

const handleSubmit = async () => {
  try {
    const API_URL = "http://localhost:8000/api/product"
    const response = await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(addProduct)
    })
    
    if(response.ok) {
      addProduct.name = ''
      addProduct.description = ''
      addProduct.price = 0
      addProduct.stock = 0
      await getProduct()
    }
  } catch (error) {
    console.error("Error al guardar:", error)
  }
}

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
      <span class="w-1/4">Nombre</span>
      <span class="w-1/4">Descripción</span>
      <span class="w-1/4 text-center">Precio</span>
      <span class="w-1/4 text-right">Stock</span>
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

    <hr class="my-8 border-zinc-700">

    <!-- Formulario -->
    <form @submit.prevent="handleSubmit" class="flex flex-col gap-4 max-w-lg">
      <h1 class="text-3xl font-bold">Agregar Producto</h1>
      
      <input 
        v-model="addProduct.name" 
        type="text" 
        placeholder="Nombre del producto" 
        class="p-2 rounded-lg bg-zinc-800 flex-1"
      >
      
      <input 
        v-model="addProduct.description" 
        type="text" 
        placeholder="Descripción" 
        class="p-2 rounded-lg bg-zinc-800 flex-1"
      >
      
      <div class="flex gap-4">
        <input 
          v-model.number="addProduct.price" 
          type="number" 
          placeholder="Precio" 
          class="p-2 rounded-lg bg-zinc-800 flex-1"
        >
        
        <input 
          v-model.number="addProduct.stock" 
          type="number" 
          placeholder="Stock" 
          class="p-2 rounded-lg bg-zinc-800 flex-1"
        >
      </div>

      <button 
        type="submit"
        class="bg-green-500 rounded-lg px-3 py-2"
      >
        Guardar Producto
      </button>
    </form>

    <pre class="mt-8 p-4 rounded text-xs">
      {{ addProduct }}
    </pre>
  </div>
</template>