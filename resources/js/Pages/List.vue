

<script setup>
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
    import { Head } from '@inertiajs/vue3';
    import  FormNome  from '@/Modal/FormNome.vue';
    import { fas } from '@fortawesome/free-solid-svg-icons';
    import { onMounted, ref } from 'vue';
    import { initPopovers, initTooltips } from 'flowbite';

    defineProps({
        presentes_normais: Array,
        presentes_especiais: Array,
        cores: Array,
    });
    onMounted(() => {
        initPopovers();
        initTooltips();
        openModalNome();
    });

    const isModalNomeOpened = ref(false);

    const openModalNome = () => {
        if (!localStorage.getItem('nome')) {
            isModalNomeOpened.value = true;
        }
    };

    const submitHandlerNome = (nome)=>{
        localStorage.setItem('nome', nome);
        isModalNomeOpened.value = false;
    }

    const toggleComprado = (presente) => {
        const id = presente.id;

        if (!localStorage.getItem('nome')) {
            isModalNomeOpened.value = true;
        } else {

            if (presente.comprado) {
                axios.post('/presente/nao-comprado', { id }).then(() => {
                    location.reload();
                });
                return;
            }

            axios.post('/presente/comprado', { id, nome_comprador: localStorage.getItem('nome') }).then(() => {
                location.reload();
            });
        }
    }

    const checkName = (presente) => {
        return presente.comprado && presente.nome_comprador !== localStorage.getItem('nome');
    }

    const returnDisabledWithName = (presente) => {
        return presente.comprado && presente.nome_comprador !== localStorage.getItem('nome') ? 'opacity-50 cursor-not-allowed' : '';
    }

</script>

<template>

    <Head title="List" />
    <div class="h-screen bg-gradient-to-r from-purple-400 to-blue-400 bg-cover bg-center">
        <div class="h-screen bg-white w-screen bg-opacity-50 px-4 py-2 md:px-16 md:py-10">
            <div class="flex flex-col h-full w-full rounded-2xl border border-black overflow-y-auto md:overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between border-b border-black pt-3 px-3">
                    <div class="flex flex-col items-center md:items-start gap-2 md:gap-0">
                        <h1 class="text-4xl text-black text-center">lista de presentes</h1>
                        <small class="text-black text-justify md:text-start">
                            saiba antes de tudo que já estamos muito felizes com a sua presença e por isso, não se sinta obrigado a nos presentear.
                            caso queiram, escolhemos algumas opções que nos ajudarão a realizar nossos sonhos.
                        </small>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-black text-center">
                            <b>nossa paleta de cores</b>
                        </span>
                        <div class="flex justify-center">
                            <div v-for="color in cores" :key="color.id" :style="{ backgroundColor: color.hex }" class="w-10 h-10 rounded-full m-1"></div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-[repeat(auto-fit,minmax(350px,1fr))] h-full">
                    <div class="md:col-span-3">
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(350px,1fr))] auto-rows-[150px 200px]">
                            <div class="w-full px-4 py-2 h-12" v-for="presente in presentes_normais" :key="presente.id" :data-tooltip-target=" presente.descricao ? 'tooltip-default'+presente.id : ''">
                                <div class="flex flex-row justify-between h-full bg-white rounded-xl py-1 px-2 items-center">
                                    <div class="flex flex-row items-center">
                                        <input type="checkbox" class="checkName border p-3 rounded-full" :class="returnDisabledWithName(presente)" :disabled="checkName(presente)" :checked="presente.comprado" @change="toggleComprado(presente)"/>
                                        <div class="flex flex-col pl-2 pr-2">
                                            <h2 class="text-md font-bold">{{ presente.nome }}</h2>
                                        </div>
                                    </div>
                                    <div :id="'tooltip-default'+presente.id" v-if="presente.descricao" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{ presente.descricao }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <div class="flex flex-row items-center gap-2">
                                        <button v-if="presente.links.length > 0" :data-popover-target="'popover-right-'+presente.id" data-popover-trigger="click" data-popover-placement="right" class="px-1 py-0 rounded-full h-7 w-7 border border-gray-500">
                                            <!-- lightbulb -->
                                            <FontAwesomeIcon :icon="fas.faLink" class="text-sm"/>
                                        </button>
                                        <div data-popover :id="'popover-right-'+presente.id" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                            <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">Sugestões de presentes</h3>
                                            </div>
                                            <div class="px-3 py-2 flex flex-col gap-1">
                                                <a v-for="link in presente.links" :key="link.id" :href="link.link" class="text-blue-500 hover:underline">{{ link.link.length > 30 ? link.link.slice(0,30) + '...' : link.link }}</a>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] auto-rows-[150px 200px]">
                            <h3 class="font-semibold text-center">presentes que gostaríamos de ganhar mais não gostaríamos de pedir</h3>
                            <div class="w-full px-4 py-2 h-12" v-for="presente in presentes_especiais" :key="presente.id" :data-tooltip-target=" presente.descricao ? 'tooltip-default'+presente.id : ''">
                                <div class="flex flex-row justify-between h-full bg-white rounded-xl py-1 px-2 items-center">
                                    <div class="flex flex-row items-center">
                                        <input type="checkbox" class="checkName border p-3 rounded-full" :class="returnDisabledWithName(presente)" :disabled="checkName(presente)" :checked="presente.comprado" @change="toggleComprado(presente)"/>
                                        <div class="flex flex-col pl-2 pr-2">
                                            <h2 class="text-md font-bold">{{ presente.nome }}</h2>
                                        </div>
                                    </div>
                                    <div :id="'tooltip-default'+presente.id" v-if="presente.descricao" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                        {{ presente.descricao }}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    <div class="flex flex-row items-center gap-2">
                                        <button v-if="presente.links.length > 0" :data-popover-target="'popover-right-'+presente.id" data-popover-trigger="click" data-popover-placement="right" class="px-1 py-0 rounded-full h-7 w-7 border border-gray-500">
                                            <!-- lightbulb -->
                                            <FontAwesomeIcon :icon="fas.faLink" class="text-sm"/>
                                        </button>
                                        <div data-popover :id="'popover-right-'+presente.id" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                            <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                                <h3 class="font-semibold text-gray-900 dark:text-white">Sugestões de presentes</h3>
                                            </div>
                                            <div class="px-3 py-2 flex flex-col gap-1">
                                                <a v-for="link in presente.links" :key="link.id" :href="link.link" class="text-blue-500 hover:underline">{{ link.link.length > 30 ? link.link.slice(0,30) + '...' : link.link }}</a>
                                            </div>
                                            <div data-popper-arrow></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <FormNome :isOpen="isModalNomeOpened" @submit="submitHandlerNome" name="first-modal" />
</template>

<style scoped></style>
