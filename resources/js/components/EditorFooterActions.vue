<template>
  <div
  class="fixed bottom-0 left-0 right-0 z-50 border-t border-slate-200 bg-white/80 backdrop-blur-md transition-all duration-300"
  :class="isVisible ? 'translate-y-0 opacity-100' : 'pointer-events-none translate-y-4 opacity-0'"
>
    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-3 px-4 py-3 sm:flex sm:items-center sm:justify-end sm:px-6">
      <button
        class="w-full rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 disabled:opacity-60 sm:w-auto"
        :disabled="loading"
        @click="$emit('save')"
      >
        Guardar draft
      </button>

      <button
        class="w-full rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700 disabled:opacity-60 sm:w-auto"
        :disabled="loading"
        @click="$emit('publish')"
      >
        Publicar
      </button>
    </div>
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'

defineProps({
  loading: {
    type: Boolean,
    default: false,
  },
})

defineEmits(['save', 'publish'])

const isScrolled = ref(false)
const hasScrollableContent = ref(false)

const updateVisibilityState = () => {
  hasScrollableContent.value =
    document.documentElement.scrollHeight > window.innerHeight + 20

  isScrolled.value = window.scrollY > 8
}

const isVisible = computed(() => {
  // Si no hay scroll disponible, mostrar siempre
  if (!hasScrollableContent.value) return true

  // Si hay scroll, mostrar solo cuando el usuario ya se movió
  return isScrolled.value
})

onMounted(() => {
  updateVisibilityState()
  window.addEventListener('scroll', updateVisibilityState, { passive: true })
  window.addEventListener('resize', updateVisibilityState)
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', updateVisibilityState)
  window.removeEventListener('resize', updateVisibilityState)
})
</script>