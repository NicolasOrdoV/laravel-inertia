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
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <TextInput autofocus v-debounce.500ms="customSearch" :debounce-events="['keyup']"
                            @keyup="customSearch" class="w-full" type="text" v-model="search" placeholder="Search" />
                        <select @change="customSearch" class="rounded w-full border-gray-300" v-model="posted">
                            <option :value="null">Posted</option>
                            <option value="not">Not</option>
                            <option value="yes">Yes</option>
                        </select>
                        <select @change="customSearch" class="rounded w-full border-gray-300" v-model="type">
                            <option :value="null">Type</option>
                            <option value="post">Post</option>
                            <option value="advert">Advert</option>
                            <option value="course">Course</option>
                            <option value="movie">Movie</option>
                        </select>

                        <select @change="customSearch" class="rounded w-full border-gray-300" v-model="category_id">
                            <option :value="null">Category</option>
                            <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                        </select>

                        <TextInput class="w-full" type="date" v-model="from" placeholder="Date from" />
                        <TextInput @keyup="customSearch" class="w-full" type="date" v-model="to"
                            placeholder="Date to" />

                        <div>
                            <PrimaryButton @click="customSearch">Filter</PrimaryButton>
                            <SecondaryButton class="ml-3" @click="cleanFilter">Clean</SecondaryButton>
                        </div>
                    </div>

                    <Link :href="route('post.create')" class="link-button-default">Create</Link>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <!-- <th class="border p-2">ID</th>
                                <th class="border p-3">Title</th>
                                <th class="border p-3">Date</th>
                                <th class="border p-3">Category</th>
                                <th class="border p-3">Description</th>
                                <th class="border p-3">Posted</th>
                                <th class="border p-3">Actions</th> -->
                                <th v-for="c, k in columns" :key="c">
                                    <button @click="sort(k)">
                                        {{ c }}

                                        <template v-if="k == sortColumn">
                                            <template v-if="'asc' == sortDirection">
                                                &uarr;
                                            </template>
                                            <template v-else>
                                                &darr;
                                            </template>
                                        </template>
                                    </button>
                                </th>
                                <th class="border p-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts.data" :key="post.id">
                                <td class="border p-2"><span class="text-center">{{ post.id }}</span></td>
                                <td class="border p-3">{{ post.title.substring(0, 15) }}</td>
                                <td class="border p-3">{{ post.date }}</td>
                                <td class="border p-3">{{ post.category.title }}</td>
                                <td class="border p-3"><textarea
                                        class="w-48 block m-auto">{{ post.description }}</textarea></td>
                                <td class="border p-3">{{ post.posted }}</td>
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

export default {
    components: {
        AppLayout,
        Link,
        Pagination,
        PrimaryButton,
        TextInput,
        SecondaryButton
    },
    props: {
        posts: Object,
        columns: Object,
        categories: Array,
        prop_category_id: String,
        prop_posted: String,
        prop_type: String,
        prop_from: String,
        prop_to: String,
        prop_search: String,
        prop_sort_direction: String,
        prop_sort_column: String,
    },
    data() {
        return {
            confirmDeleteActive: false,
            deletePostRow: "",
            posted: this.prop_posted,
            category_id: this.prop_category_id,
            type: this.prop_type,
            from: this.prop_from,
            to: this.prop_to,
            search: this.prop_search,
            sortDirection: this.prop_sort_direction,
            sortColumn: this.prop_sort_column,
        }
    },
    methods: {
        deletePost() {
            router.delete(route('post.destroy', this.deletePostRow));
            this.confirmDeleteActive = false;
        },
        cleanFilter() {
            router.get(route('post.index'));
        },
        customSearch() {
            router.get(route('post.index', {
                posted: this.posted,
                category_id: this.category_id,
                type: this.type,
                from: this.from,
                to: this.to,
                search: this.search,
                sortColumn: this.sortColumn,
                sortDirection: this.sortDirection == 'asc' ? 'desc' : 'asc',
            }));
        },
        sort(column) {
            this.sortColumn = column;
            this.customSearch();
        }
    }
}
</script>
