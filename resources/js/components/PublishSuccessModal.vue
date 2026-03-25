<template>
  <div
    v-if="open"
    class="fixed inset-0 z-[60] flex items-center justify-center bg-slate-900/40 px-4 backdrop-blur-sm"
    @click.self="$emit('close')"
  >
    <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
      <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-7 w-7"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M5 13l4 4L19 7"
          />
        </svg>
      </div>

      <div class="mt-4 text-center">
        <h2 class="text-2xl font-bold text-slate-900">
          {{ title }}
        </h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">
          {{ description }}
        </p>
      </div>

      <div
        class="mt-6 grid gap-3"
        :class="showPublicButton ? 'grid-cols-1 sm:grid-cols-2' : 'grid-cols-1'"
      >
        <a
          v-if="showPublicButton"
          :href="publicUrl"
          target="_blank"
          class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
        >
          Ver perfil público
        </a>

        <button
          type="button"
          class="rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
          @click="$emit('close')"
        >
          {{ closeText }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  open: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: 'Operación completada',
  },
  description: {
    type: String,
    default: '',
  },
  publicUrl: {
    type: String,
    default: '#',
  },
  showPublicButton: {
    type: Boolean,
    default: false,
  },
  closeText: {
    type: String,
    default: 'Continuar editando',
  },
})

defineEmits(['close'])
</script>