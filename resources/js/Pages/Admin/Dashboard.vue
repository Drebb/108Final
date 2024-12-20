<template>
    <AppLayout>
        <template #header>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row justify-between items-center">
                    <!-- Left: Admin Dashboard Title -->
                    <h1 class="font-semibold text-2xl text-gray-800 leading-tight mb-4 sm:mb-0">
                        Admin Dashboard
                    </h1>

                    <!-- Right: Navigation Links -->
                    <nav aria-label="Admin navigation">
                        <ul class="flex flex-wrap justify-center sm:justify-end space-x-2 sm:space-x-4">
                            <li>
                                <Link :href="route('admin.dashboard')" :class="[
                                    'px-3 py-2 rounded-md text-sm font-medium transition-colors',
                                    $page.component === 'Admin/Dashboard'
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                                ]" :aria-current="$page.component === 'Admin/Dashboard' ? 'page' : undefined">
                                Dashboard
                                </Link>
                            </li>

                            <li>
                                <Link :href="route('admin.users')" :class="[
                                    'px-3 py-2 rounded-md text-sm font-medium transition-colors',
                                    $page.component === 'Admin/Users'
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                                ]" :aria-current="$page.component === 'Admin/Users' ? 'page' : undefined">
                                Users
                                </Link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Blog Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <p class="text-sm text-blue-600">Total Blogs</p>
                            <p class="text-2xl font-bold">{{ statistics.total_blogs }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <p class="text-sm text-green-600">Total Authors</p>
                            <p class="text-2xl font-bold">{{ statistics.total_authors }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <p class="text-sm text-yellow-600">Avg. Content Length</p>
                            <p class="text-2xl font-bold">{{ Math.round(statistics.avg_content_length) }}</p>
                        </div>
                    </div>
                    <button @click="refreshStatistics"
                        class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Refresh Statistics
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Link } from '@inertiajs/vue3'

export default defineComponent({
    components: {
        Link,
        AppLayout,
    },
    props: ['statistics'],
    methods: {
        refreshStatistics() {
            this.$inertia.post(route('admin.refresh-statistics'))
        },
    },
})
</script>