<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, defineProps, ref, watch } from 'vue';


const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    resources: Array,
    categories: Array,
    voterId: String
});

let search = ref('');
let filterResources = ref([]);
let filteredCategory = ref(null);

const fetchData = async () => {
    try {
        const response = await axios.get('api/resources', {
            params: {
                search: search.value,
                category: filteredCategory.value
            }
        });
        filterResources.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

watch([search, filteredCategory], () => {
    fetchData();
});

onMounted(() => {
    fetchData();
});

function vote(resourceId) {
    axios.get(`api/vote/${resourceId}`).then(response => {
         filterResources.value = filterResources .value.map(resource => {
            if (resource.id === resourceId) {
                resource.votes = response.data.votes;
            }
            return resource;
        })});
}

function youHaveVoted (resource) {
    return resource.votes.find(vote => vote.code === props.voterId);
    
}

</script>

<template>
    <Head title="Recursos interesantes" />

    <div
        class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Dashboard</Link>

            <template v-else>
                <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Register</Link>
            </template>
        </div>
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <img src="/images/logosquare.png" alt="Logo de square1" class="h-16 w-auto bg-gray-100 dark:bg-gray-900" />
            </div>
            <div class="relative overflow-x-auto">
                <div>
                    <input type="text" class="w-full p-4 bg-gray-100 rounded-lg dark:bg-gray-800"
                        placeholder="Buscar Recurso" v-model="search" />
                    <select type="text" class="w-full p-4 bg-gray-100 rounded-lg dark:bg-gray-800"
                        aria-label="Default select example" v-model="filteredCategory">
                        <option value="">Todas las categorías</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                        </option>
                    </select>
                </div>
                <table class="w-full text-sm text-left text-gray-500 ">
                    <thead class="text-lg text-gray-700 uppercase bg-gray-500">
                        <tr>
                            <th scope="col" class="p-4">
                                Votos
                            </th>
                            <th scope="col" class="p-4">
                                Recurso
                            </th>
                            <th scope="col">
                                Link
                            </th>
                            <th scope="col">
                                Categoria
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="resource in filterResources" :key="resource.id">
                            <th scope="row" class="p-4" text="left">
                                <div class="flex">
                                <span>{{resource.votes.length}}</span>
                                <button @click="vote(resource.id)">
                                <svg v-if="youHaveVoted(resource)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" data-slot="icon" class="w-6 h-6 text-emerald-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 
                        9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" data-slot="icon" class="w-6 h-6 text-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>
                                </button>
                            </div>

                            </th>
                            <th scope="row" class="p-4" text="left">{{ resource.title }}</th>
                            <th scope="row" class="p-4">
                                <a target="_blank" :href="resource.link">Ver Recurso</a>
                            </th>
                            <th scope="row" class="p-4">{{ resource.category.name }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
