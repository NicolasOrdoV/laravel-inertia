<template>
    <app-layout>
        <o-modal v-model:active="confirmDeleteActive">
            <p class="p-4">
                Seguro que deseas eliminar el post?
            </p>
            <div class="p-3 bg-gray-100 flex flex-row-reverse gap-3">
                <o-button variant="danger" @click="deletePost()">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </o-modal>
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
                                    <Link :href="route('post.edit', post.id)" class="link-button-default">
                                    Edit</Link>
                                    <!-- <Link as="button" type="button" method="DELETE"
                                        :href="route('post.destroy', post.id)" class="link-button-default">
                                    Delete</Link> -->
                                    <o-button variant="danger" size="small"
                                        @click="confirmDeleteActive = true; deletePostRow = post.id">Delete</o-button>
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
import { Link, router } from "@inertiajs/vue3";
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
    data() {
        return {
            confirmDeleteActive: false,
            deletePostRow: "",
        }
    },
    methods: {
        deletePost() {
            router.delete(route('post.destroy', this.deletePostRow));
            this.confirmDeleteActive = false;
        }
    }
}
</script>
