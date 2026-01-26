<script setup>

</script>

<template>
  <div class="min-h-screen bg-zinc-900 text-zinc-300">
    <nav class="flex justify-around bg-zinc-800 border-b border-zinc-700 px-4 py-2 flex gap-6">
      <router-link to="/" class="hover:text-zinc-200 transition" active-class="text-zinc-200 font-bold">
        Dashboard
      </router-link>
      <router-link to="/productos" class="hover:text-zinc-200 transition" active-class="text-zinc-200 font-bold">
        Productos
      </router-link>
      <router-link to="/categorias" class="hover:text-zinc-200 transition" active-class="text-zinc-200 font-bold">
        Categorías
      </router-link>
    </nav>

    <main class="p-6">
      <router-view />
    </main>
  </div>  
</template>