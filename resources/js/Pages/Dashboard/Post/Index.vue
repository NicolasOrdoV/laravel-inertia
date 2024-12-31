<template>
    <app-layout>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <Link :href="route('post.create')" class="link-button-default">Create</Link>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">ID</th>
                                <th class="border p-3">Title</th>
                                <th class="border p-3">Slug</th>
                                <th class="border p-3">Description</th>
                                <th class="border p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts.data" :key="post.id">
                                <td class="border p-2">{{ post.id }}</td>
                                <td class="border p-3">{{ post.title }}</td>
                                <td class="border p-3">{{ post.slug }}</td>
                                <td class="border p-3">{{ post.description }}</td>
                                <td class="border p-3">
                                    <Link :href="route('post.edit', post.id)"
                                        class="link-button-default">
                                    Edit</Link>
                                    <Link as="button" type="button" method="DELETE" :href="route('post.destroy', post.id)"
                                        class="link-button-default">
                                    Delete</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <Pagination :links="posts" />
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
        posts: Object,
    },
}
</script>
