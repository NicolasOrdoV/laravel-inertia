<template>
    <ContactLayout title="Create Detail">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Detail
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">


            <FormSection @submitted="submit">
                <template #form>
                    <div class="col-span-6">
                        <h1>Create Detail</h1><br>
                        <InputLabel for="extra" value="Extra" />
                        <textarea v-model="form.extra" type="text"
                            class="block w-full mt-1 border-gray-300 rounded-md"></textarea>
                        <InputError :extra="errors.extra" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                    <span class="mt-1 ml-3 cursor-pointer" @click="$emit('backStepEvent', 2)">Back</span>
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
        contactDetail: {
            default(props) {
                return {
                    id: "",
                    extra: "",
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
            id: props.contactDetail.id,
            extra: props.contactDetail.extra,
            contact_general_id: props.contactDetail.contact_general_id,
        });

        function submit() {
            if (form.id) {
                router.put(route("contact-detail.update", form.id), form);
            } else {
                router.post(route("contact-detail.store"), form);
            }
        }

        return {
            form,
            submit,
        };
    }
}
</script>
