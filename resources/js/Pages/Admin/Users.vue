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
                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input v-model="searchQuery" @input="searchUsers" type="text" placeholder="Search users..."
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300" />
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="user in filteredUsers" :key="user.id">
                                <td class="px-6 py-4 whitespace-nowrap">{{ user.name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ user.email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select v-model="user.role_id" @change="updateUser(user)"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option v-for="role in roles" :key="role.role_id" :value="role.role_id">{{
                                            role.role_name
                                            }}</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button @click="deleteUser(user)"
                                        class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AuthenticatedLayout.vue'

export default defineComponent({
    components: {
        Link,
        AppLayout,
    },
    props: ['users', 'roles'],
    data() {
        return {
            searchQuery: '',
            filteredUsers: []
        }
    },
    mounted() {
        this.filteredUsers = this.users
    },
    methods: {
        updateUser(user) {
            this.$inertia.put(route('admin.update-user', user.user_id), {
                name: user.name,
                role_id: user.role_id,
            })
        },
        deleteUser(user) {
            if (confirm(`Are you sure you want to delete ${user.name}?`)) {
                this.$inertia.delete(route('admin.delete-user', user.user_id))
            }
        },
        searchUsers() {
            if (this.searchQuery === '') {
                this.filteredUsers = this.users
            } else {
                this.filteredUsers = this.users.filter(user =>
                    user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                    user.email.toLowerCase().includes(this.searchQuery.toLowerCase())
                )
            }
        }
    },
})
</script>