import { createApp } from 'vue';
import ProductList from './components/produtos/ProductList.vue';
import CategoryList from './components/categorias/CategoryList.vue';
import App from "./App.vue";

const app = createApp({});
app.component('app', App);
app.component('category-list', CategoryList);
app.component('product-list', ProductList);

app.mount('#app');