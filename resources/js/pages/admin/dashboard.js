import { createApp } from 'vue';
import ProductTable from '@/views/admin/index/ProductTable.vue';

const productApp = createApp(ProductTable);
productApp.mount('#product-table');
