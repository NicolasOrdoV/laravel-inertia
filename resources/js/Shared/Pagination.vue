<template>
    <template v-for="link in links.links" :key="link.url" v-bind:key="link">
        <!-- <Link class="px-2 py-1" v-if="!link.active" :href="link.url">{{ link.label }}</Link>
        <span class="px-2 py-1 cursor-pointer text-gray-500" v-else>{{ link.label }}</span> -->
        <Component :is="!active ? 'Link' : 'span'" :href="link.url == null ? '#' : link.url" class="mt-8 px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ml-5" :class="!link.active ? '':'cursor-pointer text-gray-500'" v-html="link.label"/>
    </template>
</template>
<script>
import { Link } from "@inertiajs/vue3";
export default {
    components: {
        Link,
    },
    props: {
        links: Array,
    },
}
</script>
