<template>
    <div class="w-full space-y-4 pb-4">
        <UTable
            ref="table"
            v-model:pagination="pagination"
            :data="data"
            :columns="columns"
            :loading="status === 'pending'"
            :pagination-options="{
        getPaginationRowModel: getPaginationRowModel()
      }"
            class="flex-1"
        />

        <div class="flex justify-center border-t border-default pt-4">
            <UPagination
                :default-page="(table?.tableApi?.getState().pagination.pageIndex || 0) + 1"
                :items-per-page="table?.tableApi?.getState().pagination.pageSize"
                :total="table?.tableApi?.getFilteredRowModel().rows.length"
                @update:page="(p) => table?.tableApi?.setPageIndex(p - 1)"
            />
        </div>
    </div>

</template>



<script setup lang="ts">
import { getPaginationRowModel } from '@tanstack/vue-table'
import type { TableColumn } from '@nuxt/ui'

const table = useTemplateRef('table')

interface User {
    id: number
    name: string
    email: string
    email_verified_at: string | null
    two_factor_confirmed_at: string | null
    current_team_id: number | null
    profile_photo_path: string | null
    created_at: string | null
    updated_at: string | null
    profile_photo_url: string
}

interface Category {
    id: number
    parent_id: number | null
    slug: string
    title: string
    description: string | null
    created_at: string | null
    updated_at: string | null
    deleted_at: string | null
}

interface Post {
    id: number
    category_id: number
    user_id: number
    slug: string
    title: string
    excerpt: string
    content_raw: string
    content_html: string
    is_published: boolean | 0 | 1
    published_at: string
    created_at: string
    updated_at: string
    deleted_at: string | null
    user: User
    category: Category
}
const data = ref<Post[]>([])
const getPosts = () => {
    $fetch('http://localhost/api/blog/posts')
        .then(response => {
            console.log(response)
            data.value = response
        })
}
getPosts()

const columns: TableColumn<Post>[] = [
    {
        accessorKey: 'id',
        header: '#',
        cell: ({ row }) => `#${row.getValue('id')}`
    },
    {
        accessorKey: 'user.name',
        header: 'Автор',
        cell: ({ row }) => row.original.user?.name ?? '—'
    },
    {
        accessorKey: 'category.title',
        header: 'Категорія',
        cell: ({ row }) => row.original.category?.title ?? '—'
    },
    {
        accessorKey: 'title',
        header: 'Заголовок',
        cell: ({ row }) => row.getValue('title')
    },
    {
        accessorKey: 'published_at',
        header: 'Дата публікації',
        cell: ({ row }) => {
            const date = row.getValue('published_at')
            return new Date(date).toLocaleDateString('uk-UA', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })
        }
    }
]
const pagination = ref({
    pageIndex: 0,
    pageSize: 10
})

</script>
