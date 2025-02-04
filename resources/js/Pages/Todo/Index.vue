<template>
    <web-layout>
        <confirmation-modal :show="confirmDeleteActive">
            <template v-slot:title>
                Confirmation
            </template>

            <template v-slot:content>
                <p>Are you sure you want to delete the selected record?</p>
            </template>

            <template v-slot:footer>
                <div class="flex flex-row-reverse bg-gray-100 gap-3">
                    <o-button @click="destroy()" variant="danger">Delete</o-button>
                    <o-button @click="confirmDeleteActive = false">Cancel</o-button>
                </div>
            </template>
        </confirmation-modal>
        <div class="card">
            <div class="card-body">
                <h3>App to do</h3>
                <PrimaryButton @click="deleteAll">Delete all</PrimaryButton>
                <form @submit.prevent="create" class="felx gap-2 mt-2">
                    <text-input :class="{ 'text-red-400 bg-red-200': errors.name && todoSelected == 0 }"
                        v-model="form.name" placeholder="Enter your todo" />
                    <primary-button>Send</primary-button>
                </form>
                <InputError v-if="todoSelected == 0" :message="errors.name" />

                <!-- <draggable v-model="myArray" item-key="element">
                    <template #item="{ element }">
                        <div class="border py-3 px-4 mt-2">
                            {{ element }}
                        </div>

                    </template>
                </draggable> -->

                <ul id="listToDo">
                    <draggable v-model="dtodos" item-key="id" @end="order">
                        <template #item="{ element }">
                            <li :date-id="element.id" class="border py-3 px-4 mt-2">
                                <svg @click="status(element)" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    :stroke="element.status == '1' ? '#0F0' : '#000'" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4 inline mr-1">
                                    <path v-if="element.status == '1'" stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    <path v-else stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>

                                <span v-show="!element.editMode" @click="element.editMode = true">{{ element.name
                                    }}</span>
                                <InputError v-if="todoSelected == element.id" :message="errors.name" />
                                <text-input v-show="element.editMode" v-model="element.name"
                                    @keyup.enter="update(todo)" />
                                <button class="floar-right"
                                    @click="confirmDeleteActive = true; deleteTodoRow = element.id">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="h-6 w-6" fill="#F00">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </li>
                        </template>
                    </draggable>
                </ul>
            </div>
        </div>
    </web-layout>
</template>
<script>
import { router } from '@inertiajs/vue3';
import draggable from 'vuedraggable'
import WebLayout from '@/Layouts/WebLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';

export default {
    props: {
        errors: Object,
        todos: Array
    },
    components: {
        WebLayout,
        PrimaryButton,
        TextInput,
        InputError,
        ConfirmationModal,
        draggable
    },
    data() {
        return {
            myArray: ['1', '2', '3'],
            form: {
                name: ''
            },
            todoSelected: 0,
            confirmDeleteActive: false,
            deleteTodoRow: '',
            dtodos: this.todos
        };
    },
    methods: {
        create() {
            this.todoSelected = 0;
            router.post(route('todo.store'), {
                name: this.form.name
            });
            setTimeout(() => {
                window.location.reload();
            }, 500);
        },
        update(todo) {
            this.todoSelected = todo.id;
            todo.editMode = false;
            router.put(route('todo.update', todo.id), {
                name: todo.name
            });
        },
        destroy() {
            this.confirmDeleteActive = false;
            router.delete(route('todo.destroy', this.deleteTodoRow));
        },
        destroyAll() {
            router.delete(route('todo.destroy'));
        },
        status(todo) {
            todo.status = !todo.status;
            router.post(route('todo.status', todo.id), {
                status: todo.status
            });
        },
        order() {
            let ids = [];
            document.querySelectorAll('#listToDo li').forEach((li) => {
                ids.push(li.getAttribute('date-id'));
            });
            router.post(route('todo.order'), {
                ids: ids
            });
        }
    }
}
</script>
