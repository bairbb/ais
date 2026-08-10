<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { hospitals as hospitalsRoute } from '@/routes';
import { columns, type Hospital } from './columns';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import Input from '@/components/ui/input/Input.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import { X } from '@lucide/vue';

const props = defineProps<{
  hospitals: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    data: Hospital[];
  };
  filters: {
    search: string | null;
  }
}>();

const searchQuery = ref(props.filters.search || '')

const handleSearch = () => {
  router.get(usePage().url,
    {
      search: searchQuery.value || undefined,
      page: 1,
    },
    {
      preserveState: true,
      preserveScroll: true,
      only: ['hospitals', 'filters']
    }
  );
};

const handleClear = () => {
  searchQuery.value = '';
  handleSearch();
};

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
    <div class="flex items-center justify-between p-2 mb-6">
      <div class="flex items-center space-x-1 w-4xl">
        <div class="relative flex-1 w-full">
          <Input
            class="w-full"
            placeholder="Введите для поиска"
            v-model="searchQuery"
            id="searchQuery"
            @keydown.enter="handleSearch"
          />
          <button
            v-if="searchQuery"
            @click="handleClear"
            class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center justify-center text-muted-foreground hover:text-foreground transition-colors cursor-pointer"
          >
            <X class="h-4 w-4" /> 
          </button>
        </div>
        <Button
          variant="outline"
          @click="handleSearch"
        >
          Найти
        </Button>
      </div>
      
      <Button variant="outline">Добавить ЛПУ</Button>
    </div>
    <DataTable 
      :columns="columns" 
      :data="hospitals.data"
      :pagination="hospitals"
    />
  </div>
</template>
