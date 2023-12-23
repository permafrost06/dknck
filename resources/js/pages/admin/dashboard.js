import { createApp } from 'vue';
import ItemsTable from '@/views/admin/index/ItemsTable.vue';

const itemsApp = createApp(ItemsTable);
itemsApp.mount('#items-table');
