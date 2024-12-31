<template>
    <AppLayout title="Create Category">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">


            <FormSection @submitted="submit">
                <template #form>

                    <div class="col-span-6">
                        <h1>Post edit</h1><br>
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" v-model="form.title" type="text" class="block w-full mt-1" autofocus />
                        <InputError :message="errors.title" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput id="slug" v-model="form.slug" type="text" class="block w-full mt-1" />
                        <InputError :message="errors.slug" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="date" value="Date" />
                        <TextInput id="date" v-model="form.date" type="date" class="block w-full mt-1" />
                        <InputError :message="errors.date" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="description" value="Description" />
                        <textarea id="description" v-model="form.description" type="text"
                            class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :message="errors.description" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="posted" value="Posted" />
                        <select v-model="form.posted" class="block w-full mt-1 border-gray-300">
                            <option value="yes">Yes</option>
                            <option value="not">No</option>
                        </select>
                        <InputError :message="errors.posted" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="type" value="Type" />
                        <select v-model="form.type" class="block w-full mt-1 border-gray-300">
                            <option value="Advert">Advert</option>
                            <option value="Post">Post</option>
                            <option value="Movie">Movie</option>
                        </select>
                        <InputError :message="errors.type" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="category_id" value="Category" />
                        <select v-model="form.category_id" class="block w-full mt-1 border-gray-300">
                            <option v-for="c in categories" :value="c.id" :key="c.id">{{ c.title }}</option>
                        </select>
                        <InputError :message="errors.category_id" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>
<script>
import { router, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';


export default {
    props: {
        errors: Object,
        categories: Array,
        post: Object
    },
    components: {
        AppLayout,
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput
    },
    setup(props) {
        const form = useForm({
            title: props.post.title,
            slug: props.post.slug,
            description: props.post.description,
            date: props.post.date,
            posted: props.post.posted,
            type : props.post.type,
        });

        function submit() {
            router.post(route("post.update"), form);
        }

        return {
            form,
            submit,
        };
    }
}
</script>
