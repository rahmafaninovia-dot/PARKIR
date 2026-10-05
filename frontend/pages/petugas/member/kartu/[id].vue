<template>

    <div class="min-h-screen bg-slate-100 p-5 md:p-10">

        <!-- JUDUL -->

        <div class="max-w-md mx-auto mb-5">

            <h1 class="text-2xl font-bold text-blue-700">
                Kartu Member
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Detail kartu member
            </p>

        </div>


        <!-- KARTU -->

        <div
            v-if="member"
            class="
                max-w-md
                mx-auto
                bg-white
                rounded-2xl
                shadow-lg
                overflow-hidden
            "
        >

            <!-- HEADER KARTU -->

            <div
                class="
                    bg-blue-600
                    text-white
                    px-5
                    py-4
                "
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm opacity-80">
                            KARTU MEMBER
                        </p>

                        <h2 class="text-xl font-bold">
                            PARKIR MEMBER
                        </h2>

                    </div>

                    <div class="text-3xl">
                        🅿️
                    </div>

                </div>

            </div>


            <!-- ISI KARTU -->

            <div class="p-5">

                <!-- QR CODE -->

                <div class="flex justify-center mb-5">

                    <div
                        class="
                            bg-white
                            border
                            border-gray-200
                            rounded-xl
                            p-3
                            shadow-sm
                        "
                    >

                        <img
                            v-if="member.qr"
                            :src="member.qr"
                            alt="QR Member"
                            class="
                                w-40
                                h-40
                                object-contain
                            "
                        />

                        <div
                            v-else
                            class="
                                w-40
                                h-40
                                bg-gray-100
                                rounded-lg
                                flex
                                items-center
                                justify-center
                                text-gray-500
                                text-sm
                                text-center
                            "
                        >
                            QR belum tersedia
                        </div>

                    </div>

                </div>


                <!-- DATA -->

                <div class="space-y-3">

                    <!-- KODE -->

                    <div>

                        <p class="text-xs text-gray-500">
                            Kode Member
                        </p>

                        <p class="font-bold text-gray-800">
                            {{ member.kode_member }}
                        </p>

                    </div>


                    <!-- NAMA -->

                    <div>

                        <p class="text-xs text-gray-500">
                            Nama Member
                        </p>

                        <p class="font-bold text-gray-800">
                            {{ member.nama_member }}
                        </p>

                    </div>


                    <!-- PERUSAHAAN -->

                    <div>

                        <p class="text-xs text-gray-500">
                            Perusahaan
                        </p>

                        <p class="font-bold text-gray-800">
                            {{ member.nama_perusahaan || '-' }}
                        </p>

                    </div>


                    <!-- STATUS -->

                    <div
                        class="
                            flex
                            items-center
                            justify-between
                            bg-slate-50
                            rounded-xl
                            px-4
                            py-3
                        "
                    >

                        <span class="font-semibold">
                            Status
                        </span>

                        <span
                            :class="
                                member.status === 'lunas'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'
                            "
                            class="
                                px-3
                                py-1
                                rounded-full
                                text-xs
                                font-bold
                                uppercase
                            "
                        >
                            {{ member.status }}
                        </span>

                    </div>


                    <!-- BERLAKU -->

                    <div>

                        <p class="text-xs text-gray-500">
                            Berlaku Sampai
                        </p>

                        <p class="font-semibold text-gray-800">
                            {{ formatTanggal(member.tanggal_expired) }}
                        </p>

                    </div>

                </div>


                <!-- TOMBOL -->

                <div class="mt-6 space-y-2">

                    <button
                        @click="kembali"
                        class="
                            w-full
                            bg-gray-600
                            hover:bg-gray-700
                            text-white
                            py-3
                            rounded-xl
                            font-semibold
                        "
                    >
                        Kembali
                    </button>

                </div>

            </div>

        </div>


        <!-- LOADING -->

        <div
            v-else
            class="
                max-w-md
                mx-auto
                bg-white
                rounded-2xl
                shadow
                p-6
                text-center
            "
        >

            <p class="text-gray-500">
                Memuat data kartu member...
            </p>

        </div>

    </div>

</template>


<script setup lang="ts">

import {
    ref,
    onMounted
} from 'vue';


// =========================================================
// API
// =========================================================

const { $api } = useNuxtApp();

const route = useRoute();

const router = useRouter();


// =========================================================
// DATA MEMBER
// =========================================================

const member = ref<any>(null);


// =========================================================
// FORMAT TANGGAL
// =========================================================

const formatTanggal = (tanggal: any) => {

    if (!tanggal) {
        return '-';
    }

    return new Date(tanggal).toLocaleDateString(
        'id-ID',
        {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        }
    );

};


// =========================================================
// LOAD MEMBER
// =========================================================

const loadMember = async () => {

    try {

        const res = await $api.get(
            `/member/${route.params.id}`
        );


        if (!res.data.status) {

            alert(
                res.data.message ||
                'Member tidak ditemukan'
            );

            kembali();

            return;

        }


        member.value =
            res.data.data;

    }

    catch (error: any) {

        console.error(
            'Gagal mengambil data member:',
            error
        );

        alert(
            error?.response?.data?.message ||
            'Gagal mengambil data member'
        );

    }

};


// =========================================================
// KEMBALI
// =========================================================

const kembali = () => {

    router.push(
        '/petugas/member/select'
    );

};


// =========================================================
// JALANKAN
// =========================================================

onMounted(
    loadMember
);

</script>