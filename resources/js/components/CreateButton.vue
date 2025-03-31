<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

function createNew() {
    router.visit(route('media.create'));
}
</script>

<template>
    <div class="flex justify-end mb-4">
        

        <Button label="Create New" @click="createNew" />
        
    </div>
</template>