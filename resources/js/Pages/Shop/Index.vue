<template>
    <WebLayout>
        <div class="card">
            <div class="card-body">
                <h3>Shopping</h3>
                <Cart />
            </div>
        </div>
    </WebLayout>
</template>

<script>
import WebLayout from "@/Layouts/WebLayout.vue";
import Cart from "@/Fragment/Cart.vue";

export default {
    components: {
        WebLayout,
        Cart,
    },
};
</script>
