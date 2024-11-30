<template>
    <AppLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Blogs
                </h2>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input v-model="search" @keyup.enter="performSearch" type="text" placeholder="Search blogs..."
                            class="w-64 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        <button @click="performSearch"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <button @click="fetchRecentBlogs"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Recent Blogs
                    </button>
                    <button @click="fetchRandomBlog"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        I'm Feeling Lucky
                    </button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div v-if="$page.props.user.role_id === 2 || $page.props.user.role_id === 3" class="mb-4">
                        <Link :href="route('blogs.create')"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create New Blog
                        </Link>
                    </div>
                    <div v-for="blog in displayedBlogs" :key="blog.blog_id" class="mb-4 p-4 border rounded">
                        <h3 class="text-lg font-semibold">
                            {{ blog.title }}
                            <span v-if="blog.categories && blog.categories.length"
                                class="bg-gray-200 text-gray-700 text-sm font-semibold px-3 py-1 rounded-full ml-2">
                                {{ blog.categories[0].category_name }}
                            </span>
                        </h3>
                        <p class="text-gray-600">
                            {{ blog['user.name'] || blog.user?.name || blog.name }} - {{ new
                                Date(blog.created_at).toLocaleDateString() }}
                        </p>
                        <p class="mt-2">{{ blog.content.substring(0, 200) }}...</p>
                        <div class="mt-2">
                            <Link :href="route('blogs.show', blog.blog_id)" class="text-blue-500 hover:underline mr-2">
                            Read More
                            </Link>
                            <Link v-if="$page.props.user.role_id === 3 || $page.props.user.user_id === blog.user_id"
                                :href="route('blogs.edit', blog.blog_id)" class="text-green-500 hover:underline mr-2">
                            Edit
                            </Link>
                            <button v-if="$page.props.user.role_id === 3 || $page.props.user.user_id === blog.user_id"
                                @click="deleteBlog(blog.blog_id)" class="text-red-500 hover:underline">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AuthenticatedLayout.vue';

export default defineComponent({
    components: {
        AppLayout,
        Link,
    },
    props: ['blogs'],
    data() {
        return {
            search: '',
            displayedBlogs: [],
        };
    },
    mounted() {
        this.displayedBlogs = this.blogs;
    },
    methods: {
        deleteBlog(blogId) {
            if (confirm('Are you sure you want to delete this blog?')) {
                this.$inertia.delete(route('blogs.destroy', blogId));
            }
        },
        performSearch() {
            this.$inertia.get(route('blogs.index'), { search: this.search }, {
                preserveState: true,
                preserveScroll: true,
            });
        },
        fetchRecentBlogs() {
            this.$inertia.get(route('blogs.recent'), {}, {
                preserveState: true,
                preserveScroll: true,
            });
        },
        fetchRandomBlog() {
            this.$inertia.get(route('blogs.random'), {}, {
                preserveState: true,
                preserveScroll: true,
            });
        },
    },
    watch: {
        blogs: {
            handler(newBlogs) {
                this.displayedBlogs = newBlogs;
            },
            deep: true,
        },
    },
});
</script>