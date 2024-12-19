import './bootstrap'
import { createApp } from 'vue';
import Notifications from './components/Notifications.vue';

const app = createApp(Notifications);

app.mount('#app');

