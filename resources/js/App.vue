<template>
  <div class="min-h-screen bg-slate-100">
    <SiteForm :user="user" />
  </div>
</template>

<script setup>
import SiteForm from './components/SiteForm.vue'

const props = defineProps({
  user: Object,
})

// opcional: para no usar props.user en template
const user = props.user
</script>