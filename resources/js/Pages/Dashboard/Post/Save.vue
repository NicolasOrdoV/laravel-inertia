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
                        <h1>Post <span v-if="post.id">Edit</span> <span v-else>Create</span></h1><br>
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
                    <div class="col-span-6">
                        <InputLabel for="Image" value="Image" />
                        <!-- <TextInput type="file" class="block w-full mt-1" @input="form.image = $event.taget.files[0]" />
                        <InputError :message="errors.image" class="mt-2" /> -->

                        <o-upload v-slot="{ onclick }" v-model="form.image">
                            <o-button tag="upload-button" variant="primary" @click="onclick">
                                <o-icon icon="upload" />
                                <span>Click to upload</span>
                            </o-button>
                        </o-upload>
                    </div>
                    <div class="col-span-6">

                        <o-upload v-model="dropFile" v-if="post.id" :max-size="5000000" :accept="['image/*']">
                            <section class="">
                                <o-icon icon="upload" />
                                <span>Drop your file here or click to upload</span>
                            </section>

                        </o-upload>
                    </div>

                    <div class="container mt-4" v-if="post.image">
                        <div class="card">
                            <div class="card-body">
                                <img :src="'/image/post/' + post.image" :alt="post.title"
                                    class="rounded-md shadow-md max-w-xs" />
                                <DangerButton @click="form.delete(route('post.image.delete', post.id))">Delete</DangerButton>
                                <a class="my-2 t-2 link-button-default" :href="'/image/post/' + post.image" download>Download</a>
                            </div>

                        </div>
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <span v-if="post.id">Edit</span> <span v-else>Save</span>
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
        <div v-if="post.id != ''" class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <!-- <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-2">
                            <InputLabel for="Image" value="Image" />
                            <TextInput type="file" class="block w-full mt-1"
                                @input="form.image = $event.taget.files[0]" />
                            <InputError :message="errors.image" class="mt-2" />
                            <PrimaryButton @click="upload">
                                Upload
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </AppLayout>
</template>
<script>
import { watch, ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';


export default {
    props: {
        errors: Object,
        categories: Array,
        post: {
            type: Object,
            default: () => ({
                title: "",
                slug: "",
                description: "",
                date: "",
                posted: "",
                type: "",
                category_id: "",
                image: "",
            })
        }
    },
    components: {
        AppLayout,
        FormSection,
        InputError,
        InputLabel,
        PrimaryButton,
        DangerButton,
        TextInput
    },
    setup(props) {
        const form = useForm({
            title: props.post.title,
            slug: props.post.slug,
            description: props.post.description,
            date: props.post.date,
            posted: props.post.posted,
            type: props.post.type,
            image: props.post.image,
        });

        const dropFile = ref();

        function submit() {
            if (props.post.id) {
                //router.put(route("post.update", props.post.id), form);
                router.post(route("post.update", props.post.id), {
                    _method: "put",
                    ...form
                });
            } else {
                router.post(route("post.store"), form);
            }
        }

        function upload() {
            router.post(route("post.upload", props.id), form);
        }

        watch(() => dropFile, (currentValue, oldValue) => {
            router.post(route("post.upload", props.post.id), {
                image: currentValue.value[currentValue.value.length - 1]
            });
        }, { deep: true });

        return {
            form,
            submit,
            upload,
            dropFile
        };


    }
}
</script>
