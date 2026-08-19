<script setup lang="ts">
import { Head, router, usePage, useForm } from '@inertiajs/vue3';
import { hospitals as hospitalsRoute, hospitals_store } from '@/routes';
import { columns, type Hospital } from './columns';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import { X } from '@lucide/vue';
import {
  Dialog,
  DialogClose,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import InputError from '@/components/InputError.vue';

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

const isDialogOpen = ref(false);

const form = useForm({
  name: '',
  full_name: '',
})

const submitForm = () => {
  form.post(hospitals_store().url, {
    preserveScroll: true,
    onSuccess: () => {
      isDialogOpen.value = false;
      form.reset();
    }
  })
}

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
          <Input class="w-full" placeholder="Введите для поиска" v-model="searchQuery" id="searchQuery"
            name="searchQuery" @keydown.enter="handleSearch" />
          <button v-if="searchQuery" @click="handleClear"
            class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center justify-center text-muted-foreground hover:text-foreground transition-colors cursor-pointer">
            <X class="h-4 w-4" />
          </button>
        </div>
        <Button variant="outline" @click="handleSearch">
          Найти
        </Button>
      </div>

      <Dialog v-model:open="isDialogOpen">
        <DialogTrigger as-child>
          <Button variant="outline">
            Добавить ЛПУ
          </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-106">
          <DialogHeader>
            <DialogTitle>Добавление медицинского учреждения</DialogTitle>
            <DialogDescription>
              Введите названия больницы или поликлиники для внесения в справочник системы морга.
            </DialogDescription>
          </DialogHeader>
          <form @submit.prevent="submitForm" class="space-y-6">
            <div class="grid gap-4">
              <div class="grid gap-3">
                <Label for="name">Короткое наименование</Label>
                <Input id="name" v-model="form.name" placeholder="Введите короткое наименование" />
                <InputError :message="form.errors.name" />
              </div>
              <div class="grid gap-3">
                <Label for="full_name">Полное наименование</Label>
                <Input id="full_name" v-model="form.full_name" placeholder="Введите полное наименование" />
                <InputError :message="form.errors.full_name" />
              </div>
            </div>
            <DialogFooter>
              <DialogClose as-child>
                <Button variant="outline">
                  Отмена
                </Button>
              </DialogClose>
              <Button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Сохранение...' : 'Сохранить' }}
              </Button>
            </DialogFooter>
          </form>
        </DialogContent>
      </Dialog>
    </div>

    <DataTable :columns="columns" :data="hospitals.data" :pagination="hospitals" />
  </div>
</template>
