import { reactive } from 'vue';

interface Store {
    selectedMediaId: number | null;
    setSelectedMedia: (value: number | null) => void;
    clearSelectedMedia: () => void;
}

export const store = reactive<Store>({
    selectedMediaId: null,

    setSelectedMedia(value: number | null) {
        this.selectedMediaId = value; // TypeScript now knows `this` refers to `Store`
    },

    clearSelectedMedia() {
        this.selectedMediaId = null; // TypeScript now knows `this` refers to `Store`
    },
});
