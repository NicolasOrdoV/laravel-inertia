<template>
    <div class="mb-3" v-for="cart in $page.props.cart" :key="cart">
        <input :value="cart[1]" type="number" class="w-20"> {{ cart[0].title }}
    </div>
</template>
