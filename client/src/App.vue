<script setup>

</script>

<template>
  <div class="min-h-screen bg-[#757575]">
    <nav class="flex justify-around text-lg bg-zinc-800 border-b border-zinc-700 p-4 flex gap-6">
      <router-link to="/" class="text-zinc-200 hover:text-zinc-200 transition" active-class="text-zinc-200 font-bold">
        Dashboard
      </router-link>
      <router-link to="/productos" class="text-zinc-200 hover:text-zinc-200 transition" active-class="text-zinc-200 font-bold">
        Productos
      </router-link>
      <router-link to="/categorias" class="text-zinc-200 hover:text-zinc-200 transition" active-class="text-zinc-200 font-bold">
        Categorías
      </router-link>
    </nav>

    <main class="p-6">
      <router-view />
    </main>
  </div>  
</template>