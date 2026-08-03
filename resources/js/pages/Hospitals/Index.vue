<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { hospital } from '@/routes';

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Медицинские учреждения',
        href: hospital(),
      },
    ],
  },
});
</script>

<template>

  <Head title="Медицинские учреждения" />

  <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    
  </div>
</template>
