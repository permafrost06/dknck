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
const attachment = ref(null);

const [sorted, sort] = useSorter('id');

const sortBy = (by) => {
    sort(by);
    if (dataViz.value) {
        dataViz.value.reload();
    }
};

const getUrl = ({ page, perPage, search }) => {
    let url = LOGS_API_LINK + `?start=${(page - 1) * perPage}&limit=${perPage}`;
    url += `&order_by=${sorted.value.by}&order=${sorted.value.order}`;
    if (search) {
        url += `&search=${search}`;
    }
    return url;
};

const editLink = (item) => LOG_EDIT_LINK.replace('::ID::', item.id);

const highlightText = (text, highlight) => {
    if (!highlight) {
        return text;
    }
    return (text || '').replace(new RegExp(highlight, 'i'), (a) => {
        return `<mark>${a}</mark>`;
    });
};

const showDelete = (item) => {
    deleteUrl.value = LOG_DELETE_LINK.replace('::ID::', item.id);
    toDelete.value = item;
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
const dateFormat = (() => {
    const options = {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    };
    const formater = Intl.DateTimeFormat('en-US', options);
    return (dateTime) => {
        const date = new Date(dateTime);
        const ftt = formater.format(date).split(', ');
        let res = `${ftt[2]} | ${ftt[0]}, ${ftt[1]}`;
        if (res.indexOf(':') == 1) {
            res = '0' + res;
        }
        return res;
    };
})();
</script>

<template>
    <FetchData ref="dataViz" :url="getUrl" v-slot="{ data, loading, search }">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase bg-skin-neutral bg-opacity-5">
                <tr class="whitespace-nowrap">
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
                            [sorted.order]: sorted.by === 'item_code',
                        }"
                        @click="() => sortBy('item_code')"
                    >
                        Item Code
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'brand',
                        }"
                        @click="() => sortBy('brand')"
                    >
                        Brand
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'quantity',
                        }"
                        @click="() => sortBy('quantity')"
                    >
                        Quantity
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'unit_cost',
                        }"
                        @click="() => sortBy('unit_cost')"
                    >
                        Unit Cost
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'adjustment',
                        }"
                        @click="() => sortBy('adjustment')"
                    >
                        Adjustment
                    </th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'paid_money',
                        }"
                        @click="() => sortBy('paid_money')"
                    >
                        Total Cost
                    </th>

                    <th scope="col" class="px-6 py-3">Type</th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'merchant_name',
                        }"
                        @click="() => sortBy('merchant_name')"
                    >
                        Merchant Name
                    </th>

                    <th scope="col" class="px-6 py-3">Merchant Contact</th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'carrier_name',
                        }"
                        @click="() => sortBy('carrier_name')"
                    >
                        Carrier Name
                    </th>

                    <th scope="col" class="px-6 py-3">Carrier Contact</th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'border',
                        }"
                        @click="() => sortBy('border')"
                    >
                        Border
                    </th>

                    <th scope="col" class="px-6 py-3">Remarks</th>

                    <th scope="col" class="px-6 py-3">Attachment</th>

                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'date_time',
                        }"
                        @click="() => sortBy('date_time')"
                    >
                        Date & Time
                    </th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody v-if="loading">
                <tr>
                    <td :colspan="17">
                        <p class="text-center p-10">Loading...</p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else-if="data.length > 0" class="divide-y">
                <tr
                    v-for="(item, idx) in data"
                    class="hover:bg-skin-neutral hover:bg-opacity-5"
                >
                    <td class="px-6 py-4 font-medium whitespace-nowrap">
                        {{ idx + 1 }}
                    </td>
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium whitespace-nowrap"
                        v-html="highlightText(item.item_code, search)"
                    ></th>
                    <td
                        class="px-6 py-4"
                        v-html="highlightText(item.brand, search) || 'N/A'"
                    ></td>
                    <td class="px-6 py-4">{{ item.quantity }}</td>
                    <td class="px-6 py-4">{{ item.unit_cost }}</td>
                    <td class="px-6 py-4">{{ item.adjustment }}</td>
                    <td class="px-6 py-4">{{ item.total_cost }}</td>
                    <td class="px-6 py-4">
                        <p
                            class="text-xs font-medium uppercase px-2 py-0.5 rounded-sm text-skin-inverted"
                            :class="{
                                'bg-skin-success': item.type === 'in',
                                'bg-yellow-500': item.type !== 'in',
                            }"
                        >
                            {{ item.type }}
                        </p>
                    </td>
                    <td
                        class="px-6 py-4"
                        v-html="
                            highlightText(item.merchant_name, search) || 'N/A'
                        "
                    ></td>
                    <td class="px-6 py-4">
                        {{ item.merchant_contact || 'N/A' }}
                    </td>
                    <td
                        class="px-6 py-4"
                        v-html="
                            highlightText(item.carrier_name, search) || 'N/A'
                        "
                    ></td>

                    <td class="px-6 py-4">
                        {{ item.carrier_contact || 'N/A' }}
                    </td>

                    <td
                        class="px-6 py-4"
                        v-html="highlightText(item.border, search) || 'N/A'"
                    ></td>

                    <td
                        class="px-6 py-4"
                        v-html="highlightText(item.remarks, search) || 'N/A'"
                    ></td>

                    <td class="px-6 py-4 text-center">
                        <button
                            v-if="item.attachment"
                            type="button"
                            class="text-skin-inverted rounded-sm px-2 py-1 bg-yellow-500 text-xs hover:bg-yellow-600"
                            @click="attachment = item.attachment"
                        >
                            View
                        </button>
                        <span v-else>N/A</span>
                    </td>

                    <td class="px-6 py-4 text-xs">
                        {{ dateFormat(item.date_time) }}
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
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td :colspan="17">
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
        Are you sure you want to delete the log?
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
        Could not delete the log!
        <p class="text-sm text-skin-danger">{{ deleteError }}</p>
    </AlertModal>
    <div
        v-if="attachment"
        class="fixed z-50 flex w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full bg-black bg-opacity-30 justify-center items-center"
    >
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-skin-foreground rounded-lg shadow">
                <div
                    class="flex items-start justify-between p-4 border-b rounded-t"
                >
                    <h3 class="text-xl font-semibold">
                        Stock Attachment
                    </h3>
                    <button
                        type="button"
                        @click="attachment = null"
                        class="text-skin-secondary bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                </div>
                <div class="h-[60vh]">
                    <iframe
                        v-if="attachment.match(/\.pdf$/)"
                        class="h-full w-full"
                        :src="attachment"
                        frameborder="0"
                    ></iframe>
                    <img
                        v-else
                        :src="attachment"
                        alt=""
                        class="h-full w-full object-contain"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
