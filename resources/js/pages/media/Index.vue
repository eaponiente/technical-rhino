<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import MediaLayout from '@/layouts/MediaLayout.vue';
import Modal from '@/components/Modal.vue';
import CreateButton from '@/components/CreateButton.vue';
import ActionButton from '@/components/ActionButton.vue';
import { Media } from '@/models/types';
const props = defineProps<{
    medias: {
        data: Media[];
    },
    success?: boolean;
}>();

const formattedMedias = computed(() => {
    return props.medias.data.map((media) => {
        return {
            ...media,
            tags: media.tags.map((tag) => tag.name).join(', '),
        };
    });
});

const isDropdownOpen = ref(false);
const selectedMedia = ref<number | null>(null);
const isModalOpen = ref(false);

const triggerDropdown = (id: number) => {
    if(selectedMedia.value === id) {
        selectedMedia.value = null;
    } else {
        isDropdownOpen.value = true;
        selectedMedia.value = id;
    }
};

const handleCloseModal = () => {
    resetState();
};

const handleDeleteMedia = () => {
    if (!selectedMedia.value) return;

    const media = selectedMedia.value.id;
    resetState();

    router.delete(route('media.destroy', { media }));
};

const handleEmittedModal = (media: any) => {
    console.log('emittedModal', media);
    selectedMedia.value = media;
    isModalOpen.value = true;
    isDropdownOpen.value = false;
};

const resetState = () => {
    selectedMedia.value = null;
    isModalOpen.value = false;
    isDropdownOpen.value = false;
};
</script>

<template>
    <MediaLayout>
        <Head title="Media Management" />

        <div class="w-full max-w-3xl rounded-lg bg-white p-6 shadow-md">
            <h1 class="mb-6 text-center text-2xl font-bold">Media</h1>

            <CreateButton />

            <table class="block min-w-full border-collapse md:table">
                <thead class="block md:table-header-group">
                    <tr class="border-grey-500 border text-left text-gray-700 md:border-none">
                        <th class="p-3">Name</th>
                        <th class="p-3">Tags</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="block md:table-row-group">
                    <tr v-for="media in formattedMedias" :key="media.id" class="border-grey-500 border bg-white text-gray-700 md:border-none">
                        <td class="p-3">{{ media.title }}</td>
                        <td class="p-3">{{ media.tags }}</td>
                        <td class="relative p-3">
                            <div class="relative inline-block text-left">
                                <button class="text-gray-700 hover:text-gray-900 focus:outline-none" @click="triggerDropdown(media.id)">
                                    Actions
                                    <svg class="ml-1 inline-block h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                                <div v-show="selectedMedia === media.id" class="absolute right-0 z-10 mt-2 w-48 rounded-md bg-white shadow-lg">
                                    <ActionButton :media="media" @open-modal="handleEmittedModal" />
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <Modal :open-modal="isModalOpen" :selected-media:="selectedMedia" @close-modal="handleCloseModal" @delete-media="handleDeleteMedia" />
        </div>
    </MediaLayout>
</template>
