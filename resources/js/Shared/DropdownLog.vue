<template>
    <div class="relative">
        <button @click="isOpen = !isOpen" class="flex z-10 block focus:outline-none">
            <slot></slot>
        </button>
        <button v-if="isOpen" @click="isOpen = false" tabindex="-1" class="fixed inset-0 w-full h-full bg-black opacity-20  cursor-default"></button>
        <div v-if="isOpen" class="mt-2 px-4 py-6 w-screen bg-white rounded shadow-xl">
            <slot name="dropdown" />
        </div>
    </div>
</template>

<script>
import { defineComponent, onUnmounted, computed } from 'vue'
import { usePage, Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    name: 'Dropdown',

    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        return { user }
    },
    components: {
        Link,
    },
    data(){
        return {
            isOpen: false
        }
    },
    props: {
        auth: Object,
    },
    mounted() {
        const onEscape = (e) => {
            if (!this.isOpen || e.key !== 'Escape') {
                return
            }
            this.isOpen = false
        }
        document.addEventListener('keydown', onEscape)
        onUnmounted(() => document.removeEventListener('keydown', onEscape))
    },
})
</script>
