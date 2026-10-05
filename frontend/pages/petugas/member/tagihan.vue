<template>
    <div class="min-h-screen bg-slate-100 p-5 md:p-10">

        <div class="mb-6">

            <h1 class="text-3xl font-bold text-blue-700">
                Tagihan Member
            </h1>

            <p class="text-gray-500 mt-1">
                Data tagihan pembayaran member
            </p>

        </div>


        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead>

                        <tr class="bg-blue-600 text-white">

                            <th class="px-4 py-4 text-left">
                                No
                            </th>

                            <th class="px-4 py-4 text-left">
                                Kode Member
                            </th>

                            <th class="px-4 py-4 text-left">
                                Nama Member
                            </th>

                            <th class="px-4 py-4 text-left">
                                Tagihan
                            </th>

                            <th class="px-4 py-4 text-left">
                                Dibayar
                            </th>

                            <th class="px-4 py-4 text-left">
                                Status
                            </th>

                            <th class="px-4 py-4 text-left">
                                Expired
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <tr
                            v-for="(item, index) in members"
                            :key="item.id"
                            class="border-b hover:bg-slate-50"
                        >

                            <td class="px-4 py-4">
                                {{ index + 1 }}
                            </td>

                            <td class="px-4 py-4 font-semibold">
                                {{ item.kode_member }}
                            </td>

                            <td class="px-4 py-4">
                                {{ item.nama_member }}
                            </td>

                            <td class="px-4 py-4">
                                Rp {{ formatRupiah(
                                    item.total_harga || 150000
                                ) }}
                            </td>

                            <td class="px-4 py-4">
                                Rp {{ formatRupiah(
                                    item.jumlah_bayar
                                ) }}
                            </td>

                            <td class="px-4 py-4">

                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold"
                                    :class="
                                        getStatusClass(item)
                                    "
                                >
                                    {{ getStatus(item) }}
                                </span>

                            </td>

                            <td class="px-4 py-4">
                                {{ formatTanggal(
                                    item.tanggal_expired
                                ) }}
                            </td>

                        </tr>


                        <tr
                            v-if="
                                !loading &&
                                members.length === 0
                            "
                        >

                            <td
                                colspan="7"
                                class="text-center py-10 text-gray-500"
                            >
                                Belum ada data tagihan.
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>


        <div
            v-if="loading"
            class="text-center mt-5 text-gray-500"
        >
            Memuat data tagihan...
        </div>


        <div
            v-if="error"
            class="mt-5 bg-red-100 text-red-700 p-4 rounded-xl"
        >
            {{ error }}
        </div>

    </div>
</template>

<script setup lang="ts">

import {
    ref,
    onMounted
} from 'vue'

const { $api } = useNuxtApp()

const members = ref<any[]>([])

const loading = ref(false)

const error = ref('')


const formatRupiah = (angka: any) => {

    return new Intl.NumberFormat(
        'id-ID'
    ).format(
        Number(angka || 0)
    )

}


const formatTanggal = (tanggal: any) => {

    if (!tanggal) {
        return '-'
    }

    return new Date(
        tanggal
    ).toLocaleDateString(
        'id-ID',
        {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        }
    )

}


const getStatus = (item: any) => {

    if (
        item.status_pembayaran === 'lunas' ||
        item.status === 'lunas'
    ) {
        return 'Lunas'
    }

    return 'Belum Lunas'

}


const getStatusClass = (item: any) => {

    if (
        item.status_pembayaran === 'lunas' ||
        item.status === 'lunas'
    ) {

        return 'bg-green-100 text-green-700'

    }

    return 'bg-red-100 text-red-700'

}


const loadTagihan = async () => {

    loading.value = true
    error.value = ''

    try {

        const res = await $api.get(
            '/member'
        )

        members.value =
            res.data.data || []

    } catch (err: any) {

        console.error(err)

        error.value =
            err?.response?.data?.message ||
            'Gagal mengambil data tagihan.'

    } finally {

        loading.value = false

    }

}


onMounted(loadTagihan)

</script>