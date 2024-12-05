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
                        <svg id='Sort_By_Recently_Viewed_24' width='24' height='24' viewBox='0 0 24 24'
                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                            <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                            <g transform="matrix(1 0 0 1 12 12)">
                                <path
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                    transform=" translate(-12, -13)"
                                    d="M 2 3 L 2 15 C 2 16.093063 2.9069372 17 4 17 L 11 17 L 11 19 L 8 19 L 12 23 L 16 19 L 13 19 L 13 17 L 20 17 C 21.093063 17 22 16.093063 22 15 L 22 3 L 20 3 L 20 15 L 4 15 L 4 3 L 2 3 z M 12 5 C 8 5 6 9 6 9 C 6 9 8 13 12 13 C 16 13 18 9 18 9 C 18 9 16 5 12 5 z M 12 7 C 13.104 7 14 7.896 14 9 C 14 10.104 13.104 11 12 11 C 10.896 11 10 10.104 10 9 C 10 7.896 10.896 7 12 7 z"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </button>
                    <button @click="fetchRandomBlog"
                        class="bg-green-500 hover:bg-green-700 font-bold py-2 px-4 rounded">
                        <svg id='Dice_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'
                            xmlns:xlink='http://www.w3.org/1999/xlink'>
                            <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />
                            <g transform="matrix(0.5 0 0 0.5 12 12)">
                                <path
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                    transform=" translate(-24, -24)"
                                    d="M 40.018 11.05 L 28.332 5.033 C 28.331 5.033 28.330000000000002 5.032 28.329 5.032 C 25.618000000000002 3.6420000000000003 22.381 3.644 19.668 5.033 L 7.982 11.05 C 6.143 11.997 5 13.87 5 15.939 L 5 32.06 C 5 34.129000000000005 6.143 36.003 7.982 36.95 L 19.67 42.968 C 21.024 43.662000000000006 22.512 44.009 23.998 44.009 C 25.486 44.009 26.974 43.662 28.331000000000003 42.967 L 40.017 36.949999999999996 C 41.857000000000006 36.00299999999999 42.999 34.129999999999995 42.999 32.059999999999995 L 42.999 15.939 C 43 13.87 41.857 11.997 40.018 11.05 z M 24 11 C 25.381 11 26.5 11.672 26.5 12.5 C 26.5 13.328 25.381 14 24 14 C 22.619 14 21.5 13.328 21.5 12.5 C 21.5 11.672 22.619 11 24 11 z M 9.5 25 C 8.672 25 8 23.881 8 22.5 C 8 21.119 8.672 20 9.5 20 C 10.328 20 11 21.119 11 22.5 C 11 23.881 10.328 25 9.5 25 z M 13.5 31 C 12.672 31 12 29.881 12 28.5 C 12 27.119 12.672 26 13.5 26 C 14.328 26 15 27.119 15 28.5 C 15 29.881 14.328 31 13.5 31 z M 17.5 37 C 16.672 37 16 35.881 16 34.5 C 16 33.119 16.672 32 17.5 32 C 18.328 32 19 33.119 19 34.5 C 19 35.881 18.328 37 17.5 37 z M 31.5 35 C 30.672 35 30 33.881 30 32.5 C 30 31.119 30.672 30 31.5 30 C 32.328 30 33 31.119 33 32.5 C 33 33.881 32.328 35 31.5 35 z M 36.5 26 C 35.672 26 35 24.881 35 23.5 C 35 22.119 35.672 21 36.5 21 C 37.328 21 38 22.119 38 23.5 C 38 24.881 37.328 26 36.5 26 z M 39.138 16.857 L 28.305999999999997 21.945999999999998 C 27.421999999999997 22.406 26.471999999999998 22.698999999999998 25.499999999999996 22.854 L 25.499999999999996 39.486000000000004 C 25.499999999999996 40.315000000000005 24.827999999999996 40.986000000000004 23.999999999999996 40.986000000000004 C 23.171999999999997 40.986000000000004 22.499999999999996 40.315000000000005 22.499999999999996 39.486000000000004 L 22.499999999999996 22.849 C 21.516 22.69 20.547999999999995 22.391000000000002 19.641 21.919 L 8.862 16.857 C 8.112 16.505 7.79 15.610999999999999 8.142 14.861999999999998 C 8.494 14.110999999999999 9.388 13.788999999999998 10.137 14.141999999999998 L 20.969 19.230999999999998 C 22.887 20.226 25.113 20.223999999999997 26.976 19.256999999999998 L 37.861999999999995 14.141999999999998 C 38.611 13.788999999999998 39.504999999999995 14.111999999999998 39.85699999999999 14.861999999999998 C 40.21 15.612 39.888 16.505 39.138 16.857 z"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
                    </button>

                    <button @click="resetBlogs"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <svg id='Clear_Filters_24' width='24' height='24' viewBox='0 0 24 24'
                            xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                            <rect width='24' height='24' stroke='none' fill='#000000' opacity='0' />


                            <g transform="matrix(0.77 0 0 0.77 12 12)">
                                <path
                                    style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;"
                                    transform=" translate(-13, -12.97)"
                                    d="M 2 0 C 0.898438 0 0 0.898438 0 2 L 9 12 L 17 12 L 26 2 C 26 0.898438 25.101563 0 24 0 Z M 10.4375 1.9375 C 10.550781 1.9375 10.636719 1.992188 10.6875 2.09375 L 13 4.40625 L 15.3125 2.09375 C 15.511719 1.894531 15.804688 1.894531 15.90625 2.09375 L 16.90625 3.09375 C 17.105469 3.292969 17.105469 3.585938 16.90625 3.6875 L 14.59375 6 L 16.90625 8.3125 C 17.105469 8.511719 17.105469 8.804688 16.90625 8.90625 L 15.90625 9.90625 C 15.707031 10.105469 15.414063 10.105469 15.3125 9.90625 L 13 7.59375 L 10.6875 9.90625 C 10.488281 10.105469 10.195313 10.105469 10.09375 9.90625 L 9.09375 8.90625 C 8.992188 8.707031 8.992188 8.414063 9.09375 8.3125 L 11.40625 6 L 9.09375 3.6875 C 8.992188 3.585938 8.992188 3.292969 9.09375 3.09375 L 10.09375 2.09375 C 10.195313 1.992188 10.324219 1.9375 10.4375 1.9375 Z M 9 13 L 9 21.40625 C 9 22.507813 9.898438 23.789063 11 24.1875 L 15 25.8125 C 16.101563 26.210938 17 25.695313 17 24.59375 L 17 13 Z"
                                    stroke-linecap="round" />
                            </g>
                        </svg>
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

        resetBlogs() {
            this.$inertia.get(route('blogs.index'), {}, {
                preserveState: true,
                preserveScroll: true,
            });
            this.search = '';
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