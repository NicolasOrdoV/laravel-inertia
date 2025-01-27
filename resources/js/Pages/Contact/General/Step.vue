<template>
    <div>
        <ContactLayout>
            <div class="flex" v-if="$page.props.step != 4">
                <div class="flex mx-auto flex-col sm:flex-row">
                    <div class="step" :class="{ active: $page.props.step == 1 }">
                        STEP 1
                    </div>
                    <div class="step" :class="{ active: parseInt($page.props.step) == 2 }">
                        STEP 2
                    </div>
                    <div class="step" :class="{ active: $page.props.step == 3 }">
                        STEP 3
                    </div>
                </div>
            </div>
            <ContactGeneral v-if="$page.props.step == 1" :errors="errors" :contactGeneral="contactGeneral" />
            <div v-if="contactGeneral">
                <ContactCompany :contactGeneralId="contactGeneral.id" :errors="errors" @back-step-event="backStep" v-if="$page.props.step == 2"
                    :contactCompany="contactGeneral.company" />
                <ContactPerson :contactGeneralId="contactGeneral.id" :errors="errors" @back-step-event="backStep" v-if="$page.props.step == 2.5"
                    :contactPerson="contactGeneral.person" />
                <ContactDetail :contactGeneralId="contactGeneral.id" :errors="errors" @back-step-event="backStep" v-if="$page.props.step == 3"
                    :contactDetail="contactGeneral.detail" />
                <div v-if="$props.props.step == 4">
                    End
                </div>
            </div>

        </ContactLayout>
    </div>
</template>

<script>
import ContactLayout from "@/Layouts/ContactLayout.vue";
import ContactGeneral from "@/Pages/Contact/General/Form.vue";
import ContactCompany from "@/Pages/Contact/Company/Form.vue";
import ContactPerson from "@/Pages/Contact/Person/Form.vue";
import ContactDetail from "@/Pages/Contact/Detail/Form.vue";

export default {
    components: {
        ContactGeneral,
        ContactLayout,
        ContactCompany,
        ContactPerson,
        ContactDetail
    },
    props: {
        errors: Object,
        contactGeneral: Object
    },
    methods: {
        backStep(value) {
            this.$page.props.step = value;
        }
    }
}
</script>
