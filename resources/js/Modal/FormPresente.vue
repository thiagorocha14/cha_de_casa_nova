<script setup>
import { defineProps, defineEmits, ref, h } from "vue";

const props = defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(["modal-close"]);

const target = ref(null);

const presente = ref({
  nome: '',
  descricao: '',
  links: [{id: 0, value: ''}],
  especial: false,
});

const addLink = () => {
    presente.value.links.push({id: presente.value.links.length, value: ''});
};

</script>

<template>
  <div v-if="isOpen" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container" ref="target">
        <div class="pb-4">
            <h3 class="text-xl">Cadastrar Presente</h3>
        </div>
        <div class="flex flex-col gap-2 pb-6">
            <div class="flex flex-col">
                <label for="nome">Nome</label>
                <input type="text" placeholder="Nome *" v-model="presente.nome" />
            </div>
            <div class="flex flex-col">
                <label for="descricao">Descrição</label>
                <input type="text" placeholder="Descrição" v-model="presente.descricao" />
            </div>
            <div class="flex flex-col gap-1">
                <div class="flex flex-row justify-between">
                    <label for="links">Links de Sugestão</label>
                    <button class="bg-gray-200 px-2 rounded-full" @click="addLink">+</button>
                </div>
                <div v-for="link, index in presente.links" :key="link.id">
                    <input type="text" class="w-full" placeholder="Link" v-model="presente.links[index].value" />
                </div>
            </div>
            <div class="flex flex-row gap-2 items-center">
                <input type="checkbox" id="especial" v-model="presente.especial" />
                <label for="especial">Especial</label>
            </div>
        </div>
        <div class="flex justify-between flex-row">
            <button class="bg-red-800 py-2 px-4 text-white rounded-md" @click.stop="emit('modal-close')">Cancelar</button>
            <button class="bg-green-800 py-2 px-4 text-white rounded-md" @click.stop="emit('submit', presente)">Salvar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}
.modal-container {
  width: 300px;
  margin: 150px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 15px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
}

</style>
