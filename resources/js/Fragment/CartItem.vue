<template>
    <TextInput v-model="count" type="number" />
    <PrimaryButton @click="submit">Add</PrimaryButton>
</template>
<script>
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
    components: {
        PrimaryButton,
        TextInput,
    },
    mounted() {
        let n = 0;
        Object.keys(this.$page.props.cart).forEach((key) => {
            n += this.$page.props.cart[key][1];
        });
    },
    data() {
        return {
            count: "1",
        };
    },
    props: {
        post: {
            required: true,
            type: Object,
        }
    },
    methods: {
        submit() {
            router.post(route('shop.add', {
                post: this.post.id,
                count: this.count
            }))

            this.$oruga.notification.open({
                message: 'Item added to cart',
                position: 'top-right',
                variant: 'success',
                diration: 2000,
                closable: true,
            });
        }
    }
};
</script>
