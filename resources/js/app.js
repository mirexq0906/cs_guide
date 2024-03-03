import {createApp} from "vue";
import App from './App.vue';
import PrimeVue from 'primevue/config';
import 'primevue/resources/themes/saga-blue/theme.css';
import '/node_modules/primeflex/primeflex.css';
import 'primeicons/primeicons.css';
import router from "./router";
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';
import Store from './store/index.js'
import MyBreadcrumb from "@/components/common/MyBreadcrumb.vue";

const app = createApp(App)
app.use(PrimeVue);
app.use(router);
app.use(ConfirmationService);
app.use(ToastService);
app.use(Store)
app.component('MyBreadcrumb', MyBreadcrumb)
app.mount('#app')
