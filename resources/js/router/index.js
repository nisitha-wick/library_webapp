import { createRouter, createWebHistory } from "vue-router";

import bookIndex from '../components/books/booklist.vue';

const routes = [{
    path:'/',
    name: 'books.index',
    component: bookIndex
}]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;