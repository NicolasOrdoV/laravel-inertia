<template>

    <app-layout>
        <confirmation-modal :show="confirmDeleteActive">
        <template v-slot:title>
            Confirmation
        </template>

        <template v-slot:content>
            <p>Are you sure you want to delete the selected record?</p>
        </template>

        <template v-slot:footer>
            <div class="flex flex-row-reverse bg-gray-100 gap-3">
                <o-button @click="deleteCategory()" variant="danger">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </template>
    </confirmation-modal>
        <!-- <o-modal v-model:active="confirmDeleteActive">
            <p class="p-4">
                Seguro que deseas eliminar la categoría?
            </p>
            <div class="p-3 bg-gray-100 flex flex-row-reverse gap-3">
                <o-button variant="danger" @click="deleteCategory()">Delete</o-button>
                <o-button @click="confirmDeleteActive = false">Cancel</o-button>
            </div>
        </o-modal> -->
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
                                    <Link :href="route('category.edit', category.id)" class="mr-3 link-button-default">
                                    Edit</Link>
                                    <!-- <Link as="button" type="button" method="DELETE"
                                        :href="route('category.destroy', category.id)" class="link-button-default">
                                    Delete</Link> -->
                                    <o-button variant="danger" size="small"
                                        @click="confirmDeleteActive = true; deleteCategoryRow = category.id">Delete</o-button>
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
import { Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Shared/Pagination.vue";
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

export default {
    components: {
        AppLayout,
        Link,
        Pagination,
        ConfirmationModal
    },
    props: {
        categories: Object,
    },
    data() {
        return {
            confirmDeleteActive: false,
            deleteCategoryRow: "",
        }
    },
    methods: {
        deleteCategory() {
            router.delete(route('category.destroy', this.deleteCategoryRow));
            this.confirmDeleteActive = false;
        }
    }
}
</script>
