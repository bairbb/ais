<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { hospitals as hospitalsRoute } from '@/routes';
import { columns, type Hospital } from './columns';
import DataTable from '@/components/ui/data-table/DataTable.vue';

defineProps<{
  hospitals: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    data: Hospital[];
  };
}>();

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Медицинские учреждения',
        href: hospitalsRoute().url,
      },
    ],
  },
});
</script>

<template>

  <Head title="Медицинские учреждения" />

  <div class="p-4">
    
    <DataTable 
      :columns="columns" 
      :data="hospitals.data"
      :pagination="hospitals"
    />
  </div>
</template>
