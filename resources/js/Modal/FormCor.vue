<script setup>
import { defineProps, defineEmits, ref, h } from "vue";

const props = defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(["modal-close"]);

const target = ref(null);

const cor = ref({
  hex: '',
});

</script>

<template>
  <div v-if="isOpen" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container" ref="target">
        <div class="pb-4">
            <h3 class="text-xl">Cadastrar Cor</h3>
        </div>
        <div class="flex flex-col items-center justify-center mb-6">
            <input type="color" placeholder="Cor *" v-model="cor.hex" class="color-picker" />
        </div>
        <div class="flex justify-between flex-row">
            <button class="bg-red-800 py-2 px-4 text-white rounded-md" @click.stop="emit('modal-close')">Cancelar</button>
            <button class="bg-green-800 py-2 px-4 text-white rounded-md" @click.stop="emit('submit', cor)">Salvar</button>
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

.color-picker {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: 100px;
  height: 100px;
  background-color: transparent;
  border: none;
  cursor: pointer;
}
.color-picker::-webkit-color-swatch {
  border-radius: 10px;
  border: none;
}
.color-picker::-moz-color-swatch {
  border-radius: 10px;
  border: none;
}

</style>
