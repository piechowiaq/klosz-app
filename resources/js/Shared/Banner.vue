<template>

    <div class="bg-gray-100 dark:bg-gray-900 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center">
        <Link :href="route('dashboard')" class="mt-1">
            <div class="pt-8 sm:pt-0 flex flex-col max-w-md items-center justify-between" >
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24"><g fill="#4b5563" stroke="#0891b2" class="text-gray-600" stroke-width="1.5"><path d="M12 22c-1.02 0-1.38-.158-2.101-.473C7.239 20.365 3 17.63 3 11.991v-1.574c0-3.198 0-4.797.378-5.334C3.755 4.545 5.258 4.03 8.265 3l.573-.196C10.405 2.268 11.188 2 12 2"/><path d="M12 22c1.02 0 1.38-.158 2.101-.473c2.66-1.162 6.9-3.898 6.9-9.536v-1.574c0-3.198 0-4.797-.378-5.334c-.378-.538-1.881-1.053-4.888-2.082l-.573-.196C13.595 2.268 12.812 2 12 2" opacity=".5"/></g></svg>
                <p class="ml-2 text-sm font-bold whitespace-nowrap tracking-widest text-gray-600"><span class="text-cyan-600 " >TIMELY</span> RECORD</p>
            </div>
        </Link>
    </div>

</template>

<script>

import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
import Logo from '@/Shared/Logo'

export default defineComponent({
    name: 'Banner',

    components: {
        Link,
        Logo
    },
})

</script>
