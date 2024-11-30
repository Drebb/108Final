<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-lg font-semibold mb-2">Database Connection Info</h2>
            <p><strong>Default Connection:</strong> {{ dbConnection }}</p>
            <p><strong>Current Connection:</strong> {{ currentConnection }}</p>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    dbConnection: String,
    currentConnection: String,
});
</script>