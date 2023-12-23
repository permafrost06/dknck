import { createApp } from 'vue';
import ItemsTable from '@/views/admin/index/ItemsTable.vue';
import SalesTable from '@/views/admin/sales/SalesTable.vue';

const itemsApp = createApp(ItemsTable);
itemsApp.mount('#items-table');

const salesApp = createApp(SalesTable);
salesApp.mount('#sales-table');