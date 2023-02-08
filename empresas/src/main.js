import { createApp } from 'vue'
import store from "./store";
import {createRouter, createWebHistory} from 'vue-router';
import App from './App.vue';
import {routes} from "./routes";

const router = createRouter({
    history : createWebHistory(),
    routes,
});

const app = createApp(App);

app.use(router).use(store);

app.mount('#app');
