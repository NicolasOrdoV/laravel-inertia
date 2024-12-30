<template>
    <app-layout>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <Link :href="route('category.create')" class="link-button-default">Create</Link>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">ID</th>
                                <th class="border p-3">Title</th>
                                <th class="border p-3">Slug</th>
                                <th class="border p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories.data" :key="category.id">
                                <td class="border p-2">{{ category.id }}</td>
                                <td class="border p-3">{{ category.title }}</td>
                                <td class="border p-3">{{ category.slug }}</td>
                                <td class="border p-3">
                                    <Link :href="route('category.edit', category.id)"
                                        class="link-button-default">
                                    Edit</Link>
                                    <Link as="button" type="button" method="DELETE" :href="route('category.destroy', category.id)"
                                        class="link-button-default">
                                    Delete</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <Pagination :links="categories" />
                </div>
            </div>

        </div>
    </app-layout>
</template>
<script>
import { Link } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Shared/Pagination.vue";

export default {
    components: {
        AppLayout,
        Link,
        Pagination,
    },
    props: {
        categories: Object,
    },
}
</script>
