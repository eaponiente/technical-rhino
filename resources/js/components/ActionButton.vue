<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    media: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['openModal']);

const emitOpenDeleteModal = () => {
    console.log('emitOpenDeleteModal');
    emit('openModal', props.media); // Emit the updated value
};

</script>

<template>
    <ul class="py-1">
        <li>
            <a :href="route('media.edit', media.id)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Edit
            </a>
        </li>
        <li>
            <button @click="emitOpenDeleteModal" class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-gray-100">
                Delete
            </button>
        </li>
    </ul>
</template>
