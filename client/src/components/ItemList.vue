<script setup>
defineProps({
    name: String,
    description: String,
    price: [String, Number],
    stock: Number
})

defineEmits(['edit', 'delete'])
</script>

<template>
    <span class="flex justify-center w-1/5 font-semibold text-green-400 truncate pr-2">
        {{ name }}
    </span>

    <span class="flex justify-center w-1/5 text-zinc-400 text-sm truncate pr-4">
        {{ description || 'Sin descripción' }}
    </span>

    <span class="w-1/5 text-center font-mono text-zinc-200">
        ${{ Number(price).toFixed(2) }}
    </span>

    <div class="w-1/5 flex justify-center">
        <span 
            class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold inline-block"
            :class="stock > 0 ? 'bg-green-500/10 text-green-500 border border-green-500/20' : 'bg-red-500/10 text-red-500 border border-red-500/20'"
        >
            {{ stock > 0 ? stock + ' Unidades' : 'Sin Stock' }}
        </span>
    </div>

    <div class="w-1/5 flex justify-center gap-2">
        <button 
            @click="$emit('edit')" 
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-700/30 text-blue-400 hover:bg-blue-400 hover:text-white transition-all duration-200"
            title="Editar producto"
        >
            <i class="fa-solid fa-pen-to-square text-lg"></i>
        </button>

        <button 
            @click="$emit('delete')" 
            class="w-8 h-8 flex items-center justify-center rounded-lg bg-zinc-700/30 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200"
            title="Eliminar producto"
        >
            <i class="fa-solid fa-trash-can text-lg"></i>
        </button>
    </div>
</template>