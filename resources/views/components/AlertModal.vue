<script setup>
const props = defineProps({
    onCancel: Function
});
</script>

<template>
    <div
        class="fixed top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full flex justify-center items-center bg-black bg-opacity-5"
    >
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-skin-foreground rounded-lg shadow">
                <button
                    type="button"
                    class="absolute top-3 right-2.5 text-skin-secondary bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                    @click="onCancel"
                >
                    <svg
                        aria-hidden="true"
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
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg
                        aria-hidden="true"
                        class="mx-auto mb-4 text-skin-secondary w-14 h-14"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                    </svg>
                    <p class="mb-5 text-lg font-normal text-skin-secondary">
                        <slot></slot>
                    </p>
                    <div class="flex items-center justify-center">
                        <button
                            data-modal-hide="popup-modal"
                            type="button"
                            class="text-skin-secondary bg-skin-foreground hover:bg-skin-neutral hover:bg-opacity-10 rounded-lg border text-sm font-medium px-5 py-2.5 focus:z-10"
                            @click="onCancel"
                        >
                            Okay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
