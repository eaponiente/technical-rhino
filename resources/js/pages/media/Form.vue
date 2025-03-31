<script setup lang="ts">
import MediaLayout from '@/layouts/MediaLayout.vue';
import { computed} from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { Tag, Media } from '@/models/types';

const props = defineProps<{
    tags: Tag[];
    media?: Media;
}>();

const computedTags = computed(() => {
    return props.tags.map((tag) => ({
        id: tag.id,
        name: tag.name.charAt(0).toUpperCase() + tag.name.slice(1),
    }));
});

const form = useForm({
    id: props.media?.id || '',
    title: props.media?.title || '',
    description: props.media?.description || '',
    type: props.media?.type || '',
    author: props.media?.author || '',
    tags: props.media?.tags?.map(tag => tag.id) || [],
    errors: {} as Record<string, string>
});

const submit = () => {
    const isUpdate = route().current('media.edit');
    const method = isUpdate ? 'put' : 'post';
    const actionRoute = isUpdate ? route('media.update', { media: form.id }) : route('media.store');


    form[method](actionRoute, {
        onSuccess: () => {
            router.visit(route('media.index'));
        },
        onBefore: () => {
            console.log('before');
        },
        onError: (errors) => {
            form.errors = errors;
            console.log(form.errors);
        }
    });
};
</script>

<template>
    <MediaLayout>
        <Head title="Create Media" />

        <div class="w-full max-w-lg rounded-lg bg-white p-6 shadow-md">
            <h1 class="mb-6 text-center text-2xl font-bold">Edit Form</h1>

            <!-- Form -->
            <form class="space-y-4" @submit.prevent="submit">
                <!-- Book Title / Movie Field -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Book Title / Movie</label>
                    <input
                        type="text"
                        id="title"
                        v-model="form.title"
                        placeholder="Enter title"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    />
                    <div class="text-red-500" v-if="form.errors.title">{{ form.errors.title }}</div>
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">Author / Director</label>
                    <input
                        type="text"
                        id="author"
                        v-model="form.author"
                        placeholder="Enter author / director"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    />
                    <div class="text-red-500" v-if="form.errors.author">{{ form.errors.author }}</div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        placeholder="Enter description"
                        class="mt-1 block h-24 w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    ></textarea>
                </div>

                <!-- Category -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700">Category</label>
                    <select
                        id="tags"
                        v-model="form.type"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="book">Book</option>
                        <option value="movie">Movie</option>
                    </select>
                    <div class="text-red-500" v-if="form.errors.type">{{ form.errors.type }}</div>
                </div>

                <!-- Tags Selection -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <select
                        id="tags"
                        v-model="form.tags"
                        multiple
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    >
                        <option v-for="tag in computedTags" :value="tag.id" v-html="tag.name"></option>
                    </select>
                    <div class="text-red-500" v-if="form.errors.tags">{{ form.errors.tags }}</div>
                    <small class="text-gray-500">Hold Ctrl (or Cmd) to select multiple tags.</small>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save
                    </button>
                    <a
                        :href="route('media.index')"
                        class="ml-2 rounded-md bg-gray-600 px-4 py-2 text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        >Cancel</a
                    >
                </div>
            </form>
        </div>
    </MediaLayout>
</template>
