import { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'

export interface Hospital {
  id: number;
  name: string;
  full_name: string | null;
  // is_active: boolean;
}

export const columns: ColumnDef<Hospital>[] = [
  {
    accessorKey: 'name',
    header: () => h('div', { class: 'font-bold text-base'}, 'Короткое название'),
    size: 1,
    cell: ({ row }) => h('div', { class: 'truncate font-semibold text-foreground' }, row.getValue('name'), )
  },
  {
    accessorKey: 'full_name',
    header: () => h('div', { class: 'font-bold text-base'}, 'Полное название'),
    size: 2,
    cell: ({ row }) => {
      const fullName = row.getValue('full_name') as string | null
      return h('div', {
        class: 'truncate text-muted-foreground text-sm',
        title: fullName || ''
      }, fullName || '-')
    },
  },
]