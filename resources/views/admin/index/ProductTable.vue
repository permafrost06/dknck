<script setup>
import { ref } from 'vue';
import { useSorter } from '@/js/vue_utils';
import FetchData from '@/views/components/FetchData.vue';
import DeleteModal from '@/views/components/DeleteModal.vue';
import AlertModal from '@/views/components/AlertModal.vue';

/**
 * This is to prevent a warning
 */
const csrf_token = CSRF;
const dataViz = ref(null);
const deleteUrl = ref('');
const toDelete = ref(null);
const deleteError = ref('');

const [sorted, sort] = useSorter('id');

const sortBy = (by) => {
    sort(by);
    if (dataViz.value) {
        dataViz.value.reload();
    }
};

const getUrl = ({ page, perPage, search }) => {
    let url =
        PRODUCTS_API_LINK + `?start=${(page - 1) * perPage}&limit=${perPage}`;
    url += `&order_by=${sorted.value.by}&order=${sorted.value.order}`;
    if (search) {
        url += `&search=${search}`;
    }
    return url;
};

const editLink = (product) => PRODUCT_EDIT_LINK.replace('::ID::', product.id);

const highlightText = (text, highlight) => {
    if (!highlight) {
        return text;
    }
    return text.replace(new RegExp(highlight, 'i'), (a) => {
        return `<mark>${a}</mark>`;
    });
};

const showDelete = (product) => {
    deleteUrl.value = PRODUCT_DELETE_LINK.replace('::ID::', product.id);
    toDelete.value = product;
};

const onCompleted = (success, res) => {
    deleteUrl.value = null;
    if (success) {
        toDelete.value = null;
        dataViz.value && dataViz.value.reload();
    } else {
        deleteError.value =
            res.data?.message || res.message || 'Something went wrong!';
    }
};

const toIdFormat = (id) => `DKNCK${id.toString().padStart(8, 0)}`;
</script>

<template>
    <FetchData ref="dataViz" :url="getUrl" v-slot="{ data, loading, search }">
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
                        ID
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
                            [sorted.order]: sorted.by === 'vendor',
                        }"
                        @click="() => sortBy('vendor')"
                    >
                        Vendor
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'price',
                        }"
                        @click="() => sortBy('price')"
                    >
                        Buying Price (Unit)
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'quantity',
                        }"
                        @click="() => sortBy('quantity')"
                    >
                        In Stock
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'sold',
                        }"
                        @click="() => sortBy('sold')"
                    >
                        Sold
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'profit',
                        }"
                        @click="() => sortBy('profit')"
                    >
                        Profit
                    </th>

                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody v-if="loading">
                <tr>
                    <td :colspan="8">
                        <p class="text-center p-10">Loading...</p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else-if="data.length > 0" class="divide-y">
                <tr
                    v-for="item in data"
                    class="hover:bg-skin-neutral hover:bg-opacity-5"
                    :key="item.id"
                >
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        {{ toIdFormat(item.id) }}
                    </td>
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium whitespace-nowrap"
                        v-html="highlightText(item.name || 'N/A', search)"
                    ></th>
                    <td
                        class="px-6 py-4"
                        v-html="highlightText(item.vendor, search)"
                    ></td>
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        {{ item.unit_price_buying }}
                    </td>
                    <td class="px-6 py-4">{{ item.quantity }}</td>
                    <td class="px-6 py-4">{{ item.sold }}</td>
                    <td class="px-6 py-4">{{ item.profit }}</td>
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
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td :colspan="8">
                        <p class="p-10 text-center">No items here!</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </FetchData>
    <DeleteModal
        v-if="deleteUrl"
        :url="deleteUrl"
        :onCancel="
            () => {
                deleteUrl = '';
                toDelete = null;
            }
        "
        :onCompleted="onCompleted"
    >
        <input type="hidden" name="_token" :value="csrf_token" />
        Are you sure you want to delete the product?
    </DeleteModal>
    <AlertModal
        v-else-if="deleteError"
        :onCancel="
            () => {
                toDelete = null;
                deleteError = '';
            }
        "
    >
        Could not delete the product!
        <p class="text-sm text-skin-danger">{{ deleteError }}</p>
    </AlertModal>
</template>
