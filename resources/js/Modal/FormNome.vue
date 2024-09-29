<script setup>
import { defineProps, defineEmits, ref, h } from "vue";

const props = defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(["modal-close"]);

const target = ref(null);

const nome = ref("");

</script>

<template>
  <div v-if="isOpen" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container" ref="target">
        <div class="pb-4">
            <h3 class="text-lg">Por favor informe seu nome e sobrenome</h3>
        </div>
        <div class="flex flex-col items-center justify-center mb-6">
            <input type="text" placeholder="Nome *" v-model="nome" class="w-full" />
        </div>
        <div class="flex justify-between flex-row">
            <button class="bg-green-800 py-2 px-4 text-white rounded-md w-full" @click.stop="emit('submit', nome)">Confirmar</button>
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
