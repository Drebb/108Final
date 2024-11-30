<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ blog.title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-3xl font-bold mb-4">{{ blog.title }} <span
                            v-if="blog.categories && blog.categories.length"
                            class="bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ blog.categories[0].category_name }}
                        </span> </h1>
                    <p class="text-gray-600 mb-4">{{ blog.user.name }} - {{ new
                        Date(blog.created_at).toLocaleDateString() }}
                    </p>
                    <div class="prose max-w-none">
                        {{ blog.content }}
                    </div>
                    <div class="mt-6">
                        <Link :href="route('blogs.index')" class="text-blue-500 hover:underline">Back to Blogs</Link>
                    </div>
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
        AppLayout,
        Link,
    },
    props: ['blog'],
})
</script>