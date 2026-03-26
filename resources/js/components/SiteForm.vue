<template>
  <main class="min-h-screen overflow-x-hidden bg-slate-100 pb-28">
    <EditorHeader
      :name="user?.name || form.public_name"
      :email="user?.email || ''"
    />

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6">
      <div class="grid gap-8 xl:grid-cols-[1.2fr_0.8fr]">
        <section class="min-w-0 space-y-6">
          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
              <h2 class="text-xl font-bold text-slate-900">Información del perfil</h2>
              <p class="mt-1 text-sm text-slate-500">
                Configura nombre, slug, bio y avatar de tu página pública.
              </p>
            </div>

            <div class="grid gap-4">
              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-700">Nombre público</label>
                  <input
                    v-model="form.public_name"
                    placeholder="Ej: Jaime Luna"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                  />
                </div>

                <div class="space-y-2">
                  <label class="text-sm font-medium text-slate-700">Slug</label>
                  <input
                    v-model="form.slug"
                    placeholder="ej: jaime-luna"
                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                  />
                  <p class="text-xs text-slate-500">
                    URL pública: /{{ form.slug || 'tu-slug' }}
                  </p>
                </div>
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Bio</label>
                <textarea
                  v-model="form.bio"
                  rows="4"
                  placeholder="Cuéntale al mundo quién eres..."
                  class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                />
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Avatar URL</label>
                <input
                  v-model="form.avatar_url"
                  placeholder="https://..."
                  class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                />
              </div>

              <div class="space-y-2">
                <label class="text-sm font-medium text-slate-700">Banner URL</label>
                <input
                  v-model="form.banner_url"
                  placeholder="https://..."
                  class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-slate-900 focus:ring-4 focus:ring-slate-200"
                />
              </div>
            </div>
          </div>

          <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5">
              <h2 class="text-xl font-bold text-slate-900">Bloques de contenido</h2>
              <p class="mt-1 text-sm text-slate-500">
                Agrega, ordena y edita bloques para construir tu página pública.
              </p>
            </div>

            <BlockEditor v-model:blocks="form.draft_payload.blocks" />
          </div>
        </section>

        <section class="min-w-0 space-y-4 overflow-hidden">
          <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
              <div class="min-w-0">
                <h2 class="text-xl font-bold text-slate-900">Preview móvil</h2>
                <p class="mt-1 text-sm text-slate-500">
                  ¡Así se verá el perfil publicado!
                </p>
              </div>

              <a
                v-if="isPublished"
                :href="`/${form.slug}`"
                target="_blank"
                class="shrink-0 rounded-full bg-slate-900 px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-slate-700"
              >
                Ver perfil ↗
              </a>

              <span
                v-else
                class="shrink-0 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700"
              >
                Preview
              </span>
            </div>
          </div>

          <div class="min-w-0 overflow-hidden px-1 sm:px-2">
            <div class="relative mx-auto w-full max-w-[320px] rounded-[40px] bg-gradient-to-b from-slate-800 to-black p-[8px] ring-1 ring-slate-200 sm:max-w-[340px] sm:rounded-[44px] sm:p-[9px] md:max-w-[390px] md:rounded-[48px] md:p-[10px]">
              <div class="absolute -left-[3px] top-24 hidden h-14 w-[4px] rounded-full bg-slate-700 md:block"></div>
              <div class="absolute -left-[3px] top-44 hidden h-20 w-[4px] rounded-full bg-slate-700 md:block"></div>
              <div class="absolute -right-[3px] top-36 hidden h-24 w-[4px] rounded-full bg-slate-700 md:block"></div>

              <div class="relative overflow-hidden rounded-[32px] bg-slate-50 sm:rounded-[36px] md:rounded-[40px]">
                <div class="absolute left-1/2 top-3 z-20 h-6 w-28 -translate-x-1/2 rounded-full bg-black shadow sm:h-7 sm:w-32 md:w-36"></div>

                <div class="flex items-center justify-between px-5 pb-2 pt-5 text-[11px] font-semibold text-slate-500 sm:px-6">
                  <span>9:41</span>
                  <div class="flex items-center gap-1">
                    <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                    <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                    <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                  </div>
                </div>

                <div class="h-[680px] overflow-y-auto px-0 pb-8 pt-0 sm:h-[700px] md:h-[720px]">
                  <div
                    class="h-36 w-full sm:h-40"
                    :style="bannerStyle"
                  ></div>

                  <div class="px-5 pb-6 pt-4 text-center">
                    <img
                      v-if="form.avatar_url"
                      :src="form.avatar_url"
                      alt="Avatar"
                      class="mx-auto -mt-12 h-24 w-24 rounded-full object-cover ring-4 ring-white shadow-md"
                    />

                    <div
                      v-else
                      class="mx-auto -mt-12 flex h-24 w-24 items-center justify-center rounded-full bg-slate-200 text-2xl font-bold text-slate-500 ring-4 ring-white shadow-md"
                    >
                      {{ initials }}
                    </div>

                    <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
                      {{ form.public_name || 'Tu nombre público' }}
                    </h1>

                    <div
                      v-if="socialBlock"
                      class="mt-4 flex items-center justify-center gap-4"
                    >
                      <a
                        v-if="socialBlock.props?.instagram"
                        :href="socialBlock.props.instagram"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-slate-700 transition hover:scale-110 hover:text-pink-600"
                        aria-label="Instagram"
                      >
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                          <path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5a4.25 4.25 0 0 0 4.25-4.25v-8.5A4.25 4.25 0 0 0 16.25 3.5h-8.5Zm8.75 2a1 1 0 1 1 0 2 1 1 0 0 1 0-2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.5A3.5 3.5 0 1 0 12 15.5 3.5 3.5 0 0 0 12 8.5Z"/>
                        </svg>
                      </a>

                      <a
                        v-if="socialBlock.props?.tiktok"
                        :href="socialBlock.props.tiktok"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-slate-700 transition hover:scale-110 hover:text-black"
                        aria-label="TikTok"
                      >
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                          <path d="M14 3c.4 1.9 1.6 3.4 3.5 4.1.9.3 1.8.4 2.5.4V10c-1 0-2-.2-2.9-.6-.5-.2-1-.5-1.6-.9v6.2a5.7 5.7 0 1 1-5.7-5.7c.3 0 .7 0 1 .1v2.4a3.2 3.2 0 1 0 2.2 3v-11H14Z"/>
                        </svg>
                      </a>

                      <a
                        v-if="socialBlock.props?.x"
                        :href="socialBlock.props.x"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-slate-700 transition hover:scale-110 hover:text-black"
                        aria-label="X"
                      >
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                          <path d="M18.9 2H22l-6.8 7.8L23 22h-6.1l-4.8-6.3L6.6 22H3.5l7.3-8.4L1 2h6.3l4.3 5.8L18.9 2Zm-1.1 18h1.7L6.4 3.9H4.6L17.8 20Z"/>
                        </svg>
                      </a>

                      <a
                        v-if="socialBlock.props?.facebook"
                        :href="socialBlock.props.facebook"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-slate-700 transition hover:scale-110 hover:text-blue-600"
                        aria-label="Facebook"
                      >
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current" aria-hidden="true">
                          <path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.6c0-.9.2-1.5 1.5-1.5h1.8V4.2c-.3 0-1.3-.1-2.5-.1-2.5 0-4.1 1.5-4.1 4.4v2.1H7.5v3.2H10V22h3.5Z"/>
                        </svg>
                      </a>
                    </div>

                    <p class="mx-auto mt-3 max-w-[280px] text-sm leading-6 text-slate-600">
                      {{ form.bio || 'Tu bio aparecerá aquí cuando la completes.' }}
                    </p>
                  </div>

                  <BlockPreview :blocks="form.draft_payload.blocks" />
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>

    <EditorFooterActions
      :loading="loading"
      @save="save"
      @publish="publish"
    />

    <PublishSuccessModal
      :open="isFeedbackModalOpen"
      :title="feedbackModalTitle"
      :description="feedbackModalDescription"
      :public-url="publicProfileUrl"
      :show-public-button="feedbackModalShowPublicButton"
      close-text="Continuar editando"
      @close="isFeedbackModalOpen = false"
    />
  </main>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue'
import axios from 'axios'
import BlockEditor from './BlockEditor.vue'
import BlockPreview from './BlockPreview.vue'
import EditorHeader from './EditorHeader.vue'
import EditorFooterActions from './EditorFooterActions.vue'
import PublishSuccessModal from './PublishSuccessModal.vue'

const props = defineProps({
  user: {
    type: Object,
    default: null,
  },
})

const user = props.user

const form = ref({
  public_name: '',
  slug: '',
  bio: '',
  avatar_url: '',
  banner_url: '',
  draft_payload: {
    blocks: [],
  },
})

const loading = ref(false)

const isFeedbackModalOpen = ref(false)
const feedbackModalTitle = ref('')
const feedbackModalDescription = ref('')
const feedbackModalShowPublicButton = ref(false)

const publicProfileUrl = computed(() => `/${form.value.slug}`)

const isPublished = computed(() => {
  return !!form.value.slug && !!form.value.draft_payload?.blocks?.length
})

const initials = computed(() => {
  if (!form.value.public_name) return 'U'

  return form.value.public_name
    .split(' ')
    .filter(Boolean)
    .slice(0, 2)
    .map((part) => part[0]?.toUpperCase())
    .join('')
})

const socialBlock = computed(() =>
  (form.value.draft_payload?.blocks || []).find(
    (block) => block.type === 'social' && block.enabled !== false
  ) || null
)

const load = async () => {
  try {
    const res = await axios.get('/site')

    if (res.data.data) {
      form.value = {
        public_name: res.data.data.public_name ?? '',
        slug: res.data.data.slug ?? '',
        bio: res.data.data.bio ?? '',
        avatar_url: res.data.data.avatar_url ?? '',
        banner_url: res.data.data.banner_url ?? '',
        draft_payload: res.data.data.draft_payload ?? { blocks: [] },
      }

      if (!form.value.draft_payload?.blocks) {
        form.value.draft_payload = { blocks: [] }
      }
    }
  } catch (error) {
    console.error(error)
  }
}

const save = async ({ silent = false } = {}) => {
  try {
    console.log('🔥 SAVE START', form.value)

    loading.value = true
    await axios.post('/site', JSON.parse(JSON.stringify(form.value)))

    console.log('✅ SAVE OK')

    if (!silent) {
      feedbackModalTitle.value = 'Cambios guardados'
      feedbackModalDescription.value = 'Tus cambios se guardaron correctamente.'
      feedbackModalShowPublicButton.value = false
      isFeedbackModalOpen.value = true
    }

    return true
  } catch (error) {
    console.error('❌ SAVE ERROR', error)
    console.error('❌ SAVE RESPONSE', error.response?.data)

    if (!silent) {
      alert('Hubo un error al guardar')
    }

    throw error
  } finally {
    loading.value = false
  }
}

const publish = async () => {
  try {
    console.log('🔥 PUBLISH START')

    await save({ silent: true })

    console.log('➡️ calling publish API')
    await axios.post('/site/publish')

    console.log('✅ PUBLISH OK')

    feedbackModalTitle.value = 'Perfil publicado'
    feedbackModalDescription.value = 'Tu perfil público ya está disponible. Puedes verlo ahora o seguir editando.'
    feedbackModalShowPublicButton.value = true
    isFeedbackModalOpen.value = true
  } catch (error) {
    console.error('❌ PUBLISH ERROR', error)
    console.error('❌ PUBLISH RESPONSE', error.response?.data)
    alert('Hubo un error al publicar')
  }
}

const gradients = [
  'linear-gradient(65deg, #ebf4f5, #b5c6e0)',
  'linear-gradient(65deg, #f6d5f7, #fbe9d7)',
  'linear-gradient(65deg, #e9b7ce, #d3f3f1)',
  'linear-gradient(65deg, #eed991, #ccf7f4)',
  'linear-gradient(65deg, #6d90b9, #bbc7dc)',
]

const gradientIndex = ref(Math.floor(Math.random() * gradients.length))

const bannerStyle = computed(() => {
  if (form.value.banner_url) {
    return {
      backgroundImage: `url(${form.value.banner_url})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      backgroundRepeat: 'no-repeat',
    }
  }

  return {
    background: gradients[gradientIndex.value],
  }
})

onMounted(load)
</script>