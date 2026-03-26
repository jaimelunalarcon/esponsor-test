<template>
  <div class="space-y-4 px-6">
    <TransitionGroup
      name="fade-up"
      tag="div"
      class="space-y-4"
    >
      <div
        v-for="(block, index) in contentBlocks"
        :key="block.id"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        :style="{ transitionDelay: `${index * 60}ms` }"
      >
        <template v-if="block.type === 'text'">
          <div
            class="p-4"
            :style="{
              backgroundColor: block.props?.backgroundColor || '#ffffff',
              color: getContrastColor(block.props?.backgroundColor || '#ffffff')
            }"
          >
            <h3
              class="text-lg font-bold"
              :style="{ color: getContrastColor(block.props?.backgroundColor || '#ffffff') }"
            >
              {{ block.props?.title || 'Título de bloque' }}
            </h3>

            <p
              class="mt-2 whitespace-pre-line text-sm"
              :style="{ color: getContrastColor(block.props?.backgroundColor || '#ffffff') }"
            >
              {{ block.props?.content || 'Contenido...' }}
            </p>
          </div>
        </template>

        <template v-else-if="block.type === 'image'">
          <img
            v-if="block.props?.image_url"
            :src="block.props.image_url"
            :alt="block.props?.alt || 'Imagen'"
            class="w-full rounded-xl object-cover"
            loading="lazy"
          />
          <div v-else class="p-4 text-sm text-slate-400">
            Imagen pendiente
          </div>
        </template>

        <template v-else-if="block.type === 'links'">
          <div class="space-y-2 p-4">
            <a
              v-for="(link, linkIndex) in (block.props?.links || [])"
              :key="linkIndex"
              :href="link.url || '#'"
              target="_blank"
              rel="noopener noreferrer"
              class="block rounded-lg px-4 py-3 text-center transition"
              :style="{
                backgroundColor: link.backgroundColor || '#0f172a',
                color: getContrastColor(link.backgroundColor || '#0f172a')
              }"
            >
              {{ link.label || 'Nuevo link' }}
            </a>
          </div>
        </template>

        <template v-else-if="block.type === 'video'">
          <div v-if="getEmbedUrl(block.props?.embed_url)" class="aspect-video bg-black">
            <iframe
              class="h-full w-full"
              :src="getEmbedUrl(block.props?.embed_url)"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
            />
          </div>
          <div v-else class="p-8 text-center text-sm text-slate-400">
            Video pendiente
          </div>
        </template>

        <div v-else class="p-4 text-sm text-slate-400">
          Bloque desconocido
        </div>
      </div>
    </TransitionGroup>

    <div v-if="contentBlocks.length" class="mt-4 flex justify-center">
      <a
        href="#"
        target="_blank"
        class="flex items-center gap-2 opacity-60 transition hover:opacity-100"
      >
        <span class="text-[11px] text-slate-400">
          Powered by
        </span>

        <img
          :src="logo"
          alt="Esponsor"
          class="h-3.5"
        />
      </a>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import logo from '../../images/esponsor-logo.svg'

const props = defineProps({
  blocks: {
    type: Array,
    required: true,
  },
})

const getEmbedUrl = (url) => {
  if (!url) return ''

  if (url.includes('youtube.com/embed/')) return url

  if (url.includes('youtu.be/')) {
    const id = url.split('youtu.be/')[1]?.split('?')[0]
    return id ? `https://www.youtube.com/embed/${id}` : ''
  }

  if (url.includes('youtube.com/watch?v=')) {
    const id = url.split('v=')[1]?.split('&')[0]
    return id ? `https://www.youtube.com/embed/${id}` : ''
  }

  return ''
}

const getContrastColor = (bgColor) => {
  if (!bgColor || typeof bgColor !== 'string') return '#0f172a'

  const hex = bgColor.replace('#', '')
  if (hex.length !== 6) return '#0f172a'

  const r = parseInt(hex.substring(0, 2), 16)
  const g = parseInt(hex.substring(2, 4), 16)
  const b = parseInt(hex.substring(4, 6), 16)

  const brightness = (r * 299 + g * 587 + b * 114) / 1000
  return brightness > 150 ? '#0f172a' : '#ffffff'
}

const enabledBlocks = computed(() =>
  [...(props.blocks ?? [])]
    .filter((block) => block.enabled !== false)
    .sort((a, b) => (a.position ?? 0) - (b.position ?? 0))
)

const contentBlocks = computed(() =>
  enabledBlocks.value.filter((block) => block.type !== 'social')
)
</script>

<style scoped>
.fade-up-enter-active {
  transition: all 0.4s ease;
}

.fade-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.fade-up-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>