<script setup lang="ts">
const props = defineProps({
    openModal: Boolean,
    selectedMedia: Object
})

const emit = defineEmits(['closeModal', 'deleteMedia']);

const cancelModal = () => {
    emit('closeModal');
}

const deleteMedia = () => {
    emit('deleteMedia', props.selectedMedia);
}


</script>

<template>
    <div id="modal1" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" v-show="props.openModal">
        <div class="max-w-sm rounded-lg bg-white p-6 shadow-lg">
            <h2 class="mb-4 text-xl font-bold">Confirm Deletion</h2>
            <p class="mb-4">Are you sure you want to delete this entry?</p>
            <div class="flex justify-end space-x-2">
                <button v-on:click="cancelModal" class="rounded bg-gray-200 px-4 py-2">Cancel</button>
                <button v-on:click="deleteMedia" class="rounded bg-red-500 px-4 py-2 text-white">
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>
