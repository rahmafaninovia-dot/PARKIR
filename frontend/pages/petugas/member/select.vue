<template>

    <div class="min-h-screen bg-slate-100 p-5 md:p-10">

        <!-- ========================= -->
        <!-- HEADER -->
        <!-- ========================= -->

        <div
            class="
                flex
                flex-col
                sm:flex-row
                sm:items-center
                sm:justify-between
                gap-4
                mb-6
            "
        >

            <!-- JUDUL -->
            <div>

                <h1 class="text-3xl font-bold text-blue-700">
                    Data Member
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola data member parkir
                </p>

            </div>


            <!-- TOMBOL KEMBALI KE HALAMAN UTAMA -->
            <button
    type="button"
    @click="router.push('/petugas')"
    class="
        inline-flex
        items-center
        justify-center
        gap-2
        bg-gray-600
        hover:bg-gray-700
        text-white
        px-5
        py-2.5
        rounded-xl
        font-semibold
        text-sm
        shadow-sm
        hover:shadow-md
        transition-all
    "
>
    <span class="text-lg">
        ←
    </span>

    Kembali
</button>

        </div>



        <!-- ========================= -->
        <!-- TOMBOL TAMBAH -->
        <!-- ========================= -->

        <button
            type="button"
            @click="router.push('/petugas/member/tambah')"
            class="
                bg-blue-600
                hover:bg-blue-700
                text-white
                px-5
                py-3
                rounded-xl
                mb-5
                font-semibold
                transition-colors
                shadow-sm
            "
        >

            + Tambah Member

        </button>



        <!-- ========================= -->
        <!-- TABEL MEMBER -->
        <!-- ========================= -->

        <div
            class="
                bg-white
                rounded-xl
                shadow
                p-5
                overflow-x-auto
            "
        >

            <table class="w-full min-w-250">

                <!-- HEADER TABEL -->
                <thead>

                    <tr class="border-b bg-slate-50">

                        <th class="p-3 text-left">
                            Kode
                        </th>

                        <th class="p-3 text-left">
                            Nama Member
                        </th>

                        <th class="p-3 text-left">
                            Perusahaan
                        </th>

                        <th class="p-3 text-left">
                            Tagihan
                        </th>

                        <th class="p-3 text-left">
                            Dibayar
                        </th>

                        <th class="p-3 text-left">
                            Status
                        </th>

                        <th class="p-3 text-left">
                            Expired
                        </th>

                        <th class="p-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>



                <!-- DATA MEMBER -->
                <tbody>

                    <tr
                        v-for="item in members"
                        :key="item.id"
                        class="
                            border-b
                            hover:bg-slate-50
                            transition-colors
                        "
                    >

                        <!-- KODE -->
                        <td class="p-3">
                            {{ item.kode_member }}
                        </td>


                        <!-- NAMA -->
                        <td class="p-3">
                            {{ item.nama_member }}
                        </td>


                        <!-- PERUSAHAAN -->
                        <td class="p-3">
                            {{ item.nama_perusahaan || '-' }}
                        </td>


                        <!-- TAGIHAN -->
                        <td class="p-3 font-semibold">
                            Rp {{ formatRupiah(item.total_harga) }}
                        </td>


                        <!-- DIBAYAR -->
                        <td class="p-3 font-semibold">

                            Rp
                            {{
                                item.status === 'lunas'
                                    ? formatRupiah(
                                        Number(item.total_harga || 0)
                                        +
                                        Number(item.kembalian || 0)
                                    )
                                    : formatRupiah(0)
                            }}

                        </td>


                        <!-- STATUS -->
                        <td class="p-3">

                            <span
                                class="
                                    px-3
                                    py-1
                                    rounded-full
                                    text-sm
                                    font-semibold
                                "
                                :class="
                                    item.status === 'lunas'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700'
                                "
                            >
                                {{ item.status }}
                            </span>

                        </td>


                        <!-- EXPIRED -->
                        <td class="p-3">

                            {{ formatTanggal(item.tanggal_expired) }}

                        </td>


                        <!-- AKSI -->
                        <td class="p-3">

                            <div
                                class="
                                    flex
                                    justify-center
                                    gap-2
                                "
                            >

                                <!-- DETAIL -->
                                <button
                                    type="button"
                                    @click.stop="lihatDetail(item.id)"
                                    class="
                                        bg-blue-600
                                        hover:bg-blue-700
                                        text-white
                                        p-2
                                        rounded-lg
                                        transition-colors
                                    "
                                    title="Detail"
                                >

                                    <EyeIcon
                                        class="w-5 h-5"
                                    />

                                </button>


                                <!-- EDIT / PEMBAYARAN -->
                                <button
                                    type="button"
                                    @click.stop="edit(item.id)"
                                    :disabled="item.status === 'lunas'"
                                    :class="
                                        item.status === 'lunas'
                                            ? 'bg-gray-300 text-gray-400 cursor-not-allowed'
                                            : 'bg-yellow-500 hover:bg-yellow-600 text-white'
                                    "
                                    class="
                                        p-2
                                        rounded-lg
                                        transition-colors
                                    "
                                    title="Pembayaran"
                                >

                                    <PencilIcon
                                        class="w-5 h-5"
                                    />

                                </button>


                                <!-- HAPUS -->
                                <button
                                    type="button"
                                    @click.stop="hapus(item.id)"
                                    :disabled="item.status === 'lunas'"
                                    :class="
                                        item.status === 'lunas'
                                            ? 'bg-gray-300 text-gray-400 cursor-not-allowed'
                                            : 'bg-red-600 hover:bg-red-700 text-white'
                                    "
                                    class="
                                        p-2
                                        rounded-lg
                                        transition-colors
                                    "
                                    title="Hapus"
                                >

                                    <TrashIcon
                                        class="w-5 h-5"
                                    />

                                </button>

                            </div>

                        </td>

                    </tr>



                    <!-- DATA KOSONG -->
                    <tr v-if="members.length === 0">

                        <td
                            colspan="8"
                            class="
                                p-10
                                text-center
                                text-gray-500
                            "
                        >

                            Belum ada data member

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>



        <!-- ========================= -->
        <!-- MODAL DETAIL -->
        <!-- ========================= -->

        <div
            v-if="showModal"
            class="
                fixed
                inset-0
                bg-black/50
                flex
                items-center
                justify-center
                z-50
                p-4
            "
        >

            <div
                class="
                    bg-white
                    rounded-2xl
                    p-5
                    w-full
                    max-w-sm
                    shadow-xl
                    max-h-[90vh]
                    overflow-y-auto
                "
            >

                <!-- JUDUL -->
                <h2
                    class="
                        text-xl
                        font-bold
                        text-center
                        mb-4
                        text-gray-800
                    "
                >
                    Kartu Member
                </h2>


                <!-- QR CODE -->
                <div
                    class="
                        flex
                        justify-center
                        mb-4
                    "
                >

                    <img
                        v-if="qr"
                        :src="qr"
                        class="
                            w-36
                            h-36
                            object-contain
                        "
                    />

                    <div
                        v-else
                        class="
                            w-36
                            h-36
                            flex
                            items-center
                            justify-center
                            bg-gray-100
                            text-gray-500
                            rounded-lg
                            text-sm
                        "
                    >

                        QR belum tersedia

                    </div>

                </div>


                <!-- DETAIL -->
                <div
                    class="
                        space-y-1.5
                        text-sm
                        text-gray-700
                    "
                >

                    <p>
                        <b>Kode :</b>
                        {{ detailMember.kode_member }}
                    </p>

                    <p>
                        <b>Nama :</b>
                        {{ detailMember.nama_member }}
                    </p>

                    <p>
                        <b>Perusahaan :</b>
                        {{ detailMember.nama_perusahaan || '-' }}
                    </p>

                    <p>
                        <b>Tagihan :</b>
                        Rp
                        {{ formatRupiah(detailMember.total_harga) }}
                    </p>

                    <p>
                        <b>Dibayar :</b>
                        Rp
                        {{
                            detailMember.status === 'lunas'
                                ? formatRupiah(
                                    Number(detailMember.total_harga || 0)
                                    +
                                    Number(detailMember.kembalian || 0)
                                )
                                : formatRupiah(0)
                        }}
                    </p>

                    <p>
                        <b>Kembalian :</b>
                        Rp
                        {{ formatRupiah(detailMember.kembalian) }}
                    </p>

                    <p>

                        <b>Status :</b>

                        <span
                            :class="
                                detailMember.status === 'lunas'
                                    ? 'text-green-600'
                                    : 'text-red-600'
                            "
                            class="
                                font-bold
                                uppercase
                                ml-1
                            "
                        >

                            {{ detailMember.status }}

                        </span>

                    </p>

                    <p>
                        <b>Tanggal Bayar :</b>
                        {{ formatTanggal(detailMember.tanggal_mulai) }}
                    </p>

                    <p>
                        <b>Berlaku Sampai :</b>
                        {{ formatTanggal(detailMember.tanggal_expired) }}
                    </p>

                </div>



                <!-- ========================= -->
                <!-- TOMBOL MODAL -->
                <!-- ========================= -->

                <div class="mt-5 space-y-2">

                    <!-- DOWNLOAD -->
                    <button
                        type="button"
                        @click="downloadMember"
                        class="
                            w-full
                            bg-green-600
                            hover:bg-green-700
                            text-white
                            py-2.5
                            rounded-xl
                            font-semibold
                            text-sm
                            transition-colors
                        "
                    >

                        Download Kartu Member

                    </button>


                    <!-- TUTUP -->
                    <button
                        type="button"
                        @click="tutupModal"
                        class="
                            w-full
                            bg-gray-600
                            hover:bg-gray-700
                            text-white
                            py-2.5
                            rounded-xl
                            font-semibold
                            text-sm
                            transition-colors
                        "
                    >

                        Tutup

                    </button>

                </div>

            </div>

        </div>

    </div>

</template>



<script setup lang="ts">

import {
    ref,
    onMounted
} from "vue";

import {
    EyeIcon,
    PencilIcon,
    TrashIcon
} from "@heroicons/vue/24/solid";


// ======================================================
// API & ROUTER
// ======================================================

const { $api } = useNuxtApp();

const router = useRouter();


// ======================================================
// DATA
// ======================================================

const members = ref<any[]>([]);

const showModal = ref(false);

const detailMember = ref<any>({});

const qr = ref("");


// ======================================================
// LOAD DATA
// ======================================================

const load = async () => {

    try {

        const res =
            await $api.get("/member");

        members.value =
            res.data.data;

    } catch (error: any) {

        alert(
            error?.response?.data?.message ||
            "Gagal mengambil data member"
        );

    }

};


// ======================================================
// DETAIL MEMBER
// ======================================================

const lihatDetail = async (
    id: number
) => {

    try {

        const res =
            await $api.get(
                `/member/${id}`
            );

        if (!res.data.status) {

            alert(
                res.data.message ||
                "Data member tidak ditemukan"
            );

            return;

        }

        detailMember.value =
            res.data.data;

        qr.value =
            res.data.data.qr;

        showModal.value =
            true;

    } catch (error: any) {

        alert(
            error?.response?.data?.message ||
            "Gagal mengambil detail member"
        );

    }

};


// ======================================================
// TUTUP MODAL
// ======================================================

const tutupModal = () => {

    showModal.value =
        false;

    detailMember.value =
        {};

    qr.value =
        "";

};


// ======================================================
// EDIT
// ======================================================

const edit = (
    id: number
) => {

    const target =
        members.value.find(
            (m) => m.id === id
        );


    if (
        target?.status === "lunas"
    ) {

        alert(
            "Member sudah lunas, tidak bisa diedit"
        );

        return;

    }


    router.push(
        `/petugas/member/edit/${id}`
    );

};


// ======================================================
// HAPUS
// ======================================================

const hapus = async (
    id: number
) => {

    const target =
        members.value.find(
            (m) => m.id === id
        );


    if (
        target?.status === "lunas"
    ) {

        alert(
            "Member sudah lunas, tidak bisa dihapus"
        );

        return;

    }


    if (
        !confirm(
            "Yakin hapus member?"
        )
    ) {
        return;
    }


    try {

        await $api.delete(
            `/member/${id}`
        );

        alert(
            "Member berhasil dihapus"
        );

        await load();

    } catch (error: any) {

        alert(
            error?.response?.data?.message ||
            "Gagal menghapus member"
        );

    }

};


// ======================================================
// DOWNLOAD KARTU MEMBER
// ======================================================

const downloadMember = () => {

    if (
        !detailMember.value?.kode_member ||
        !qr.value
    ) {

        alert(
            "Data atau QR Code belum tersedia"
        );

        return;

    }


    const canvas =
        document.createElement(
            "canvas"
        );

    const ctx =
        canvas.getContext(
            "2d"
        );


    if (!ctx) {

        alert(
            "Browser tidak mendukung canvas"
        );

        return;

    }


    canvas.width =
        500;

    canvas.height =
        700;


    // BACKGROUND

    ctx.fillStyle =
        "white";

    ctx.fillRect(
        0,
        0,
        500,
        700
    );


    // JUDUL

    ctx.fillStyle =
        "black";

    ctx.font =
        "bold 30px Arial";

    ctx.textAlign =
        "center";

    ctx.fillText(
        "MEMBER PARKIR",
        250,
        70
    );


    // DATA

    ctx.textAlign =
        "left";

    ctx.font =
        "20px Arial";

    ctx.fillText(
        `Kode : ${detailMember.value.kode_member}`,
        50,
        150
    );

    ctx.fillText(
        `Nama : ${detailMember.value.nama_member}`,
        50,
        200
    );

    ctx.fillText(
        `Perusahaan : ${detailMember.value.nama_perusahaan || '-'}`,
        50,
        250
    );

    ctx.fillText(
        `Status : ${detailMember.value.status}`,
        50,
        300
    );


    // QR CODE

    const img =
        new Image();

    img.crossOrigin =
        "anonymous";


    img.onload = () => {

        ctx.drawImage(
            img,
            150,
            350,
            200,
            200
        );


        const link =
            document.createElement(
                "a"
            );

        link.download =
            `member-${detailMember.value.kode_member}.png`;

        link.href =
            canvas.toDataURL(
                "image/png"
            );

        link.click();

    };


    img.onerror = () => {

        alert(
            "QR Code gagal dimuat ke gambar download"
        );

    };


    img.src =
        qr.value;

};


// ======================================================
// FORMAT RUPIAH
// ======================================================

const formatRupiah = (
    angka: any
) => {

    return new Intl.NumberFormat(
        "id-ID"
    ).format(
        Number(
            angka || 0
        )
    );

};


// ======================================================
// FORMAT TANGGAL
// ======================================================

const formatTanggal = (
    tanggal: any
) => {

    if (!tanggal) {
        return "-";
    }

    return new Date(
        tanggal
    ).toLocaleDateString(
        "id-ID"
    );

};


// ======================================================
// LOAD AWAL
// ======================================================

onMounted(
    load
);

</script>