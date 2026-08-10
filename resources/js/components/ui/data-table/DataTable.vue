<script setup lang="ts">
import type { ColumnDef } from '@tanstack/vue-table'
import {
  FlexRender,
  getCoreRowModel,
  useVueTable,
  functionalUpdate
} from '@tanstack/vue-table'
import { Button } from '../button'
import { router, usePage } from '@inertiajs/vue3'

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { computed, watch } from 'vue';

interface PaginationMeta {
  current_page: number
  last_page: number
  per_page: number
  total: number
}

const props = defineProps<{
  columns: ColumnDef<any, any>[]
  data: any[]
  pagination: PaginationMeta
}>()

const tableData = computed(() => props.data)
const tableColumns = computed(() => props.columns)

const paginationState = computed(() => ({
  pageIndex: props.pagination.current_page - 1,
  pageSize: props.pagination.per_page,
}))

const gridTemplateColumns = computed(() => {
  return props.columns.map(col => `${col.size || 1}fr`).join(' ')
})

const table = useVueTable({
  get data() { return tableData.value },
  get columns() { return tableColumns.value },
  getCoreRowModel: getCoreRowModel(),
  manualPagination: true,
  get pageCount() { return props.pagination.last_page },
  state: {
    get pagination() { return paginationState.value }
  },
  onPaginationChange: (updater) => {
    const nextState = functionalUpdate(updater, paginationState.value)

    router.get(usePage().url, {
      page: nextState.pageIndex + 1,
      // Магия: вытаскиваем из строки браузера текущий поиск и прикрепляем его к запросу страницы
      search: new URLSearchParams(window.location.search).get('search') || undefined,
    }, {
      preserveState: true,
      preserveScroll: true
    })
  }
  })
</script>

<template>
  <div class="w-full">
    <div class="border rounded-md">
      <Table>
        <TableHeader>
          <TableRow v-for="headerGroup in table.getHeaderGroups()"
            :key="headerGroup.id"
            class="bg-gray-50"
            :style="{ gridTemplateColumns }"
          >
            <TableHead v-for="header in headerGroup.headers":key="header.id" class="flex items-center min-w-0 overflow-hidden">
              <FlexRender
                v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                :props="header.getContext()"
              />
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <template v-if="table.getRowModel().rows?.length">
            <TableRow
              v-for="row in table.getRowModel().rows" :key="row.id"
              :data-state="row.getIsSelected() ? 'selected' : undefined"
              :style="{ gridTemplateColumns }"
            >
              <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id" class="flex items-center min-w-0 overflow-hidden">
                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
              </TableCell>
            </TableRow>
          </template>
          <template v-else>
            <TableRow>
              <TableCell :colspan="columns.length" class="h-24 text-center">
                Нет данных.
              </TableCell>
            </TableRow>
          </template>
        </TableBody>
      </Table>
    </div>
    <div class="flex items-center justify-end py-4 space-x-2">
      <div class="text-sm text-muted-foreground mr-auto">
        Страница {{ pagination.current_page }} из {{ pagination.last_page }}
      </div>
      <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()" @click="table.previousPage()">
        <-
      </Button>
      <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
        ->
      </Button>
    </div>
  </div>
</template>
