<template>
  <div
    class="min-h-screen bg-linear-to-br from-emerald-50 via-white to-blue-50 flex items-center justify-center p-5"
  >
    <div class="w-full max-w-2xl">

      <!-- CARD UTAMA -->
      <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- HEADER -->
        <div
          class="bg-linear-to-r from-emerald-600 to-blue-600 px-6 py-7 text-white"
        >
          <div class="flex items-center justify-between">

            <div>
              <p class="text-emerald-100 text-sm mb-1">
                PARKIR PLAZA ANDALAS
              </p>

              <h1 class="text-3xl font-bold">
                Kendaraan Keluar
              </h1>

              <p class="text-emerald-50 mt-2 text-sm">
                Scan barcode / QR Code atau masukkan kode tiket / member
              </p>
            </div>

            <div
              class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center"
            >
              <span class="text-3xl">
                🚗
              </span>
            </div>

          </div>
        </div>


        <!-- CONTENT -->
        <div class="p-6 md:p-8">

          <!-- NOTIFIKASI -->
          <div
            v-if="pesan"
            class="mb-6 rounded-2xl px-4 py-4 flex items-start gap-3"
            :class="
              berhasil
                ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                : 'bg-red-50 text-red-700 border border-red-200'
            "
          >

            <div class="text-xl">
              {{ berhasil ? '✅' : '⚠️' }}
            </div>

            <div class="flex-1">

              <p class="font-semibold">
                {{ berhasil ? 'Berhasil' : 'Perhatian' }}
              </p>

              <p class="text-sm mt-1">
                {{ pesan }}
              </p>

            </div>

          </div>


          <!-- ========================= -->
          <!-- SCANNER -->
          <!-- ========================= -->

          <div v-if="jenisData === ''">

            <div
              class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6"
            >

              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Scan Tiket / Kartu Member
              </label>

              <div class="relative">

                <span
                  class="absolute left-4 top-1/2 -translate-y-1/2 text-xl"
                >
                  🔍
                </span>

                <input
                  ref="inputRef"
                  v-model="inputKode"
                  type="text"
                  autocomplete="off"
                  placeholder="Scan barcode, QR code, kode tiket atau kode member..."
                  class="w-full pl-12 pr-4 py-4 rounded-xl border-2 border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none text-slate-700"
                  @keydown.enter.prevent="cekData"
                />

              </div>

              <p class="text-xs text-slate-500 mt-3">
                Contoh tiket non-member: A001, A002, A003
              </p>

              <p class="text-xs text-slate-500">
                Untuk member dapat menggunakan kode member atau QR kartu member.
              </p>

            </div>


            <!-- TOMBOL SCAN + KEMBALI -->
            <div class="grid grid-cols-2 gap-3">

              <button
                type="button"
                @click="kembaliDashboard"
                class="py-4 rounded-xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition"
              >
                ← KEMBALI
              </button>


              <button
                type="button"
                @click="cekData"
                :disabled="loading || !inputKode.trim()"
                class="py-4 rounded-xl font-bold text-white bg-linear-to-r from-emerald-600 to-blue-600 hover:from-emerald-700 hover:to-blue-700 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
              >

                <span v-if="loading">
                  MENCARI DATA...
                </span>

                <span v-else>
                  🔎 CEK DATA
                </span>

              </button>

            </div>

          </div>


          <!-- ========================= -->
          <!-- DATA NON-MEMBER -->
          <!-- ========================= -->

          <div v-if="jenisData === 'non-member'">

            <!-- LABEL -->
            <div
              class="mb-5 flex items-center justify-between bg-blue-50 border border-blue-200 rounded-2xl px-4 py-3"
            >

              <div>

                <p class="text-xs text-blue-500 font-semibold uppercase">
                  Jenis Pengunjung
                </p>

                <p class="text-lg font-bold text-blue-700">
                  NON-MEMBER
                </p>

              </div>

              <div class="text-3xl">
                🎫
              </div>

            </div>


            <!-- DETAIL TIKET -->
            <div
              v-if="tiket"
              class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6"
            >

              <h2 class="font-bold text-slate-800 mb-4">
                Detail Tiket
              </h2>

              <div class="grid grid-cols-2 gap-4">

                <div>

                  <p class="text-xs text-slate-500">
                    Kode Tiket
                  </p>

                  <p class="font-bold text-lg text-emerald-600">
                    {{ tiket.kode_tiket || '-' }}
                  </p>

                </div>


                <div>

                  <p class="text-xs text-slate-500">
                    Status
                  </p>

                  <p class="font-semibold text-slate-700">
                    {{ tiket.status || '-' }}
                  </p>

                </div>


                <div>

                  <p class="text-xs text-slate-500">
                    Waktu Masuk
                  </p>

                  <p class="font-semibold text-slate-700">
                    {{ formatTanggal(tiket.waktu_masuk) }}
                  </p>

                </div>


                <div>

                  <p class="text-xs text-slate-500">
                    Durasi
                  </p>

                  <p class="font-semibold text-slate-700">
                    {{ durasi }} jam
                  </p>

                </div>

              </div>

            </div>


            <!-- JENIS KENDARAAN -->
            <div class="mb-6">

              <label class="block text-sm font-bold text-slate-700 mb-3">
                Jenis Kendaraan
              </label>

              <div class="grid grid-cols-2 gap-4">

                <button
                  type="button"
                  @click="jenisKendaraan = 'Motor'"
                  class="rounded-2xl border-2 p-5 transition duration-200"
                  :class="
                    jenisKendaraan === 'Motor'
                      ? 'border-emerald-500 bg-emerald-50 shadow-md'
                      : 'border-slate-200 bg-white hover:border-emerald-300'
                  "
                >

                  <div class="text-4xl mb-2">
                    🏍️
                  </div>

                  <p
                    class="font-bold"
                    :class="
                      jenisKendaraan === 'Motor'
                        ? 'text-emerald-700'
                        : 'text-slate-700'
                    "
                  >
                    MOTOR
                  </p>

                  <p class="text-xs text-slate-500 mt-1">
                    Rp3.000 / jam
                  </p>

                </button>


                <button
                  type="button"
                  @click="jenisKendaraan = 'Mobil'"
                  class="rounded-2xl border-2 p-5 transition duration-200"
                  :class="
                    jenisKendaraan === 'Mobil'
                      ? 'border-blue-500 bg-blue-50 shadow-md'
                      : 'border-slate-200 bg-white hover:border-blue-300'
                  "
                >

                  <div class="text-4xl mb-2">
                    🚗
                  </div>

                  <p
                    class="font-bold"
                    :class="
                      jenisKendaraan === 'Mobil'
                        ? 'text-blue-700'
                        : 'text-slate-700'
                    "
                  >
                    MOBIL
                  </p>

                  <p class="text-xs text-slate-500 mt-1">
                    Rp5.000 / jam
                  </p>

                </button>

              </div>

            </div>


            <!-- NOMOR POLISI -->
            <div class="mb-6">

              <label class="block text-sm font-bold text-slate-700 mb-3">
                Nomor Polisi
              </label>

              <input
                v-model="noPolisi"
                type="text"
                autocomplete="off"
                placeholder="Contoh: B 1234 ABC"
                class="w-full px-4 py-4 rounded-xl border-2 border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none uppercase font-semibold"
                @input="noPolisi = noPolisi.toUpperCase()"
              />

            </div>


            <!-- RINGKASAN HARGA -->
            <div
              class="bg-linear-to-r from-emerald-50 to-blue-50 border border-emerald-200 rounded-2xl p-5 mb-6"
            >

              <div class="flex justify-between mb-2">

                <span class="text-slate-600">
                  Jenis Kendaraan
                </span>

                <span class="font-semibold text-slate-800">
                  {{ jenisKendaraan || '-' }}
                </span>

              </div>


              <div class="flex justify-between mb-2">

                <span class="text-slate-600">
                  Durasi Parkir
                </span>

                <span class="font-semibold text-slate-800">
                  {{ durasi }} jam
                </span>

              </div>


              <div class="flex justify-between mb-3">

                <span class="text-slate-600">
                  Tarif / Jam
                </span>

                <span class="font-semibold text-slate-800">
                  {{ formatRupiah(hargaPerJam) }}
                </span>

              </div>


              <div class="border-t border-slate-200 pt-3 flex justify-between">

                <span class="font-bold text-slate-700">
                  TOTAL PARKIR
                </span>

                <span class="text-2xl font-bold text-emerald-700">
                  {{ formatRupiah(totalHarga) }}
                </span>

              </div>

            </div>


            <!-- TOMBOL -->
            <div class="grid grid-cols-2 gap-3">

              <button
                type="button"
                @click="resetForm"
                class="py-4 rounded-xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition"
              >
                ← KEMBALI
              </button>


              <button
                type="button"
                @click="lanjutPembayaran"
                :disabled="!jenisKendaraan || !noPolisi.trim()"
                class="py-4 rounded-xl text-white font-bold bg-linear-to-r from-emerald-600 to-blue-600 hover:from-emerald-700 hover:to-blue-700 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
              >
                💳 PEMBAYARAN
              </button>

            </div>

          </div>


          <!-- ========================= -->
          <!-- DATA MEMBER -->
          <!-- ========================= -->

          <div v-if="jenisData === 'member'">

            <!-- LABEL -->
            <div
              class="mb-5 flex items-center justify-between bg-emerald-50 border border-emerald-200 rounded-2xl px-4 py-3"
            >

              <div>

                <p class="text-xs text-emerald-500 font-semibold uppercase">
                  Jenis Pengunjung
                </p>

                <p class="text-lg font-bold text-emerald-700">
                  MEMBER
                </p>

              </div>

              <div class="text-3xl">
                👤
              </div>

            </div>


            <!-- DATA MEMBER -->
            <div
              v-if="member"
              class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6"
            >

              <h2 class="font-bold text-slate-800 mb-4">
                Data Member
              </h2>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>

                  <p class="text-xs text-slate-500">
                    Kode Member
                  </p>

                  <p class="font-bold text-lg text-emerald-600">
                    {{ member.kode_member || '-' }}
                  </p>

                </div>


                <div>

                  <p class="text-xs text-slate-500">
                    Nama Member
                  </p>

                  <p class="font-semibold text-slate-700">
                    {{ member.nama_member || '-' }}
                  </p>

                </div>


                <div>

                  <p class="text-xs text-slate-500">
                    Perusahaan
                  </p>

                  <p class="font-semibold text-slate-700">
                    {{ member.nama_perusahaan || '-' }}
                  </p>

                </div>


                <div>

                  <p class="text-xs text-slate-500">
                    Status
                  </p>

                  <span
                    class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-sm font-bold"
                  >
                    LUNAS
                  </span>

                </div>

              </div>

            </div>


            <!-- JENIS KENDARAAN MEMBER -->
            <div class="mb-6">

              <label class="block text-sm font-bold text-slate-700 mb-3">
                Jenis Kendaraan
              </label>

              <div class="grid grid-cols-2 gap-4">

                <button
                  type="button"
                  @click="jenisKendaraan = 'Motor'"
                  class="rounded-2xl border-2 p-5 transition duration-200"
                  :class="
                    jenisKendaraan === 'Motor'
                      ? 'border-emerald-500 bg-emerald-50 shadow-md'
                      : 'border-slate-200 bg-white hover:border-emerald-300'
                  "
                >

                  <div class="text-4xl mb-2">
                    🏍️
                  </div>

                  <p
                    class="font-bold"
                    :class="
                      jenisKendaraan === 'Motor'
                        ? 'text-emerald-700'
                        : 'text-slate-700'
                    "
                  >
                    MOTOR
                  </p>

                  <p class="text-xs text-slate-500 mt-1">
                    Kendaraan Member
                  </p>

                </button>


                <button
                  type="button"
                  @click="jenisKendaraan = 'Mobil'"
                  class="rounded-2xl border-2 p-5 transition duration-200"
                  :class="
                    jenisKendaraan === 'Mobil'
                      ? 'border-blue-500 bg-blue-50 shadow-md'
                      : 'border-slate-200 bg-white hover:border-blue-300'
                  "
                >

                  <div class="text-4xl mb-2">
                    🚗
                  </div>

                  <p
                    class="font-bold"
                    :class="
                      jenisKendaraan === 'Mobil'
                        ? 'text-blue-700'
                        : 'text-slate-700'
                    "
                  >
                    MOBIL
                  </p>

                  <p class="text-xs text-slate-500 mt-1">
                    Kendaraan Member
                  </p>

                </button>

              </div>

            </div>


            <!-- NOMOR POLISI MEMBER -->
            <div class="mb-6">

              <label class="block text-sm font-bold text-slate-700 mb-3">
                Nomor Polisi
              </label>

              <input
                v-model="noPolisi"
                type="text"
                autocomplete="off"
                placeholder="Contoh: B 1234 ABC"
                class="w-full px-4 py-4 rounded-xl border-2 border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 outline-none uppercase font-semibold"
                @input="noPolisi = noPolisi.toUpperCase()"
              />

            </div>


            <!-- INFO MEMBER -->
            <div
              class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6"
            >

              <div class="flex items-center gap-4">

                <div
                  class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-2xl"
                >
                  ✅
                </div>

                <div>

                  <p class="font-bold text-emerald-700">
                    Member Aktif
                  </p>

                  <p class="text-sm text-emerald-600 mt-1">
                    Member tidak dikenakan pembayaran parkir per transaksi.
                  </p>

                </div>

              </div>

            </div>


            <!-- TOMBOL MEMBER -->
            <div class="grid grid-cols-2 gap-3">

              <button
                type="button"
                @click="resetForm"
                class="py-4 rounded-xl border-2 border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition"
              >
                ← KEMBALI
              </button>


              <button
                type="button"
                @click="memberKeluar"
                :disabled="
                  memberExitLoading ||
                  !jenisKendaraan ||
                  !noPolisi.trim()
                "
                class="py-4 rounded-xl text-white font-bold bg-linear-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
              >

                <span v-if="memberExitLoading">
                  MEMPROSES...
                </span>

                <span v-else>
                  ✅ KONFIRMASI KELUAR
                </span>

              </button>

            </div>

          </div>


          <!-- ========================= -->
          <!-- BERHASIL MEMBER -->
          <!-- ========================= -->

          <div
            v-if="memberKeluarBerhasil"
            class="text-center py-8"
          >

            <div
              class="w-20 h-20 mx-auto rounded-full bg-emerald-100 flex items-center justify-center text-4xl mb-5"
            >
              ✅
            </div>

            <h2 class="text-2xl font-bold text-emerald-700">
              Member Berhasil Keluar
            </h2>

            <p class="text-slate-500 mt-2">
              Data kendaraan sudah tercatat.
            </p>


            <!-- ========================= -->
            <!-- INVOICE MEMBER -->
            <!-- ========================= -->

            <div
              class="invoice-member mt-6 bg-white border-2 border-slate-200 rounded-2xl overflow-hidden text-left shadow-sm"
            >

              <div class="bg-slate-800 px-5 py-4 text-white">
                <p class="text-xs tracking-widest text-slate-300">
                  PARKIR PLAZA ANDALAS
                </p>

                <h3 class="text-xl font-bold mt-1">
                  INVOICE MEMBER
                </h3>
              </div>


              <div class="p-5">

                <div class="flex justify-between border-b border-slate-100 pb-4 mb-4">
                  <div>
                    <p class="text-xs text-slate-400">
                      Kode Member
                    </p>

                    <p class="font-bold text-emerald-600 text-lg">
                      {{ memberKeluarData?.kode_member || member?.kode_member || '-' }}
                    </p>
                  </div>

                  <div class="text-right">
                    <p class="text-xs text-slate-400">
                      Status
                    </p>

                    <span class="inline-flex mt-1 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                      SELESAI
                    </span>
                  </div>
                </div>


                <div class="space-y-3">

                  <div class="flex justify-between gap-4">
                    <span class="text-slate-500">
                      Nama Member
                    </span>

                    <span class="font-semibold text-slate-800 text-right">
                      {{ memberKeluarData?.nama_member || member?.nama_member || '-' }}
                    </span>
                  </div>


                  <div class="flex justify-between gap-4">
                    <span class="text-slate-500">
                      Perusahaan
                    </span>

                    <span class="font-semibold text-slate-800 text-right">
                      {{ memberKeluarData?.nama_perusahaan || member?.nama_perusahaan || '-' }}
                    </span>
                  </div>


                  <div class="flex justify-between gap-4">
                    <span class="text-slate-500">
                      Jenis Kendaraan
                    </span>

                    <span class="font-semibold text-slate-800">
                      {{ memberKeluarData?.jenis_kendaraan || jenisKendaraan || '-' }}
                    </span>
                  </div>


                  <div class="flex justify-between gap-4">
                    <span class="text-slate-500">
                      Nomor Polisi
                    </span>

                    <span class="font-semibold text-slate-800">
                      {{ memberKeluarData?.no_polisi || noPolisi || '-' }}
                    </span>
                  </div>


                  <div class="flex justify-between gap-4">
                    <span class="text-slate-500">
                      Waktu Keluar
                    </span>

                    <span class="font-semibold text-slate-800 text-right">
                      {{ formatTanggal(memberKeluarData?.waktu_keluar || new Date().toISOString()) }}
                    </span>
                  </div>

                </div>


                <div class="mt-5 pt-4 border-t-2 border-dashed border-slate-200">
                  <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-700">
                      TOTAL PARKIR
                    </span>

                    <span class="text-xl font-bold text-emerald-600">
                      GRATIS / MEMBER
                    </span>
                  </div>
                </div>

              </div>

            </div>


            <div class="no-print mt-4 grid grid-cols-2 gap-3">

              <button
                type="button"
                @click="cetakInvoice"
                class="py-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold shadow-lg transition"
              >
                🖨️ CETAK PDF
              </button>


              <button
                type="button"
                @click="kembaliDashboard"
                class="py-4 rounded-xl bg-linear-to-r from-emerald-600 to-blue-600 text-white font-bold shadow-lg"
              >
                KEMBALI KE DASHBOARD
              </button>

            </div>

          </div>

        </div>

      </div>

    </div>
  </div>
</template>

<script setup lang="ts">

const { $api } = useNuxtApp()
const router = useRouter()

// ======================================================
// STATE
// ======================================================

const inputKode = ref("")
const inputRef = ref<HTMLInputElement | null>(null)
const loading = ref(false)

const jenisData = ref<"member" | "non-member" | "">("")

const pesan = ref("")
const berhasil = ref(false)

const tiket = ref<any>(null)
const member = ref<any>(null)

const jenisKendaraan = ref<"Motor" | "Mobil" | "">("")

const noPolisi = ref("")

const memberExitLoading = ref(false)
const memberKeluarBerhasil = ref(false)
const memberKeluarData = ref<any>(null)


// ======================================================
// HARGA
// ======================================================

const hargaPerJam = computed(() => {
  if (jenisKendaraan.value === "Motor") {
    return 3000
  }

  if (jenisKendaraan.value === "Mobil") {
    return 5000
  }

  return 0
})


// ======================================================
// DURASI
// ======================================================

const durasi = computed(() => {
  if (!tiket.value?.waktu_masuk) {
    return 0
  }

  const masuk =
    parseTanggalLaravel(
      tiket.value.waktu_masuk
    )

  if (!masuk) {
    return 0
  }

  const sekarang = new Date()

  const selisih =
    sekarang.getTime() -
    masuk.getTime()

  if (selisih <= 0) {
    return 1
  }

  return Math.max(
    1,
    Math.ceil(
      selisih /
      (1000 * 60 * 60)
    )
  )
})


// ======================================================
// TOTAL HARGA
// ======================================================

const totalHarga = computed(() => {
  return (
    durasi.value *
    hargaPerJam.value
  )
})


// ======================================================
// FORMAT RUPIAH
// ======================================================

const formatRupiah = (angka: number) => {
  return new Intl.NumberFormat(
    "id-ID",
    {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0
    }
  ).format(angka)
}


// ======================================================
// PARSE TANGGAL
// ======================================================

const parseTanggalLaravel = (
  value: any
) => {

  if (!value) {
    return null
  }

  const teks =
    String(value).trim()

  const cocok =
    teks.match(
      /^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/
    )

  if (cocok) {

    const tahun =
      Number(cocok[1])

    const bulan =
      Number(cocok[2])

    const hari =
      Number(cocok[3])

    const jam =
      Number(cocok[4])

    const menit =
      Number(cocok[5])

    const detik =
      Number(cocok[6] || 0)

    const tanggal =
      new Date(
        tahun,
        bulan - 1,
        hari,
        jam,
        menit,
        detik
      )

    if (
      isNaN(
        tanggal.getTime()
      )
    ) {
      return null
    }

    return tanggal
  }

  const tanggal =
    new Date(teks)

  if (
    isNaN(
      tanggal.getTime()
    )
  ) {
    return null
  }

  return tanggal
}


// ======================================================
// FORMAT TANGGAL
// ======================================================

const formatTanggal = (
  tanggal: string | null
) => {

  const date =
    parseTanggalLaravel(
      tanggal
    )

  if (!date) {
    return "-"
  }

  return date.toLocaleString(
    "id-ID",
    {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit"
    }
  )
}


// ======================================================
// BERSIHKAN INPUT SCANNER
// ======================================================

const bersihkanInputScanner = (
  nilai: string
) => {

  return String(
    nilai || ""
  )
    .replace(
      /[\r\n\t]+/g,
      " "
    )
    .replace(
      /\s+/g,
      " "
    )
    .trim()
}


// ======================================================
// DETEKSI KODE TIKET
// ======================================================

const isKodeTiket = (
  nilai: string
) => {

  return /^A\d{3}$/i.test(
    String(
      nilai || ""
    ).trim()
  )
}


// ======================================================
// DETEKSI KODE MEMBER
// ======================================================

const isKodeMember = (
  nilai: string
) => {

  return /^MBR-[A-Z0-9_-]+$/i.test(
    String(
      nilai || ""
    ).trim()
  )
}


// ======================================================
// AMBIL KODE TIKET DARI TEKS PANJANG
// ======================================================
//
// UUID seperti:
//
// 22f4acee-a637-41c0-aa00-3e686d87cd6f
//
// TIDAK boleh dianggap sebagai A637.
//
// Axxx hanya diambil jika:
// Kode Tiket : A028
// ======================================================

const ambilKodeTiketDariTeks = (
  nilai: string
) => {

  const teks =
    String(
      nilai || ""
    ).trim()

  // Kalau input memang langsung A028
  if (
    isKodeTiket(teks)
  ) {

    return teks.toUpperCase()
  }

  // Cari tulisan "Kode Tiket : A028"
  const hasilLabel =
    teks.match(
      /(?:kode\s*tiket|kode\s*ticket)\s*[:#-]?\s*(A\d{3})\b/i
    )

  // Aman untuk TypeScript
  if (
    hasilLabel &&
    hasilLabel.length > 1 &&
    hasilLabel[1]
  ) {

    return String(
      hasilLabel[1]
    ).toUpperCase()
  }

  // UUID / teks lain tidak dipotong
  return ""
}


// ======================================================
// FOCUS INPUT
// ======================================================

onMounted(() => {

  nextTick(() => {

    inputRef.value?.focus()

  })

})


// ======================================================
// CEK DATA
// ======================================================

const cekData =
  async () => {

    const inputMentah =
      bersihkanInputScanner(
        inputKode.value
      )

    if (!inputMentah) {

      pesan.value =
        "Silakan scan atau masukkan kode terlebih dahulu."

      berhasil.value =
        false

      return
    }


    console.log(
      "HASIL SCANNER MENTAH:",
      inputMentah
    )


    loading.value =
      true

    pesan.value =
      ""

    berhasil.value =
      false

    jenisData.value =
      ""

    tiket.value =
      null

    member.value =
      null

    jenisKendaraan.value =
      ""

    noPolisi.value =
      ""

    memberKeluarBerhasil.value =
      false

    memberKeluarData.value =
      null


    try {

      // ==================================================
      // 1. KODE TIKET NON-MEMBER
      //    Contoh: A001, A002, A003
      // ==================================================

      if (
        isKodeTiket(
          inputMentah
        )
      ) {

        console.log(
          "DETEKSI KODE TIKET NON-MEMBER:",
          inputMentah.toUpperCase()
        )


        try {

          const responseTiket =
            await $api.post(
              "/tiket/scan",
              {
                kode_tiket:
                  inputMentah.toUpperCase()
              }
            )


          console.log(
            "HASIL SCAN KODE TIKET:",
            responseTiket
          )


          const dataTiket =
            responseTiket?.data?.data ||
            responseTiket?.data?.tiket ||
            null


          if (
            dataTiket
          ) {

            tiket.value =
              dataTiket

            jenisData.value =
              "non-member"

            berhasil.value =
              true

            pesan.value =
              "Tiket non-member berhasil ditemukan. Silakan pilih jenis kendaraan dan masukkan nomor polisi."

            return
          }

        } catch (errorTiket: any) {

          console.error(
            "SCAN KODE TIKET ERROR:",
            errorTiket
          )

          pesan.value =
            errorTiket?.response?.data?.message ||
            "Tiket non-member tidak ditemukan."

          berhasil.value =
            false

          return
        }
      }


      // ==================================================
      // 2. QR CODE
      //
      // QR NON-MEMBER:
      // 4fd88716-becc-47cf-a3bf-7a0d5b9aa9dc
      //
      // QR MEMBER:
      // UUID juga.
      //
      // Jadi TIKET dicek dahulu.
      // Kalau bukan tiket, baru dicek member.
      // ==================================================

      console.log(
        "CEK QR TIKET TERLEBIH DAHULU:",
        inputMentah
      )


      try {

        const responseQrTiket =
          await $api.post(
            "/tiket/scan",
            {
              qr_code:
                inputMentah
            }
          )


        console.log(
          "HASIL SCAN QR TIKET:",
          responseQrTiket
        )


        const dataQrTiket =
          responseQrTiket?.data?.data ||
          responseQrTiket?.data?.tiket ||
          null


        if (
          dataQrTiket
        ) {

          tiket.value =
            dataQrTiket

          jenisData.value =
            "non-member"

          berhasil.value =
            true

          pesan.value =
            "Tiket non-member berhasil ditemukan. Silakan pilih jenis kendaraan dan masukkan nomor polisi."

          return
        }

      } catch (errorTiket: any) {

        const statusTiket =
          errorTiket?.response?.status


        /*
        |--------------------------------------------------------------------------
        | 404 = BUKAN TIKET
        | Maka lanjut cek member.
        |--------------------------------------------------------------------------
        */

        if (
          statusTiket !== 404
        ) {

          console.error(
            "SCAN QR TIKET ERROR:",
            errorTiket
          )

          pesan.value =
            errorTiket?.response?.data?.message ||
            "Tiket tidak dapat diproses."

          berhasil.value =
            false

          return
        }

        console.log(
          "QR BUKAN TIKET NON-MEMBER. LANJUT CEK MEMBER."
        )
      }


      // ==================================================
      // 3. CEK MEMBER
      //
      // Baru dijalankan kalau input tadi BUKAN tiket.
      // ==================================================

      console.log(
        "CEK MEMBER UNTUK KELUAR:",
        inputMentah
      )


      try {

        const responseMember =
          await $api.post(
            "/member-gate/cek-keluar",
            {
              token:
                inputMentah
            }
          )


        console.log(
          "HASIL CEK MEMBER:",
          responseMember
        )


        const dataMember =
          responseMember?.data?.member ||
          null


        const dataTiketMember =
          responseMember?.data?.data ||
          null


        if (
          dataMember &&
          dataTiketMember
        ) {

          member.value =
            dataMember

          tiket.value =
            dataTiketMember

          jenisData.value =
            "member"

          berhasil.value =
            true

          pesan.value =
            "Data member ditemukan. Silakan pilih kendaraan dan masukkan nomor polisi."

          return
        }


      } catch (errorMember: any) {

        const statusMember =
          errorMember?.response?.status


        const pesanServer =
          errorMember?.response?.data?.message ||
          ""


        /*
        |--------------------------------------------------------------------------
        | 400 / 403
        | Member ditemukan, tetapi tidak boleh keluar.
        |--------------------------------------------------------------------------
        */

        if (
          statusMember === 400 ||
          statusMember === 403
        ) {

          jenisData.value =
            ""

          tiket.value =
            null

          member.value =
            null

          berhasil.value =
            false

          pesan.value =
            pesanServer ||
            "Member tidak sedang berada di area parkir. Silakan masuk terlebih dahulu."

          return
        }


        /*
        |--------------------------------------------------------------------------
        | 404
        | Berarti bukan member juga.
        |--------------------------------------------------------------------------
        */

        if (
          statusMember === 404
        ) {

          console.log(
            "INPUT BUKAN MEMBER."
          )

        } else {

          console.error(
            "CEK MEMBER ERROR:",
            errorMember
          )

          pesan.value =
            pesanServer ||
            "Data tidak dapat diproses."

          berhasil.value =
            false

          return
        }
      }


      // ==================================================
      // 4. FALLBACK TEKS PANJANG
      //
      // Contoh:
      // "Kode Tiket : A028"
      // ==================================================

      const kodeDariTeks =
        ambilKodeTiketDariTeks(
          inputMentah
        )


      if (
        kodeDariTeks
      ) {

        console.log(
          "KODE TIKET DARI TEKS:",
          kodeDariTeks
        )


        try {

          const responseTiketKode =
            await $api.post(
              "/tiket/scan",
              {
                kode_tiket:
                  kodeDariTeks
              }
            )


          const dataTiketKode =
            responseTiketKode?.data?.data ||
            responseTiketKode?.data?.tiket ||
            null


          if (
            dataTiketKode
          ) {

            tiket.value =
              dataTiketKode

            jenisData.value =
              "non-member"

            berhasil.value =
              true

            pesan.value =
              "Tiket non-member berhasil ditemukan. Silakan pilih jenis kendaraan dan masukkan nomor polisi."

            return
          }

        } catch (errorKode: any) {

          console.error(
            "SCAN KODE TIKET DARI TEKS ERROR:",
            errorKode
          )

        }
      }


      // ==================================================
      // 5. TIDAK DITEMUKAN
      // ==================================================

      pesan.value =
        "Data member atau tiket tidak ditemukan."

      berhasil.value =
        false


    } catch (error: any) {

      console.error(
        "CEK DATA ERROR:",
        error
      )


      berhasil.value =
        false


      pesan.value =
        error?.response?.data?.message ||
        error?.message ||
        "Data member atau tiket tidak ditemukan."


    } finally {

      loading.value =
        false

    }

  }


// ======================================================
// LANJUT PEMBAYARAN
// ======================================================

const lanjutPembayaran =
  () => {

    if (!tiket.value) {

      pesan.value =
        "Data tiket belum ditemukan."

      berhasil.value =
        false

      return
    }


    if (
      !jenisKendaraan.value
    ) {

      pesan.value =
        "Silakan pilih Motor atau Mobil."

      berhasil.value =
        false

      return
    }


    if (
      !noPolisi.value.trim()
    ) {

      pesan.value =
        "Silakan masukkan nomor polisi."

      berhasil.value =
        false

      return
    }


    // ==================================================
    // DATA TRANSAKSI
    // ==================================================

    const dataTransaksi = {

      id:
        tiket.value.id,

      kode_tiket:
        tiket.value.kode_tiket || "",

      jenis_kendaraan:
        jenisKendaraan.value,

      no_polisi:
        noPolisi.value
          .trim()
          .toUpperCase(),

      waktu_masuk:
        tiket.value.waktu_masuk || "",

      waktu_keluar:
        tiket.value.waktu_keluar || "",

      durasi:
        durasi.value,

      harga_per_jam:
        hargaPerJam.value,

      total_harga:
        totalHarga.value,

      status:
        tiket.value.status || "masuk"

    }


    // ==================================================
    // PINDAH KE PAYMENT
    // ==================================================

    router.replace({

      path:
        "/petugas/transaksi/payment",

      query: {

        data:
          JSON.stringify(
            dataTransaksi
          )

      }

    })

  }

// ======================================================
// MEMBER KELUAR
// ======================================================

const memberKeluar =
  async () => {

    if (!member.value) {

      pesan.value =
        "Data member belum ditemukan."

      berhasil.value =
        false

      return
    }

    if (!jenisKendaraan.value) {

      pesan.value =
        "Silakan pilih jenis kendaraan terlebih dahulu."

      berhasil.value =
        false

      return
    }

    if (!noPolisi.value.trim()) {

      pesan.value =
        "Silakan masukkan nomor polisi."

      berhasil.value =
        false

      return
    }

    memberExitLoading.value =
      true

    pesan.value =
      ""

    berhasil.value =
      false

    try {

      // Gunakan token member asli dari data hasil /member/check.
      // Ini membuat Kode Member dan QR UUID sama-sama bisa keluar.
      const tokenKeluar =
        String(
          member.value?.token ||
          member.value?.kode_member ||
          inputKode.value ||
          ""
        ).trim()

      if (!tokenKeluar) {

        pesan.value =
          "Token atau kode member tidak ditemukan."

        berhasil.value =
          false

        return
      }

      console.log(
        "TOKEN MEMBER UNTUK KELUAR:",
        tokenKeluar
      )

      const response =
        await $api.post(
          "/member-gate/keluar",
          {
            token:
              tokenKeluar,

            jenis_kendaraan:
              jenisKendaraan.value,

            no_polisi:
              noPolisi.value
                .trim()
                .toUpperCase()
          }
        )

      console.log(
        "HASIL MEMBER KELUAR:",
        response
      )

      memberKeluarData.value =
        response?.data?.data ||
        response?.data?.member ||
        null

      memberKeluarBerhasil.value =
        true

      berhasil.value =
        true

      pesan.value =
        "Member berhasil melakukan transaksi keluar."

    } catch (error: any) {

      console.error(
        "MEMBER KELUAR ERROR:",
        error
      )

      berhasil.value =
        false

      pesan.value =
        error?.response?.data?.message ||
        "Gagal memproses member keluar."

    } finally {

      memberExitLoading.value =
        false
    }

  }


// ======================================================
// CETAK INVOICE MEMBER
// ======================================================

const cetakInvoice = () => {
  window.print()
}


// ======================================================
// RESET
// ======================================================

const resetForm =
  () => {

    inputKode.value =
      ""

    jenisData.value =
      ""

    pesan.value =
      ""

    berhasil.value =
      false

    tiket.value =
      null

    member.value =
      null

    jenisKendaraan.value =
      ""

    noPolisi.value =
      ""

    memberKeluarBerhasil.value =
      false

    memberKeluarData.value =
      null

    nextTick(() => {

      inputRef.value?.focus()

    })

  }


// ======================================================
// DASHBOARD
// ======================================================

const kembaliDashboard =
  () => {

    router.replace(
      "/petugas"
    )
  }

</script>
<style>
@media print {
  @page {
    size: A4;
    margin: 12mm;
  }

  body {
    background: white !important;
  }

  body * {
    visibility: hidden !important;
  }

  .invoice-member,
  .invoice-member * {
    visibility: visible !important;
  }

  .invoice-member {
    position: absolute !important;
    left: 0 !important;
    top: 0 !important;
    width: 100% !important;
    margin: 0 !important;
    box-shadow: none !important;
    border: 1px solid #cbd5e1 !important;
  }

  .no-print {
    display: none !important;
  }
}
</style>
