import { createApp } from 'vue';
import StockTable from '@/views/admin/products/StockTable.vue';

const productsApp = createApp(StockTable);
productsApp.mount('#product-table');
