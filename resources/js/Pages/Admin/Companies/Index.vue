<template>
    <layout title="Companies">

        <div>
            <h1 class="mb-8 font-bold text-3xl">Companies</h1>
            <div class="mb-6 flex justify-between items-center">
                <search v-model="form.search" v-model:trashed="form.trashed" @reset="reset"
                        class="flex items-center w-full max-w-md mr-4"/>
                <Link :href="route('companies.create')">
                    Create Company
                </Link>
            </div>
            <div class="bg-white rounded-md shadow overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tr class="text-left font-bold">
                        <th class="px-6 pt-6 pb-4">Name</th>
                        <th class="px-6 pt-6 pb-4">City</th>
                        <th class="px-6 pt-6 pb-4">E-mail</th>
                        <th colspan="2" class="px-6 pt-6 pb-4">Phone</th>
                    </tr>
                    <tr v-for="company of companies.data" :key="company.id"
                        class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link value="Edit" :href="route('companies.edit', company)"
                                  class="px-6 py-4 flex items-center focus:text-indigo-500">{{ company.name }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link value="Edit" :href="route('companies.edit', company)"
                                  class="px-6 py-4 flex items-center focus:text-indigo-500">{{ company.city }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link value="Edit" :href="route('companies.edit', company)"
                                  class="px-6 py-4 flex items-center focus:text-indigo-500">{{ company.email }}
                            </Link>
                        </td>
                        <td class="border-t">
                            <Link value="Edit" :href="route('companies.edit', company)"
                                  class="px-6 py-4 flex items-center focus:text-indigo-500">{{ company.phone }}
                            </Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4" :href="route('companies.edit', company)" tabindex="-1">
                                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400"/>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="companies.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">No companies found.</td>
                    </tr>
                </table>
            </div>
            <div class="mt-6">
                <div class="flex flex-wrap -mb-1">
                    <Pagination :links="companies.links"></Pagination>
                </div>
            </div>
        </div>


    </layout>
</template>

<script>
import {defineComponent} from 'vue'
import {debounce, mapValues} from "lodash"
import {Link} from "@inertiajs/inertia-vue3";
import Layout from "@/Pages/Layout";
import Icon from "@/Shared/Icon.vue"
import Pagination from '@/Shared/Pagination.vue'
import Search from "@/Shared/Search";

export default defineComponent({
    name: 'Admin/Companies/Index',
    components: {
        Layout,
        Link,
        Pagination,
        Icon,
        Search
    },
    props: {
        companies: Object,
        filters: Object
    },
    data() {
        return {
            isOpen: false,
            form: {
                search: this.filters.search,
                trashed: this.filters.trashed,
            },
        }
    },
    watch: {
        form: {
            deep: true,
            handler: debounce(function () {
                this.$inertia.get(this.route('companies.index'), this.form, {preserveState: true, replace: true})
            }, 150),
        },
    },
    methods: {
        destroy(user) {
            this.$inertia.delete(this.route('companies.destroy', user))
        },
        reset() {
            this.form = mapValues(this.form, () => null)
        },
    },

})
</script>
