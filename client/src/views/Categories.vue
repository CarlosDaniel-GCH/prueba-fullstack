<script setup>
import { onMounted, reactive, ref } from 'vue'
import  ItemListCategory from '../components/ItemListCategory.vue'
import { categoryService } from '../services/categoryService';

const category = ref([])
const addCategory = reactive({name: '', description: ''})
const editCategory = reactive({name: '', description: ''})
const modalAgregar = ref(false)
const modalEditar = ref(false)
const modalEliminar = ref(false)
const editingId = ref(null)
const deleteId = ref(null)

const getCategory = async () => {
    try {
        const data = await categoryService.getAll()
        category.value = data;
    } catch (e) {
        console.log("Error: ", e)
    }
}

const openModalAgregar = () => modalAgregar.value = true
const closeModalAgregar = () => modalAgregar.value = false

const handleSubmit = async () => {
    try {
        const response = await categoryService.create(addCategory);

        if (response.ok) {
            Object.assign(addCategory, { name: '', description: ''});
            closeModalAgregar();
            await getCategory(); 
        } else {
            const errorData = await response.json();
            console.error("Error del servidor:", errorData);
        }
    } catch (error) {
        console.error("Error de conexión:", error);
    }
}

const openModalEditar = (category) => {
    editingId.value = category.category_id
    Object.assign(editCategory, category)
    modalEditar.value = true
}
const closeModalEditar = () => modalEditar.value = false

const handleEdit = async () => {
    try {
        const response = await categoryService.update(editingId.value, editCategory)
        if (response.ok) {
            closeModalEditar()
            await getCategory()
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
        const response = await categoryService.delete(deleteId.value)
        if (response.ok) {
            await getCategory()
            closeModalDelete()
        }
    } catch (error) { console.log("Fallo en la operacion: ", error) }
}

onMounted(getCategory)
</script>

<template>
    <div class="flex flex-col gap-8">
        <div class="flex gap-4 justify-center items-center">
            <h1 class="text-zinc-200 text-3xl uppercase font-bold">LISTA DE CATEGORIAS</h1>
            <button @click="openModalAgregar" class="bg-green-500 rounded-lg px-3 py-2 text-white font-bold">Agregar</button>
        </div>

        <div class="overflow-hidden rounded-lg border border-zinc-700">
            <div class="flex justify-between bg-zinc-700 p-4 text-zinc-400 text-sm uppercase tracking-wider font-bold">
                <span class="w-1/3 flex justify-center">Categoria</span>
                <span class="w-1/3 flex justify-center">Descripción</span>
                <span class="w-1/3 flex justify-center">Editar / Eliminar</span>
            </div>

            <div v-if="category && category.length > 0">
                <div v-for="c in category" :key="c.category_id"
                    class="flex items-center justify-between bg-zinc-800 p-4 text-zinc-200 border-t border-zinc-700 hover:bg-zinc-700/30 transition-colors">
                    <ItemListCategory 
                        :name="c.name"
                        :description="c.description"
                        @edit="openModalEditar(c)" 
                        @delete="openModalDelete(c.category_id)"
                    />
                </div>
            </div>
            <div v-else class="text-white p-10 text-center bg-zinc-800">Cargando categorias...</div>
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50" v-if="modalAgregar">
            <form @submit.prevent="handleSubmit" class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-4 py-6 max-w-lg rounded-lg text-zinc-200 relative">
                <button type="button" class="absolute top-2 right-4 text-2xl" @click="closeModalAgregar"><i class="fa-solid fa-xmark"></i></button>
                <h1 class="text-3xl font-bold mt-8 mb-4">Agregar Categoria</h1>
                <div class="flex flex-col text-left">
                    <label>Nombre</label>
                    <input v-model="addCategory.name" type="text" class="p-2 rounded-lg bg-zinc-700" placeholder="Nombre">
                </div>
                <div class="flex flex-col text-left">
                    <label>Descripción</label>
                    <input v-model="addCategory.description" type="text" class="p-2 rounded-lg bg-zinc-700" placeholder="Descripción">
                </div>
                <button type="submit" class="bg-green-500 rounded-lg px-3 py-2 font-bold text-white">Guardar</button>
            </form>
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50" v-if="modalEditar">
            <form @submit.prevent="handleEdit" class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-7 pt-14 pb-6 max-w-lg rounded-lg text-zinc-200 relative">
                <button type="button" class="absolute top-2 right-4 text-2xl" @click="closeModalEditar"><i class="fa-solid fa-xmark"></i></button>
                <h1 class="text-3xl font-bold mb-4">Editar Categoria</h1>
                <div class="flex flex-col text-left">
                    <label>Nombre</label>
                    <input v-model="editCategory.name" type="text" class="p-2 rounded-lg bg-zinc-700">
                </div>
                <div class="flex flex-col text-left">
                    <label>Descripción</label>
                    <input v-model="editCategory.description" type="text" class="p-2 rounded-lg bg-zinc-700">
                </div>
                <button type="submit" class="bg-green-500 rounded-lg px-3 py-2 font-bold text-white">Guardar</button>
            </form>
        </div>

        <div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50" v-if="modalEliminar">
            <div class="flex flex-col gap-4 bg-zinc-800 border border-zinc-500 px-8 py-6 max-w-lg rounded-lg text-zinc-200 text-center">
                <h1 class="text-2xl font-bold mb-2">¿Eliminar Categoria?</h1>
                <p class="text-zinc-400 mb-4">Esta acción no se puede deshacer.</p>
                <div class="flex gap-4">
                    <button @click="handleDelete" class="bg-red-500 hover:bg-red-600 flex-1 rounded-lg px-1 py-2 font-bold text-white">Sí, eliminar</button>
                    <button @click="closeModalDelete" class="bg-zinc-600 hover:bg-zinc-500 flex-1 rounded-lg px-1 py-2 font-bold text-white">No, cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>