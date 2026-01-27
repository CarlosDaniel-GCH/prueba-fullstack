<script setup>
defineProps({
    name: String,
    description: String
})

defineEmits(['edit', 'delete'])
</script>

<template>
    <span class="flex justify-center w-1/3 font-semibold text-green-400 truncate pr-2">
        {{ name }}
    </span>

    <span class="flex justify-center w-1/3 text-zinc-400 text-sm truncate pr-4">
        {{ description || 'Sin descripción' }}
    </span>

    <div class="w-1/3 flex justify-center gap-2">
        <button 
            @click="$emit('edit')" 
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-700/30 text-blue-400 hover:bg-blue-400 hover:text-white transition-all duration-200"
            title="Editar categoria"
        >
            <i class="fa-solid fa-pen-to-square text-lg"></i>
        </button>

        <button 
            @click="$emit('delete')" 
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-700/30 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200"
            title="Eliminar categoria"
        >
            <i class="fa-solid fa-trash-can text-lg"></i>
        </button>
    </div>
</template>