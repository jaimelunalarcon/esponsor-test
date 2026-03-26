<template>
  <div class="space-y-5">
    <div class="flex flex-wrap gap-2">
      <button
        class="w-full rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
        @click="addBlock('text')"
      >
        + Texto
      </button>

      <button
        class="w-full rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 ring-1 ring-slate-300 transition hover:bg-slate-50"
        @click="addBlock('image')"
      >
        + Imagen
      </button>

      <button
        class="w-full rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 ring-1 ring-slate-300 transition hover:bg-slate-50"
        @click="addBlock('links')"
      >
        + Links
      </button>

      <button
        class="w-full rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 ring-1 ring-slate-300 transition hover:bg-slate-50"
        @click="addBlock('video')"
      >
        + Video
      </button>

      <button
        class="w-full rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-800 ring-1 ring-slate-300 transition hover:bg-slate-50"
        @click="addBlock('social')"
      >
        + Redes sociales
      </button>
    </div>

    <div
      v-if="localBlocks.length === 0"
      class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center"
    >
      <p class="text-sm font-medium text-slate-600">Aún no hay bloques</p>
      <p class="mt-1 text-sm text-slate-400">
        Agrega bloques para comenzar a construir tu página pública.
      </p>
    </div>

    <div
      v-for="(block, index) in localBlocks"
      :key="block.id"
      class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm"
    >
      <div
        class="border-b border-slate-200 bg-slate-50/80 p-4"
        :class="{ 'cursor-pointer md:cursor-default': !isDesktop }"
        @click="handleHeaderClick(block)"
      >
        <div class="flex items-center justify-between gap-4">
          <div class="flex min-w-0 items-center gap-3">
            <div
              class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl text-sm font-bold uppercase"
              :class="badgeClass(block.type)"
            >
              {{ block.type.slice(0, 1) }}
            </div>

            <div class="min-w-0">
              <h3 class="truncate text-base font-bold text-slate-900">
                {{ blockTitle(block) }}
              </h3>
              <p class="text-xs text-slate-500">
                Posición {{ block.position }}
              </p>
            </div>
          </div>

          <button
            type="button"
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-200 md:hidden"
            @click.stop="toggleBlock(block)"
          >
            <svg
              class="h-5 w-5 transition-transform duration-200"
              :class="block.isOpen ? 'rotate-180' : 'rotate-0'"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"
            >
              <path
                fill-rule="evenodd"
                d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>

        <div
          v-if="block.isOpen || isDesktop"
          class="mt-4 flex flex-wrap gap-2"
          @click.stop
        >
          <button
            class="rounded-xl bg-white px-3 py-2 text-sm font-medium text-slate-700 ring-1 ring-slate-300 transition hover:bg-slate-100"
            @click="moveUp(index)"
          >
            ↑ Subir
          </button>

          <button
            class="rounded-xl bg-white px-3 py-2 text-sm font-medium text-slate-700 ring-1 ring-slate-300 transition hover:bg-slate-100"
            @click="moveDown(index)"
          >
            ↓ Bajar
          </button>

          <button
            class="rounded-xl bg-white px-3 py-2 text-sm font-medium text-slate-700 ring-1 ring-slate-300 transition hover:bg-slate-100"
            @click="duplicateBlock(index)"
          >
            Duplicar
          </button>

          <button
            class="rounded-xl bg-red-50 px-3 py-2 text-sm font-medium text-red-700 ring-1 ring-red-200 transition hover:bg-red-100"
            @click="removeBlock(index)"
          >
            Eliminar
          </button>
        </div>
      </div>

      <div v-show="block.isOpen || isDesktop" class="space-y-5 p-5">
        <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
          <div>
            <p class="text-sm font-semibold text-slate-800">Estado del bloque</p>
            <p class="text-xs text-slate-500">
              Puedes ocultarlo sin eliminarlo del draft.
            </p>
          </div>

          <label class="inline-flex cursor-pointer items-center gap-3">
            <span class="text-sm font-medium text-slate-600">
              {{ block.enabled ? 'Activo' : 'Oculto' }}
            </span>
            <input
              v-model="block.enabled"
              type="checkbox"
              class="h-5 w-5 rounded border-slate-300 text-slate-900 focus:ring-slate-400"
            />
          </label>
        </div>

        <template v-for="field in getSchema(block).fields" :key="field.key">
          <div v-if="field.type === 'text' || field.type === 'url'" class="space-y-2">
            <label class="text-sm font-medium text-slate-700">
              {{ field.label }}
            </label>

            <input
              v-model="block.props[field.key]"
              :type="field.type"
              :placeholder="field.placeholder || ''"
              class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
            />
          </div>

          <div v-else-if="field.type === 'textarea'" class="space-y-2">
            <label class="text-sm font-medium text-slate-700">
              {{ field.label }}
            </label>

            <textarea
              v-model="block.props[field.key]"
              rows="4"
              :placeholder="field.placeholder || ''"
              class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
            />
          </div>

          <div v-else-if="field.type === 'color'" class="space-y-2">
            <label class="text-sm font-medium text-slate-700">
              {{ field.label }}
            </label>

            <input
              v-model="block.props[field.key]"
              type="color"
              class="h-11 w-20 rounded-2xl border border-slate-300 bg-white px-2 py-2"
            />
          </div>

          <div v-else-if="field.type === 'select'" class="space-y-2">
            <label class="text-sm font-medium text-slate-700">
              {{ field.label }}
            </label>

            <select
              v-model="block.props[field.key]"
              class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
            >
              <option
                v-for="option in field.options || []"
                :key="option.value"
                :value="option.value"
              >
                {{ option.label }}
              </option>
            </select>
          </div>

          <div v-else-if="field.type === 'links'" class="space-y-4">
            <div
              v-for="(link, linkIndex) in block.props.links"
              :key="linkIndex"
              class="rounded-2xl border border-slate-200 bg-slate-50 p-4"
            >
              <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-800">
                  Link {{ linkIndex + 1 }}
                </p>

                <button
                  v-if="block.props.links.length > 1"
                  class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-medium text-red-700 ring-1 ring-red-200 transition hover:bg-red-100"
                  @click="removeLink(block, linkIndex)"
                >
                  Quitar
                </button>
              </div>

              <div class="grid gap-3 md:grid-cols-2">
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-700">Texto del botón</label>
                  <input
                    v-model="link.label"
                    placeholder="Ej: Mi portafolio"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                  />
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-700">URL</label>
                  <input
                    v-model="link.url"
                    placeholder="https://..."
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                  />
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-700">Color fondo</label>
                  <input
                    v-model="link.backgroundColor"
                    type="color"
                    class="h-11 w-20 rounded-2xl border border-slate-300 bg-white px-2 py-2"
                  />
                </div>
              </div>
            </div>

            <button
              class="rounded-2xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-800 transition hover:bg-slate-200"
              @click="addLink(block)"
            >
              + Agregar link
            </button>
          </div>
        </template>

        <div
          v-if="block.type === 'image' && block.props.image_url"
          class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
        >
          <img
            :src="block.props.image_url"
            :alt="block.props.alt || 'Preview imagen'"
            class="max-h-64 w-full object-cover"
          />
        </div>

        <div
          v-if="block.type === 'video'"
          class="rounded-2xl border border-slate-200 bg-slate-50 p-4"
        >
          <p class="text-sm font-semibold text-slate-800">Estado del video</p>

          <p v-if="getEmbedUrl(block.props.embed_url)" class="mt-1 text-sm text-emerald-600">
            Video detectado correctamente. Revisa el preview para verlo embebido.
          </p>

          <p v-else class="mt-1 text-sm text-slate-500">
            Aún no hay una URL válida para mostrar.
          </p>

          <a
            v-if="block.props.embed_url"
            :href="block.props.embed_url"
            target="_blank"
            class="mt-3 inline-block text-sm font-medium text-slate-700 underline underline-offset-4"
          >
            Abrir enlace en nueva pestaña
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { nextTick, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import { blockSchemas } from '../schemas/blockSchemas'

const props = defineProps({
  blocks: {
    type: Array,
    required: true,
  },
})

const emit = defineEmits(['update:blocks'])

const isDesktop = ref(false)
const syncingFromParent = ref(false)
const localBlocks = ref([])

const cloneBlocks = (value) => JSON.parse(JSON.stringify(value ?? []))

const handleHeaderClick = (block) => {
  if (isDesktop.value) return
  toggleBlock(block)
}

const updateViewport = () => {
  isDesktop.value = window.innerWidth >= 768
}

const normalizePositions = (blocks, previousBlocks = []) => {
  const openStateMap = new Map(
    previousBlocks.map((block) => [block.id, block.isOpen])
  )

  blocks.forEach((block, index) => {
    block.position = index + 1

    if (typeof block.enabled === 'undefined') {
      block.enabled = true
    }

    if (openStateMap.has(block.id)) {
      block.isOpen = openStateMap.get(block.id)
    } else if (typeof block.isOpen === 'undefined') {
      block.isOpen = isDesktop.value
    }

    if (!block.props) {
      block.props = {}
    }
  })

  return blocks
}

watch(
  () => props.blocks,
  (value) => {
    syncingFromParent.value = true
    localBlocks.value = normalizePositions(
      cloneBlocks(value),
      localBlocks.value
    )

    nextTick(() => {
      syncingFromParent.value = false
    })
  },
  { immediate: true }
)

watch(
  localBlocks,
  (value) => {
    if (syncingFromParent.value) return

    const blocksToEmit = cloneBlocks(value).map(({ isOpen, ...block }) => block)
    emit('update:blocks', blocksToEmit)
  },
  { deep: true }
)

onMounted(() => {
  updateViewport()
  window.addEventListener('resize', updateViewport)
})

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateViewport)
})

const createId = () => `blk_${Date.now()}_${Math.random().toString(36).slice(2, 8)}`

const getSchema = (block) => blockSchemas[block.type] || { fields: [] }

const buildDefaultProps = (type) => {
  const schema = blockSchemas[type]

  if (!schema?.fields) return {}

  return schema.fields.reduce((acc, field) => {
    acc[field.key] = structuredClone(field.default ?? '')
    return acc
  }, {})
}

const badgeClass = (type) => {
  if (type === 'text') return 'bg-blue-100 text-blue-700'
  if (type === 'image') return 'bg-fuchsia-100 text-fuchsia-700'
  if (type === 'links') return 'bg-emerald-100 text-emerald-700'
  if (type === 'video') return 'bg-amber-100 text-amber-700'
  return 'bg-slate-100 text-slate-700'
}

const blockTitle = (block) => {
  if (block.type === 'text') return block.props.title || 'Bloque de texto'
  if (block.type === 'image') return block.props.alt || 'Bloque de imagen'
  if (block.type === 'links') return `Bloque de links (${block.props.links?.length || 0})`
  if (block.type === 'video') return block.props.embed_url ? 'Bloque de video' : 'Video pendiente'
  return 'Bloque'
}

const syncBlocks = () => {
  localBlocks.value = normalizePositions(cloneBlocks(localBlocks.value))
}

const toggleBlock = (block) => {
  block.isOpen = !block.isOpen
}

const addBlock = (type) => {
  const base = {
    id: createId(),
    type,
    position: localBlocks.value.length + 1,
    enabled: true,
    isOpen: true,
    props: buildDefaultProps(type),
  }

  localBlocks.value.push(base)
  syncBlocks()
}

const removeBlock = (index) => {
  localBlocks.value.splice(index, 1)
  syncBlocks()
}

const duplicateBlock = (index) => {
  const clone = cloneBlocks(localBlocks.value[index])
  clone.id = createId()
  clone.isOpen = true
  localBlocks.value.splice(index + 1, 0, clone)
  syncBlocks()
}

const moveUp = (index) => {
  if (index === 0) return
  const blocks = localBlocks.value
  ;[blocks[index - 1], blocks[index]] = [blocks[index], blocks[index - 1]]
  syncBlocks()
}

const moveDown = (index) => {
  const blocks = localBlocks.value
  if (index >= blocks.length - 1) return
  ;[blocks[index], blocks[index + 1]] = [blocks[index + 1], blocks[index]]
  syncBlocks()
}

const addLink = (block) => {
  if (!Array.isArray(block.props.links)) {
    block.props.links = []
  }

  block.props.links.push({ label: '', url: '' })
}

const removeLink = (block, index) => {
  if (!Array.isArray(block.props.links) || block.props.links.length === 1) return
  block.props.links.splice(index, 1)
}

const getEmbedUrl = (url) => {
  if (!url) return ''

  if (url.includes('youtube.com/embed/')) {
    return url
  }

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
</script>