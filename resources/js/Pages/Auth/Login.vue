<template>
    <Head title="Login" />
    <div class="flex items-center justify-center p-6 min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-md">
            <Logo class="block m-auto" height="150" />
            <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
                <div class="px-10 py-12">
                    <h1 class="text-center text-3xl font-bold">Welcome!</h1>
                    <div class="mt-6 mx-auto w-24 border-b-2" />
                    <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
                    <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
                    <label class="flex items-center mt-6 select-none" for="remember">
                        <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
                        <span class="text-sm">Remember Me</span>
                    </label>
                </div>
                <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
                    <loading-button :loading="form.processing" class="btn-cyan ml-auto" type="submit">Login</loading-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
    components: {
        Head,
        LoadingButton,
        Logo,
        TextInput,
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '' ,
                remember: false,
            }),
        }
    },
    methods: {
        login() {
            this.form.post('/login')
        },
    },
}
</script>
