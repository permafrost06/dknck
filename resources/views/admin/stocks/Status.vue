<script setup>
import { ref } from 'vue';
import { useSorter } from '@/js/vue_utils';
import FetchData from '@/views/components/FetchData.vue';

/**
 * This is to prevent a warning
 */
const csrf_token = CSRF;
const update_link = STATUS_EDIT_LINK;

const dataViz = ref(null);
const toEdit = ref(null);
const attachment = ref(null);
const editRemarks = ref(false);
const editAttachment = ref(false);
const preview = ref(null);

const [sorted, sort] = useSorter('id');

const sortBy = (by) => {
    sort(by);
    if (dataViz.value) {
        dataViz.value.reload();
    }
};

const getUrl = ({ page, perPage, search }) => {
    let url =
        STATUS_API_LINK + `?start=${(page - 1) * perPage}&limit=${perPage}`;
    url += `&order_by=${sorted.value.by}&order=${sorted.value.order}`;
    if (search) {
        url += `&search=${search}`;
    }
    return url;
};

const highlightText = (text, highlight) => {
    if (!highlight) {
        return text;
    }
    return (text || '').replace(new RegExp(highlight, 'i'), (a) => {
        return `<mark>${a}</mark>`;
    });
};

const previewFile = (evt) => {
    console.log('Here');
    if (!preview.value) {
        return;
    }
    if (evt.target.files.length === 0) {
        preview.value.innerHTML = '';
        return;
    }
    const file = evt.target.files[0];
    let item;
    if (file.name.match(/\.pdf$/)) {
        item = document.createElement('iframe');
        item.className = 'h-full w-full';
    } else {
        item = document.createElement('img');
        item.className = 'h-full w-full object-contain';
    }
    item.src = URL.createObjectURL(file);
    preview.value.innerHTML = '';
    preview.value.appendChild(item);
};
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
                            [sorted.order]: sorted.by === 'total_in',
                        }"
                        @click="() => sortBy('total_in')"
                    >
                        Total In
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'total_out',
                        }"
                        @click="() => sortBy('total_out')"
                    >
                        Total Out
                    </th>
                    <th
                        scope="col"
                        class="px-6 py-3 sortable"
                        :class="{
                            [sorted.order]: sorted.by === 'in_stock',
                        }"
                        @click="() => sortBy('in_stock')"
                    >
                        In Stock
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

                    <th scope="col" class="px-6 py-3">Attachment</th>
                    <th scope="col" class="px-6 py-3">Remarks</th>
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
                    <td class="px-6 py-4">{{ item.total_in }}</td>
                    <td class="px-6 py-4">{{ item.total_out }}</td>
                    <td class="px-6 py-4">{{ item.in_stock }}</td>
                    <td class="px-6 py-4">{{ item.profit || 0 }}</td>
                    <td class="px-6 py-4">
                        <button
                            v-if="item.item?.attachment"
                            type="button"
                            class="text-skin-accent hover:underline"
                            @click="attachment = item.item.attachment"
                        >
                            View
                        </button>
                        <span v-if="item.item?.attachment" class="mx-1">|</span>
                        <button
                            type="button"
                            class="text-skin-accent hover:underline"
                            @click="
                                () => {
                                    editAttachment = true;
                                    toEdit = item;
                                }
                            "
                        >
                            Edit
                        </button>
                    </td>
                    <td class="px-6 py-4">
                        <p v-html="highlightText(item.item?.remarks, search)"></p>
                        <button
                            type="button"
                            class="text-skin-accent hover:underline"
                            @click="
                                () => {
                                    editRemarks = true;
                                    toEdit = item;
                                }
                            "
                        >
                            Edit
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
                        View Attachment
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
    <div
        v-if="editAttachment"
        class="fixed z-50 flex w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full bg-black bg-opacity-30 justify-center items-center"
    >
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-skin-foreground rounded-lg shadow">
                <div
                    class="flex items-start justify-between p-4 border-b rounded-t"
                >
                    <h3 class="text-xl font-semibold">
                        Edit Attachment
                    </h3>
                    <button
                        type="button"
                        @click="editAttachment = false"
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
                <form
                    class="w-full flex gap-4 p-6 border-b"
                    method="POST"
                    enctype="multipart/form-data"
                    :action="update_link"
                >
                    <input type="hidden" name="_token" :value="csrf_token" />
                    <input
                        type="hidden"
                        name="item_code"
                        :value="toEdit.item_code"
                    />
                    <input
                        type="file"
                        class="hidden"
                        name="attachment"
                        id="file_input"
                        @change="previewFile"
                    />
                    <label
                        for="file_input"
                        class="rounded border hover:bg-skin-neutral hover:bg-opacity-5 font-medium px-4 py-2 cursor-pointer"
                        >Choose File</label
                    >
                    <button
                        type="submit"
                        class="rounded bg-skin-accent hover:bg-skin-accent-hover text-skin-inverted font-medium px-4 py-2 shadow-sm"
                    >
                        Save
                    </button>
                </form>
                <div class="h-[60vh]" ref="preview"></div>
            </div>
        </div>
    </div>
    <div
        v-if="editRemarks"
        class="fixed z-50 flex w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full bg-black bg-opacity-30 justify-center items-center"
    >
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-skin-foreground rounded-lg shadow">
                <div
                    class="flex items-start justify-between p-4 border-b rounded-t"
                >
                    <h3 class="text-xl font-semibold">
                        Edit Remarks
                    </h3>
                    <button
                        type="button"
                        @click="editRemarks = false"
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
                <form
                    class="w-full block gap-4 p-6 border-b"
                    method="POST"
                    enctype="multipart/form-data"
                    :action="update_link"
                >
                    <input type="hidden" name="_token" :value="csrf_token" />
                    <input
                        type="hidden"
                        name="item_code"
                        :value="toEdit.item_code"
                    />
                    <div
                        class="w-full mb-4 border rounded-lg bg-skin-neutral bg-opacity-5"
                    >
                        <div
                            class="px-4 py-2 bg-skin-foreground rounded-t-lg"
                        >
                            <label for="comment" class="sr-only">Remarks</label>
                            <textarea
                                id="comment"
                                rows="4"
                                class="w-full px-0 text-sm bg-skin-foreground border-0 focus:ring-0"
                                placeholder="Write a comment..."
                                name="remarks"
                                required
                            >{{ toEdit.item?.remarks }}</textarea>
                        </div>
                        <div
                            class="flex items-center justify-between px-3 py-2 border-t"
                        >
                            <button
                                type="submit"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-skin-inverted bg-skin-accent rounded-lg focus:ring-4 focus:ring-skin-accent hover:bg-skin-accent-hover"
                            >
                                Update Remarks
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
