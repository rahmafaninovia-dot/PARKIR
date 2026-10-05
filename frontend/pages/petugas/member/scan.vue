<template>
    <div class="min-h-screen bg-slate-100 p-5 md:p-10">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-blue-700">
                Scan Member
            </h1>

            <p class="text-gray-500 mt-1">
                Masukkan kode member untuk mencari data
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 max-w-2xl">

            <div class="mb-5">

                <label class="block font-semibold mb-2">
                    Kode Member
                </label>

                <input
                    v-model="kode_member"
                    type="text"
                    placeholder="Scan atau masukkan kode member"
                    @keyup.enter="scanMember"
                    class="w-full border rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500"
                />

            </div>

            <button
                @click="scanMember"
                :disabled="loading"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold disabled:opacity-50"
            >
                {{ loading ? 'Mencari...' : 'Scan Member' }}
            </button>


            <div
                v-if="error"
                class="mt-5 bg-red-100 text-red-700 p-4 rounded-xl"
            >
                {{ error }}
            </div>


            <div
                v-if="member"
                class="mt-6 border rounded-2xl p-5"
            >

                <h2 class="text-xl font-bold text-blue-700 mb-4">
                    Data Member
                </h2>

                <div class="space-y-3">

                    <p>
                        <b>Kode:</b>
                        {{ member.kode_member }}
                    </p>

                    <p>
                        <b>Nama:</b>
                        {{ member.nama_member }}
                    </p>

                    <p>
                        <b>Perusahaan:</b>
                        {{ member.nama_perusahaan || '-' }}
                    </p>

                    <p>
                        <b>Status Pembayaran:</b>
                        {{ member.status_pembayaran || member.status || '-' }}
                    </p>

                    <p>
                        <b>Expired:</b>
                        {{ member.tanggal_expired || '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>
</template>

<script setup lang="ts">

import { ref } from 'vue'

const { $api } = useNuxtApp()

const kode_member = ref('')
const member = ref<any>(null)

const loading = ref(false)
const error = ref('')

const scanMember = async () => {

    if (!kode_member.value) {

        error.value = 'Kode member harus diisi.'

        return

    }

    loading.value = true
    error.value = ''
    member.value = null

    try {

        const res = await $api.get(
            `/member/kode/${kode_member.value}`
        )

        member.value =
            res.data.data || res.data

    } catch (err: any) {

        console.error(err)

        error.value =
            err?.response?.data?.message ||
            'Member tidak ditemukan.'

    } finally {

        loading.value = false

    }
}

</script>