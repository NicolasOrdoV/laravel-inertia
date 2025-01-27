<template>
    <ContactLayout title="Create Person">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Person
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">


            <FormSection @submitted="submit">
                <template #form>

                    <div class="col-span-6">
                        <h1>Create Person</h1><br>
                        <InputLabel for="name" value="Name" />
                        <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1"
                            autofocus />
                        <InputError :message="errors.name" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="surname" value="Surname" />
                        <TextInput id="surname" v-model="form.surname" type="text" class="block w-full mt-1"
                            autofocus />
                        <InputError :message="errors.surname" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="other" value="Other" />
                        <textarea v-model="form.other" type="text"
                            class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :other="errors.other" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="choices" value="Choices" />
                        <select class="block w-full mt-1 border-gray-300 rounded-md" v-model="form.choices">
                            <option value="advert">Advert</option>
                            <option value="post">Post</option>
                            <option value="movie">Movie</option>
                            <option value="other">Other</option>
                        </select>
                        <InputError :message="errors.choices" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                    <span class="mt-1 ml-3 cursor-pointer" @click="$emit('backStepEvent', 1)">Back</span>
                </template>
            </FormSection>
        </div>
    </ContactLayout>
</template>
<script>
import { router, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ContactLayout from "@/Layouts/ContactLayout.vue";


export default {
    emits: ['backStepEvent'],
    props: {
        errors: Object,
        contactGeneralId: {
            type: Number,
        },
        contactPerson: {
            default() {
                return {
                    id: "",
                    name: "",
                    surname: "",
                    other: "",
                    choices: "",
                    contact_general_id: props.contactGeneralId,
                }
            }
        }
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
            id: props.contactPerson.id,
            name: props.contactPerson.name,
            surname: props.contactPerson.surname,
            other: props.contactPerson.other,
            choices: props.contactPerson.choices,
            contact_general_id: props.contactPerson.contact_general_id,
        });

        function submit() {
            if (form.id) {
                router.put(route("contact-person.update", form.id), form);
            } else {
                router.post(route("contact-person.store"), form);
            }
        }

        return {
            form,
            submit,
        };
    }
}
</script>
