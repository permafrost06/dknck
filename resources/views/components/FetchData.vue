<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { gsapTL } from '@/js/utils';

const perPageEntris = [10, 20, 50, 100];

const popover = ref(null);
const perPage = ref(perPageEntris[0]);
const itemCount = ref(0);
const search = ref('');
const page = ref(1);
const data = ref([]);
const loading = ref(false);

const props = defineProps({
    url: String | Function,
});

let cancelSignal = new AbortController();

defineExpose({
    reload: loadData,
});

const reset = () => {
    page.value = 1;
    loading.value = false;
};

const onPerPageChange = (newPerPage) => {
    reset();
    perPage.value = newPerPage;
    loadData();
};

onMounted(() => {
    document.addEventListener('click', hidePopOver);
    loadData();
});

onUnmounted(() => {
    document.removeEventListener('click', hidePopOver);
});

function showPopOver() {
    if (!popover.value || !popover.value.classList.contains('hidden')) {
        return;
    }

    popover.value.classList.remove('hidden');

    gsapTL().fromTo(
        popover.value,
        {
            height: 0,
        },
        {
            height: 'auto',
            duration: 0.3,
        }
    );
}

function hidePopOver() {
    if (!popover.value || popover.value.classList.contains('hidden')) {
        return;
    }
    gsapTL()
        .to(popover.value, {
            height: 0,
            duration: 0.2,
        })
        .then(() => {
            popover.value.classList.add('hidden');
        });
}

function loadData() {
    if (loading.value) {
        cancelSignal.abort();
        cancelSignal = new AbortController();
    }
    loading.value = true;
    let url = props.url;

    if (typeof url === 'function') {
        url = url({
            page: page.value,
            perPage: perPage.value,
            search: search.value,
        });
    }

    fetch(url, {
        withCredentials: true,
        signal: cancelSignal.signal,
    })
        .then(async (res) => {
            const body  = await res.json();
            loading.value = false;
            data.value = body.data;
            itemCount.value = body.count;
        })
        .catch((e) => {
            console.error(e);
            loading.value = false;
        });
}

const maxPage = computed(() => {
    return Math.ceil(itemCount.value / perPage.value);
});

const pages = computed(() => {
    const current = page.value;
    const onEachSide = 3;
    const max = maxPage.value;

    const pages = [];
    const start = Math.max(1, current - onEachSide);
    const end = Math.min(max, current + onEachSide);

    if (start > 1) {
        pages.push(1);
    }
    if (start > 2) {
        pages.push(0);
    }

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    if (max - end > 1) {
        pages.push(0);
    }

    if (max > end) {
        pages.push(max);
    }

    return pages;
});

const setPage = (newPage) => {
    if (newPage < 1 || newPage > maxPage.value || newPage == page.value) {
        return;
    }
    page.value = newPage;
    loadData();
};

let debounced = null;
const searchChange = () => {
    if (debounced) {
        clearTimeout(debounced);
    }
    debounced = setTimeout(() => {
        page.value = 1;
        loadData();
        debounced = null;
    }, 100);
};
</script>

<template>
    <div class="relative sm:rounded-lg">
        <div class="flex flex-wrap gap-2 items-center justify-between pb-4">
            <div class="relative">
                <button
                    class="inline-flex items-center text-skin-secondary border focus:outline-none hover:bg-skin-neutral hover:bg-opacity-10 focus:ring-4 focus:ring-skin-accent font-medium rounded-lg text-sm px-3 py-1.5"
                    type="button"
                    @click.stop="showPopOver"
                >
                    Show {{ perPage }} entries
                    <svg
                        class="w-3 h-3 ml-2"
                        aria-hidden="true"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        ></path>
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div
                    ref="popover"
                    class="hidden overflow-hidden absolute left-0 top-full mt-2 z-10 w-48 bg-skin-foreground divide-y rounded-lg shadow-full shadow"
                >
                    <ul class="p-3 space-y-1 text-sm">
                        <li
                            v-for="entry in perPageEntris"
                            @click="() => onPerPageChange(entry)"
                        >
                            <div
                                class="flex items-center p-2 rounded hover:bg-skin-neutral hover:bg-opacity-5"
                            >
                                <input
                                    type="radio"
                                    :checked="perPage === entry"
                                    class="w-4 h-4 text-skin-accent bg-skin-neutral bg-opacity-5 focus:ring-skin-accent focus:ring-2"
                                />
                                <label
                                    class="w-full ml-2 text-sm font-medium rounded"
                                    >{{ entry }}</label
                                >
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div
                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                >
                    <svg
                        class="w-5 h-5 text-skin-secondary"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>
                <input
                    type="text"
                    id="table-search"
                    class="block p-2 pl-10 text-sm border rounded-lg w-80 bg-skin-neutral bg-opacity-5 focus:ring-skin-accent focus:border-skin-accent"
                    placeholder="Search anything..."
                    v-model="search"
                    @input="searchChange"
                />
            </div>
        </div>
        <div class="overflow-x-auto">
            <slot :data="data" :loading="loading" :search="search"></slot>
        </div>
        <div class="flex justify-between items-center gap-4 border-t pt-4">
            <p class="text-sm font-medium">
                Showing {{ (page - 1) * perPage + 1 }}-{{
                    (page - 1) * perPage + data.length
                }}
                items out of {{ itemCount }}
            </p>
            <nav aria-label="Page navigation example">
                <ul class="inline-flex items-center -space-x-px">
                    <li
                        key="prev"
                        class="block px-3 py-2 ml-0 leading-tight text-skin-secondary border rounded-l-lg"
                        :class="{
                            'cursor-pointer hover:bg-skin-neutral hover:bg-opacity-5':
                                page > 1,
                        }"
                        @click="() => setPage(page - 1)"
                    >
                        <span class="sr-only">Previous</span>
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </li>
                    <li
                        v-for="(pageI, idx) in pages"
                        :key="'page-' + idx"
                        class="px-3 py-2 leading-tight border"
                        :class="{
                            'z-10 text-skin-accent border-skin-accent':
                                pageI == page,
                            'text-skin-secondary hover:bg-skin-neutral hover:bg-opacity-5 cursor-pointer':
                                pageI != page,
                        }"
                        @click="() => setPage(pageI)"
                    >
                        {{ !pageI ? '...' : pageI }}
                    </li>

                    <li
                        key="next"
                        class="block px-3 py-2 leading-tight text-skin-secondary border rounded-r-lg"
                        :class="{
                            'cursor-pointer hover:bg-skin-neutral hover:bg-opacity-5':
                                page < maxPage,
                        }"
                        @click="() => setPage(page + 1)"
                    >
                        <span class="sr-only">Next</span>
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<style scoped>
.shadow-full {
    box-shadow: 0 0 3px var(--tw-shadow-color);
}
</style>
