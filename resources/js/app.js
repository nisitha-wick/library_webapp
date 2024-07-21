import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

import booklist from './components/books/booklist.vue';
app.component('booklist', booklist);

app.mount('#app');
