import { createApp } from 'vue';
import StockTable from '@/views/admin/items/StockTable.vue';

const itemsApp = createApp(StockTable);
itemsApp.mount('#items-table');
