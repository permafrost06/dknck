<script setup>
import { ref } from 'vue';
import { useSorter } from '../../../js/vue_utils';
import FetchData from '@/views/components/FetchData.vue';
import DeleteModal from '@/views/components/DeleteModal.vue';
import AlertModal from '@/views/components/AlertModal.vue';

const dataViz = ref(null);
const deleteUrl = ref('');
const toDelete = ref(null);
const deleteError = ref('');
const [sorted, sort] = useSorter('id');

/**
 * This is to prevent a warning
 */
const csrf_token = CSRF;

const sortBy = (by) => {
    sort(by);
    if (dataViz.value) {
        dataViz.value.reload();
    }
};

const getUrl = ({page, perPage, search}) => {
    let url =
        CUSTOMERS_API_LINK +
        `?start=${(page - 1) * perPage}&limit=${perPage}`;
    url += `&order_by=${sorted.value.by}&order=${sorted.value.order}`;
    if (search) {
        url += `&search=${search}`;
    }
    return url;
}

const ledgerLink = (item) => CUSTOMERS_LEDGER_LINK.replace('::ID::', item.id);
const editLink = (item) => CUSTOMER_EDIT_LINK.replace('::ID::', item.id);

const highlightText = (text, highlight) => {
    if (!highlight) {
        return text;
    }
    return text.replace(new RegExp(highlight, 'i'), (a)=>{
        return `<mark>${a}</mark>`;
    });
}

const showDelete = (item) => {
    deleteUrl.value = CUSTOMER_DELETE_LINK.replace('::ID::', item.id);
    toDelete.value = item;
}

const onCompleted = (success, res) => {
    deleteUrl.value = null;
    if (success) {
        toDelete.value = null;
        dataViz.value && dataViz.value.reload();
    } else {
        deleteError.value = res.data?.message || res.message || 'Something went wrong!';
    }
}

</script>

<template>
    <FetchData ref="dataViz" :url="getUrl" v-slot="{data, loading, search}">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase bg-skin-neutral bg-opacity-5">
                <tr>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'id',
                        }"
                        @click="() => sortBy('id')"
                    >
                        Sln
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'name',
                        }"
                        @click="() => sortBy('name')"
                    >
                        Name
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'address',
                        }"
                        @click="() => sortBy('address')"
                    >
                        Address
                    </th>
                    <th scope="col" class="px-6 py-3">Balance (Due)</th>
                    <th scope="col" class="px-6 py-3">Ledger</th>
                    <th scope="col" class="px-6 py-3">Signal</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody v-if="loading">
                <tr>
                    <td colspan="7">
                        <p class="text-center p-10">Loading...</p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else-if="data.length > 0" class="divide-y">
                <tr
                    v-for="(item, idx) in data"
                    class="hover:bg-opacity-5 hover:bg-skin-neutral"
                >
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        {{ idx + 1 }}
                    </td>
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium whitespace-nowrap"
                        v-html="highlightText(item.name, search)"
                    >
                    </th>
                    <td class="px-6 py-4" v-html="highlightText(item.address, search)"></td>
                    <td class="px-6 py-4">
                        {{
                            parseInt(
                                item.sales_sum_goods_of_issues -
                                    item.sales_sum_received_money
                            ) || 0
                        }}
                    </td>
                    <td class="px-6 py-4">
                        <a
                            :href="ledgerLink(item)"
                            class="font-medium text-yellow-500 hover:underline"
                            >View</a
                        >
                    </td>
                    <td class="px-6 py-4">
                        <div
                            class="h-4 w-8 rounded-md"
                            :class="{
                                'bg-skin-danger':
                                    parseInt(
                                        item.sales_sum_goods_of_issues -
                                            item.sales_sum_received_money
                                    ) > item.limit,
                                'bg-skin-success':
                                    parseInt(
                                        item.sales_sum_goods_of_issues -
                                            item.sales_sum_received_money
                                    ) <= item.limit,
                            }"
                        ></div>
                    </td>
                    <td class="px-6 py-4">
                        <a
                            :href="editLink(item)"
                            class="font-medium text-skin-accent hover:underline"
                            >Edit</a
                        >
                        |
                        <button
                            type="button"
                            class="font-medium text-skin-danger hover:underline"
                            @click="() => showDelete(item)"
                            >Delete</button
                        >
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="7">
                        <p class="p-10 text-center">No items here!</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </FetchData>
    <DeleteModal
        v-if="deleteUrl"
        :url="deleteUrl"
        :onCancel="() => {deleteUrl = ''; toDelete = null}"
        :onCompleted="onCompleted"
    >
        <input type="hidden" name="_token" :value="csrf_token"/>
        Are you sure you want to delete the customer <b>{{ toDelete.name }}</b>?
    </DeleteModal>
    <AlertModal v-else-if="deleteError" :onCancel="() => {toDelete = null; deleteError = ''}">
        Could not delete the customer <b>{{ toDelete.name }}</b>!
        <p class="text-sm text-skin-danger">{{ deleteError }}</p>
    </AlertModal>
</template>
