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
                                <Link :href="route('admin.user-functions')" :class="[
                                    'px-3 py-2 rounded-md text-sm font-medium transition-colors',
                                    $page.component === 'Admin/UserFunctions'
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                                ]" :aria-current="$page.component === 'Admin/UserFunctions' ? 'page' : undefined">
                                User Functions
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
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Get User Blog Count</h3>
                        <div class="flex items-center">
                            <input v-model="userEmailForCount" type="email" placeholder="User Email"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-2"
                                required maxlength="50" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                title="Please enter a valid email address (e.g., user@example.com)." />
                            <button @click="getUserBlogCount"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Get Count
                            </button>
                        </div>
                        <p v-if="blogCount !== null" class="mt-2">Blog Count: {{ blogCount }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Get Recent User Blogs</h3>
                        <div class="flex items-center">
                            <input v-model="userEmailForBlogs" type="email" placeholder="User Email"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-2"
                                required maxlength="254" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                title="Please enter a valid email address (e.g., user@example.com)." />

                            <input v-model="limitForBlogs" type="number" placeholder="Limit"
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mr-2"
                                required min="1" max="100" title="Please enter a limit between 1 and 100." />
                            <button @click="getRecentUserBlogs"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Get Blogs
                            </button>
                        </div>
                        <div v-if="recentBlogs.length" class="mt-4">
                            <h4 class="font-semibold mb-2">Recent Blogs:</h4>
                            <ul class="list-disc pl-5">
                                <li v-for="blog in recentBlogs" :key="blog.id" class="mb-2">
                                    {{ blog.title }} ({{ new Date(blog.created_at).toLocaleDateString() }})
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AuthenticatedLayout.vue'
import axios from 'axios'

export default defineComponent({
    components: {
        Link,
        AppLayout,
    },
    data() {
        return {
            userEmailForCount: '',
            blogCount: null,
            userEmailForBlogs: '',
            limitForBlogs: '',
            recentBlogs: [],
        }
    },
    methods: {
        async getUserBlogCount() {
            try {
                const response = await axios.get(route('admin.get-user-blog-count'), {
                    params: { user_email: this.userEmailForCount }
                })
                this.blogCount = response.data.count
            } catch (error) {
                console.error('Error fetching blog count:', error)
            }
        },
        async getRecentUserBlogs() {
            try {
                const response = await axios.get(route('admin.get-recent-user-blogs'), {
                    params: { user_email: this.userEmailForBlogs, limit: this.limitForBlogs }
                })
                this.recentBlogs = response.data.blogs
            } catch (error) {
                console.error('Error fetching recent blogs:', error)
            }
        },
    },
})
</script>