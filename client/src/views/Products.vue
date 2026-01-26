<script setup>
import { ref, reactive, onMounted } from 'vue'
import ItemList from '../components/ItemList.vue'
import { productService } from '../services/productService'

const products = ref([])
const addProduct = reactive({ name: '', description: '', price: 0, stock: 0, category_id: null })
const editProduct = reactive({ name: '', description: '', price: 0, stock: 0, category_id: null })

const modalAgregar = ref(false)
const modalEditar = ref(false)
const modalEliminar = ref(false)
const editingId = ref(null)
const deleteId = ref(null)

const getProduct = async () => {
    try {
        const data = await productService.getAll()
        products.value = data;
    } catch (e) {
        console.log("Error: ", e)
    }
}

const openModalAgregar = () => modalAgregar.value = true
const closeModalAgregar = () => modalAgregar.value = false

const handleSubmit = async () => {
    try {
        const response = await productService.create(addProduct);

        if (response.ok) {
            Object.assign(addProduct, { name: '', description: '', price: 0, stock: 0, category_id: null });
            closeModalAgregar();
            await getProduct(); 
        } else {
            const errorData = await response.json();
            console.error("Error del servidor:", errorData);
        }
    } catch (error) {
        console.error("Error de conexión:", error);
    }
}

const openModalEditar = (producto) => {
    editingId.value = producto.product_id
    Object.assign(editProduct, producto)
    modalEditar.value = true
}
const closeModalEditar = () => modalEditar.value = false

const handleEdit = async () => {
    try {
        const response = await productService.update(editingId.value, editProduct)
        if (response.ok) {
            closeModalEditar()
            await getProduct()
        }
    } catch (error) { console.log("Fallo en la operación", error) }
}

const openModalDelete = (id) => {
    deleteId.value = id
    modalEliminar.value = true
}
const closeModalDelete = () => {
    modalEliminar.value = false
    deleteId.value = null
}

const handleDelete = async () => {
    try {
        const response = await productService.delete(deleteId.value)
        if (response.ok) {
            await getProduct()
            closeModalDelete()
        }
    } catch (error) { console.log("Fallo en la operacion: ", error) }
}

onMounted(getProduct)
</script>

<template>
    <div>
        <div class="flex gap-4 justify-center items-center mb-6">
            <h1 class="text-zinc-200 text-3xl mb-4 uppercase font-bold">LISTA DE PRODUCTOS</h1>
            <button @click="openModalAgregar" class="bg-green-500 rounded-lg px-3 py-2 mb-4 text-white font-bold">Agregar</button>
        </div>

        <div class="overflow-hidden rounded-lg border border-zinc-700">
            <div class="flex justify-between bg-zinc-800/50 p-4 text-zinc-400 text-sm uppercase tracking-wider font-bold">
                <span class="w-1/5 flex justify-center">Producto</span>
                <span class="w-1/5 flex justify-center">Descripción</span>
                <span class="w-1/5 flex justify-center">Precio</span>
                <span class="w-1/5 flex justify-center">Stock</span>
                <span class="w-1/5 flex justify-center">Editar / Eliminar</span>
            </div>

            <div v-if="products && products.length > 0">
                <div v-for="p in products" :key="p.product_id"
                    class="flex items-center justify-between bg-zinc-800 p-4 text-zinc-200 border-t border-zinc-700 hover:bg-zinc-700/30 transition-colors">
                    <ItemList 
                        :name="p.name" 
                        :description="p.description" 
                        :price="p.price" 
                        :stock="p.stock"
                        @edit="openModalEditar(p)" 
                        @delete="openModalDelete(p.product_id)" />
                </div>
            </div>
            <div v-else class="text-white p-10 text-center bg-zinc-800">Cargando productos...</div>
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50" v-if="modalAgregar">
            <form @submit.prevent="handleSubmit" class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-4 py-6 max-w-lg rounded-lg text-zinc-200 relative">
                <button type="button" class="absolute top-2 right-4 text-2xl" @click="closeModalAgregar"><i class="fa-solid fa-xmark"></i></button>
                <h1 class="text-3xl font-bold mb-6">Agregar Producto</h1>
                <div class="flex flex-col text-left">
                    <label>Nombre</label>
                    <input v-model="addProduct.name" type="text" class="p-2 rounded-lg bg-zinc-700" placeholder="Nombre">
                </div>
                <div class="flex flex-col text-left">
                    <label>Descripción</label>
                    <input v-model="addProduct.description" type="text" class="p-2 rounded-lg bg-zinc-700" placeholder="Descripción">
                </div>
                <div class="flex gap-4">
                    <div class="flex flex-col text-left flex-1"><label>Precio</label><input v-model.number="addProduct.price" type="number" class="p-2 rounded-lg bg-zinc-700"></div>
                    <div class="flex flex-col text-left flex-1"><label>Stock</label><input v-model.number="addProduct.stock" type="number" class="p-2 rounded-lg bg-zinc-700"></div>
                </div>
                <div class="flex flex-col text-left"><label>Categoría ID</label><input v-model.number="addProduct.category_id" type="number" class="p-2 rounded-lg bg-zinc-700"></div>
                <button type="submit" class="bg-green-500 rounded-lg px-3 py-2 font-bold text-white">Agregar Producto</button>
            </form>
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50" v-if="modalEditar">
            <form @submit.prevent="handleEdit" class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-4 py-6 max-w-lg rounded-lg text-zinc-200 relative">
                <button type="button" class="absolute top-2 right-4 text-2xl" @click="closeModalEditar"><i class="fa-solid fa-xmark"></i></button>
                <h1 class="text-3xl font-bold mb-6">Editar Producto</h1>
                <div class="flex flex-col text-left">
                    <label>Nombre</label>
                    <input v-model="editProduct.name" type="text" class="p-2 rounded-lg bg-zinc-700">
                </div>
                <div class="flex flex-col text-left">
                    <label>Descripción</label>
                    <input v-model="editProduct.description" type="text" class="p-2 rounded-lg bg-zinc-700">
                </div>
                <div class="flex gap-4">
                    <div class="flex flex-col text-left flex-1"><label>Precio</label><input v-model.number="editProduct.price" type="number" class="p-2 rounded-lg bg-zinc-700"></div>
                    <div class="flex flex-col text-left flex-1"><label>Stock</label><input v-model.number="editProduct.stock" type="number" class="p-2 rounded-lg bg-zinc-700"></div>
                </div>
                <div class="flex flex-col text-left"><label>Categoría ID</label><input v-model.number="editProduct.category_id" type="number" class="p-2 rounded-lg bg-zinc-700"></div>
                <button type="submit" class="bg-green-500 rounded-lg px-3 py-2 font-bold text-white">Editar Producto</button>
            </form>
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50" v-if="modalEliminar">
            <div class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-8 py-6 max-w-lg rounded-lg text-zinc-200 text-center">
                <h1 class="text-2xl font-bold mb-2">¿Eliminar Producto?</h1>
                <p class="text-zinc-400 mb-4">Esta acción no se puede deshacer.</p>
                <div class="flex gap-4">
                    <button @click="handleDelete" class="bg-red-500 hover:bg-red-600 flex-1 rounded-lg px-3 py-2 font-bold text-white">Sí, eliminar</button>
                    <button @click="closeModalDelete" class="bg-zinc-600 hover:bg-zinc-500 flex-1 rounded-lg px-3 py-2 font-bold text-white">No, cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>