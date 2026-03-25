<template>
  <header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
      <div class="flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
          {{ initials }}
        </div>

        <div class="leading-tight">
          <p class="text-sm font-semibold text-slate-900">
            {{ name || 'Usuario' }}
          </p>
          <p class="text-xs text-slate-500">
            {{ email || 'usuario@email.com' }}
          </p>
        </div>
      </div>

      <form method="POST" action="/logout">
        <input type="hidden" name="_token" :value="csrfToken" />
        <button
          type="submit"
          class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
        >
          Cerrar sesión
        </button>
      </form>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  name: String,
  email: String,
})

const csrfToken =
  document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''

const initials = computed(() => {
  if (!props.name) return 'U'
  return props.name
    .split(' ')
    .filter(Boolean)
    .slice(0, 2)
    .map((p) => p[0].toUpperCase())
    .join('')
})
</script>