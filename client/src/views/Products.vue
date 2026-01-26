<script setup>
import { ref, reactive, onMounted } from 'vue'
import ItemList from '../components/ItemList.vue'

const products = ref([])
const addProduct = reactive({
  name: '',
  description: '',
  price: 0,
  stock: 0,
  category_id: null
})
const modal = ref(false)

const openModal = () => {
  modal.value = true
}

const closeModal = () => {
  modal.value = false
}

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
      addProduct.category_id = null
      await getProduct()
      closeModal()
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
    <div class="flex gap-4 justify-center items-center mb-6">
      <h1 class="text-zinc-200 text-3xl mb-4 uppercase font-bold">LISTA DE PRODUCTOS</h1>
      <button type="button" class="bg-green-500 rounded-lg px-3 py-2 mb-4 text-white" @click="openModal">Agregar</button>
    </div>

    <div class="overflow-hidden rounded-lg border border-zinc-700">
      <div class="flex justify-between bg-zinc-800/50 p-4 text-zinc-400 text-sm uppercase tracking-wider font-bold">
        <span class="w-1/5">Producto</span>
        <span class="w-1/5">Descripción</span>
        <span class="w-1/5">Precio</span>
        <span class="w-1/5">Stock</span>
        <span class="w-1/5">Editar / Eliminar</span>
      </div>

      <div 
        v-for="p in products"
        :key="p.product_id"
        class="flex items-center justify-between bg-zinc-800 p-4 text-zinc-200 border-t border-zinc-700 hover:bg-zinc-700/30 transition-colors"
      >
        <ItemList 
            :name="p.name"
            :description="p.description"
            :price="p.price"
            :stock="p.stock"
        />
      </div>
    </div>

    <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50">
      <form @submit.prevent="handleSubmit" class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-4 py-6 max-w-lg rounded-lg text-zinc-200 relative" v-if="modal">
        <button type="button" class="absolute top-2 right-4 text-2xl" @click="closeModal"><i class="fa-solid fa-xmark"></i></button>
        <h1 class="text-3xl font-bold mb-6">Agregar Producto</h1>
        
        <div class="flex flex-col">
          <label for="name" class="text-left">Nombre</label>
          <input 
            v-model="addProduct.name" 
            type="text" 
            placeholder="Nombre del producto" 
            class="p-2 rounded-lg bg-zinc-700 flex-1"
          >
        </div>
        
        <div class="flex flex-col">
          <label for="description" class="text-left">Descripcion</label>
          <input 
            v-model="addProduct.description" 
            type="text" 
            placeholder="Descripción" 
            class="p-2 rounded-lg bg-zinc-700 flex-1"
          >
        </div>
        
        <div class="flex gap-4">
          <div class="flex flex-col">
            <label for="precio" class="text-left">Precio</label>
            <input 
              v-model.number="addProduct.price" 
              type="number" 
              placeholder="Precio" 
              class="p-2 rounded-lg bg-zinc-700 flex-1"
            >
          </div>
          
          <div class="flex flex-col">
            <label for="stock" class="text-left">Stock</label>
            <input 
            v-model.number="addProduct.stock" 
            type="number" 
            placeholder="Stock" 
            class="p-2 rounded-lg bg-zinc-700 flex-1"
          >
          </div>
        </div>

        <div class="flex flex-col">
          <label for="category_id" class="text-left">Categoria</label>
          <input 
            v-model.number="addProduct.category_id" 
            type="number" 
            placeholder="ID de Categoría" 
            class="p-2 rounded-lg bg-zinc-700 flex-1"
          >
        </div>

        <button 
          type="submit"
          class="bg-green-500 rounded-lg px-3 py-2 font-bold text-white"
        >
          Guardar Producto
        </button>
      </form>
    </div>

    <!-- Previsualizacion -->
    <!-- <pre class="mt-8 p-4 text-xs">
      {{ addProduct }}
    </pre> -->
  </div>
</template>