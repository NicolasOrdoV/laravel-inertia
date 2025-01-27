<template>
    <ContactLayout title="Create Contact">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Contact
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">


            <FormSection @submitted="submit">
                <template #form>

                    <div class="col-span-6">
                        <h1>Create Contact</h1><br>
                        <InputLabel for="subject" value="Subject" />
                        <TextInput id="subject" v-model="form.subject" type="text" class="block w-full mt-1"
                            autofocus />
                        <InputError :message="errors.subject" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="message" value="Message" />
                        <textarea v-model="form.message" type="text"
                            class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :message="errors.message" class="mt-2" />
                    </div>
                    <div class="col-span-6">
                        <InputLabel for="type" value="Type" />
                        <select class="block w-full mt-1 border-gray-300 rounded-md" v-model="form.type">
                            <option value="company">Company</option>
                            <option value="person">Person</option>
                        </select>
                        <InputError :message="errors.message" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
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
    props: {
        errors: Object,
        contactGeneral: {
            default: {
                id: "",
                subject: "",
                type: "",
                message: "",
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
            id: props.contactGeneral.id,
            subject: props.contactGeneral.subject,
            type: props.contactGeneral.type,
            message: props.contactGeneral.message,
        });

        function submit() {
            if (form.id) {
                router.put(route("contact-general.update", form.id), form);
            } else {
                router.post(route("contact-general.store"), form);
            }
        }

        return {
            form,
            submit,
        };
    }
}
</script>
