import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from '@/portfolio/App.vue';
import { router } from '@/portfolio/router';

const app = createApp(App);

app.use(createPinia());
app.use(router);

app.mount('#portfolio-app');
