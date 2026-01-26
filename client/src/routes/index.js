import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import Categories from '../views/Categories.vue'
import Products from '../views/Products.vue'

const routes = [
    { path: '/', name: 'Dashboard', component: Dashboard },
    { path: '/productos', name: 'Products', component: Products },
    { path: '/categorias', name: 'Categories', component: Categories }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router