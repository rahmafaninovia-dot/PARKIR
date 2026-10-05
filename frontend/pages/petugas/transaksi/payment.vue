<template>
  <div class="min-h-screen bg-linear-to-br from-green-50 to-blue-100 p-5 md:p-10">

    <!-- HEADER -->
    <div class="max-w-3xl mx-auto mb-6">
      <button
        @click="kembali"
        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl font-semibold mb-5"
      >
        ← Kembali
      </button>

      <h1 class="text-3xl font-bold text-green-700">
        Payment Parkir
      </h1>

      <p class="text-gray-600 mt-1">
        Pembayaran parkir khusus kendaraan non-member
      </p>
    </div>


    <!-- CARD -->
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl p-6 md:p-8">

      <!-- JUDUL -->
      <div class="border-b pb-5 mb-6">
        <h2 class="text-xl font-bold text-gray-800">
          Detail Transaksi
        </h2>

        <p class="text-sm text-gray-500">
          Periksa data kendaraan sebelum melakukan pembayaran.
        </p>
      </div>


      <!-- DATA TIKET -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        <div class="bg-gray-50 rounded-xl p-4">
          <p class="text-sm text-gray-500">
            Kode Tiket
          </p>

          <p class="font-bold text-lg text-gray-800">
            {{ tiket.kode_tiket || "-" }}
          </p>
        </div>


        <div class="bg-gray-50 rounded-xl p-4">
          <p class="text-sm text-gray-500">
            Jenis Kendaraan
          </p>

          <p class="font-bold text-lg text-gray-800">
            {{ tiket.jenis_kendaraan || "-" }}
          </p>
        </div>


        <div class="bg-gray-50 rounded-xl p-4">
          <p class="text-sm text-gray-500">
            Nomor Polisi
          </p>

          <p class="font-bold text-lg text-gray-800">
            {{ tiket.no_polisi || "-" }}
          </p>
        </div>


        <div class="bg-gray-50 rounded-xl p-4">
          <p class="text-sm text-gray-500">
            Waktu Masuk
          </p>

          <p class="font-bold text-lg text-gray-800">
            {{ formatTanggal(tiket.waktu_masuk) }}
          </p>
        </div>


        <div class="bg-blue-50 rounded-xl p-4">
          <p class="text-sm text-blue-600">
            Durasi Parkir
          </p>

          <p class="font-bold text-xl text-blue-700">
            {{ tiket.durasi || 1 }} Jam
          </p>
        </div>


        <div class="bg-green-50 rounded-xl p-4">
          <p class="text-sm text-green-600">
            Harga Per Jam
          </p>

          <p class="font-bold text-xl text-green-700">
            {{ formatRupiah(tiket.harga_per_jam) }}
          </p>
        </div>

      </div>


      <!-- TOTAL -->
      <div class="bg-green-600 text-white rounded-2xl p-6 mb-6">

        <p class="text-sm opacity-90">
          Total yang harus dibayar
        </p>

        <p class="text-4xl font-bold mt-1">
          {{ formatRupiah(tiket.total_harga) }}
        </p>

      </div>


      <!-- UANG BAYAR -->
      <div class="mb-5">

        <label class="block font-semibold text-gray-700 mb-2">
          Uang Bayar
        </label>

        <input
          v-model.number="uangBayar"
          type="number"
          min="0"
          placeholder="Masukkan uang pembayaran"
          class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 text-lg focus:outline-none focus:border-green-500"
        />

      </div>


      <!-- KEMBALIAN -->
      <div
        v-if="uangBayar > 0"
        class="rounded-xl p-4 mb-5"
        :class="
          uangBayar >= totalHarga
            ? 'bg-blue-50 border border-blue-200'
            : 'bg-red-50 border border-red-200'
        "
      >

        <div class="flex justify-between items-center">

          <span
            class="font-semibold"
            :class="
              uangBayar >= totalHarga
                ? 'text-blue-700'
                : 'text-red-700'
            "
          >
            {{ uangBayar >= totalHarga ? "Kembalian" : "Kekurangan" }}
          </span>


          <span
            class="text-xl font-bold"
            :class="
              uangBayar >= totalHarga
                ? 'text-blue-700'
                : 'text-red-700'
            "
          >
            {{ formatRupiah(Math.abs(uangBayar - totalHarga)) }}
          </span>

        </div>

      </div>


      <!-- PESAN -->
      <div
        v-if="pesan"
        class="mb-5 p-4 rounded-xl"
        :class="
          berhasil
            ? 'bg-green-100 text-green-700'
            : 'bg-red-100 text-red-700'
        "
      >
        {{ pesan }}
      </div>


      <!-- BUTTON -->
      <div class="flex flex-col md:flex-row gap-3">

        <button
          @click="kembali"
          class="w-full md:w-1/3 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-xl font-bold"
          :disabled="loading"
        >
          BATAL
        </button>


        <button
          @click="bayar"
          :disabled="loading || uangBayar < totalHarga || totalHarga <= 0"
          class="w-full md:w-2/3 py-3 rounded-xl font-bold text-white transition"
          :class="
            loading || uangBayar < totalHarga || totalHarga <= 0
              ? 'bg-gray-400 cursor-not-allowed'
              : 'bg-green-600 hover:bg-green-700'
          "
        >
          {{ loading ? "MEMPROSES..." : "💳 BAYAR & KELUAR" }}
        </button>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- MODAL INVOICE -->
    <!-- ===================================================== -->

    <div
      v-if="showInvoice"
      class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4"
    >

      <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- HEADER INVOICE -->
        <div class="bg-green-600 text-white p-5">

          <p class="text-xs font-semibold tracking-widest">
            PARKIR PLAZA ANDALAS
          </p>

          <h2 class="text-2xl font-bold mt-1">
            Invoice Pembayaran
          </h2>

          <p class="text-sm text-green-100 mt-1">
            Pembayaran berhasil
          </p>

        </div>


        <!-- ISI INVOICE -->
        <div class="p-6">

          <div class="space-y-3 text-sm">

            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Kode Tiket
              </span>

              <span class="font-bold text-gray-800">
                {{ invoice.kode_tiket || "-" }}
              </span>
            </div>


            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Jenis Kendaraan
              </span>

              <span class="font-semibold text-gray-800">
                {{ invoice.jenis_kendaraan || "-" }}
              </span>
            </div>


            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Nomor Polisi
              </span>

              <span class="font-semibold text-gray-800">
                {{ invoice.no_polisi || "-" }}
              </span>
            </div>


            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Waktu Masuk
              </span>

              <span class="font-semibold text-gray-800 text-right">
                {{ formatTanggal(invoice.waktu_masuk) }}
              </span>
            </div>


            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Waktu Keluar
              </span>

              <span class="font-semibold text-gray-800 text-right">
                {{ formatTanggal(invoice.waktu_keluar) }}
              </span>
            </div>


            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Durasi Parkir
              </span>

              <span class="font-semibold text-gray-800">
                {{ invoice.durasi || 1 }} Jam
              </span>
            </div>


            <div class="flex justify-between gap-4">
              <span class="text-gray-500">
                Harga Per Jam
              </span>

              <span class="font-semibold text-gray-800">
                {{ formatRupiah(invoice.harga_per_jam) }}
              </span>
            </div>

          </div>


          <!-- RINCIAN PEMBAYARAN -->
          <div class="border-t mt-5 pt-5 space-y-3">

            <div class="flex justify-between">
              <span class="font-semibold text-gray-600">
                Total
              </span>

              <span class="font-bold text-green-700">
                {{ formatRupiah(invoice.total_harga) }}
              </span>
            </div>


            <div class="flex justify-between">
              <span class="font-semibold text-gray-600">
                Uang Bayar
              </span>

              <span class="font-semibold text-gray-800">
                {{ formatRupiah(invoice.uang_bayar) }}
              </span>
            </div>


            <div class="flex justify-between">
              <span class="font-bold text-gray-700">
                Kembalian
              </span>

              <span class="font-bold text-blue-700">
                {{ formatRupiah(invoice.kembalian) }}
              </span>
            </div>

          </div>


          <!-- STATUS -->
          <div class="bg-green-50 border border-green-200 rounded-xl p-4 mt-5 text-center">

            <p class="font-bold text-green-700">
              PEMBAYARAN LUNAS
            </p>

            <p class="text-xs text-green-600 mt-1">
              Simpan invoice ini sebagai bukti pembayaran.
            </p>

          </div>


          <!-- BUTTON INVOICE -->
          <div class="grid grid-cols-2 gap-3 mt-5">

            <button
              type="button"
              @click="tutupInvoice"
              class="py-3 rounded-xl border-2 border-gray-200 text-gray-600 font-bold hover:bg-gray-50"
            >
              TUTUP
            </button>


            <button
              type="button"
              @click="cetakInvoice"
              :disabled="invoiceLoading"
              class="py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-bold disabled:bg-gray-400"
            >
              {{ invoiceLoading ? "MEMPROSES..." : "🖨 CETAK INVOICE" }}
            </button>

          </div>


          <button
            type="button"
            @click="kembaliTransaksi"
            class="w-full mt-3 py-3 rounded-xl bg-gray-800 hover:bg-gray-900 text-white font-bold"
          >
            KEMBALI KE TRANSAKSI
          </button>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import jsPDF from "jspdf"


const router = useRouter()

const route = useRoute()

const { $api } = useNuxtApp()


/*
|--------------------------------------------------------------------------
| DATA
|--------------------------------------------------------------------------
*/

const tiket = ref<any>({
  id: null,
  kode_tiket: "",
  jenis_kendaraan: "",
  no_polisi: "",
  waktu_masuk: "",
  waktu_keluar: "",
  durasi: 1,
  harga_per_jam: 0,
  total_harga: 0,
  status: "masuk"
})


const uangBayar = ref<number>(0)

const loading = ref(false)

const pesan = ref("")

const berhasil = ref(false)


/*
|--------------------------------------------------------------------------
| DATA INVOICE
|--------------------------------------------------------------------------
*/

const showInvoice = ref(false)

const invoiceLoading = ref(false)

const invoice = ref<any>({})


/*
|--------------------------------------------------------------------------
| TOTAL HARGA
|--------------------------------------------------------------------------
*/

const totalHarga = computed(() => {

  return Number(
    tiket.value.total_harga || 0
  )

})


/*
|--------------------------------------------------------------------------
| AMBIL DATA DARI QUERY
|--------------------------------------------------------------------------
*/

onMounted(() => {

  const data = route.query.data

  if (!data) {

    pesan.value =
      "Data transaksi tidak ditemukan."

    berhasil.value = false

    return

  }

  try {

    const hasil =
      JSON.parse(String(data))

    tiket.value = {

      ...tiket.value,

      ...hasil

    }

  } catch (error) {

    console.error(error)

    pesan.value =
      "Data transaksi tidak dapat dibaca."

    berhasil.value = false

  }

})


/*
|--------------------------------------------------------------------------
| FORMAT RUPIAH
|--------------------------------------------------------------------------
*/

function formatRupiah(
  angka: number
) {

  return (
    "Rp " +
    Number(
      angka || 0
    ).toLocaleString("id-ID")
  )

}


/*
|--------------------------------------------------------------------------
| FORMAT TANGGAL
|--------------------------------------------------------------------------
*/

function formatTanggal(
  tanggal: string
) {

  if (!tanggal) {

    return "-"

  }

  const date =
    new Date(tanggal)

  if (
    isNaN(
      date.getTime()
    )
  ) {

    return tanggal

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


/*
|--------------------------------------------------------------------------
| KEMBALI
|--------------------------------------------------------------------------
*/

function kembali() {

  router.back()

}


/*
|--------------------------------------------------------------------------
| BAYAR
|--------------------------------------------------------------------------
*/

async function bayar() {

  pesan.value = ""

  berhasil.value = false


  if (!tiket.value.id) {

    pesan.value =
      "Data tiket tidak ditemukan."

    return

  }


  if (uangBayar.value <= 0) {

    pesan.value =
      "Masukkan uang pembayaran terlebih dahulu."

    return

  }


  if (
    uangBayar.value <
    totalHarga.value
  ) {

    pesan.value =
      "Uang pembayaran masih kurang."

    return

  }


  loading.value = true


  try {

    /*
    |--------------------------------------------------------------------------
    | PROSES TIKET KELUAR
    |--------------------------------------------------------------------------
    */
const response = await $api.put(
  `/tiket/${tiket.value.id}/keluar`,
  {
    jenis_kendaraan:
      tiket.value.jenis_kendaraan,

    no_polisi:
      tiket.value.no_polisi
  }
)


    if (
      response.data?.success
    ) {

      berhasil.value = true


      pesan.value =
        "Pembayaran berhasil. Tiket telah digunakan dan kendaraan dapat keluar."


      tiket.value = {

        ...tiket.value,

        ...(
          response.data?.data ||
          {}
        )

      }


      tiket.value.status =
        "keluar"


      /*
      |--------------------------------------------------------------------------
      | DATA INVOICE
      |--------------------------------------------------------------------------
      */

      invoice.value = {

        ...tiket.value,

        uang_bayar:
          uangBayar.value,

        kembalian:
          Math.max(
            0,
            uangBayar.value -
            Number(
              tiket.value.total_harga || 0
            )
          )

      }


      /*
      |--------------------------------------------------------------------------
      | TAMPILKAN INVOICE
      |--------------------------------------------------------------------------
      */

      showInvoice.value =
        true


    } else {

      pesan.value =
        response.data?.message ||
        "Pembayaran gagal."

    }


  } catch (error: any) {

    console.error(error)

    pesan.value =
      error?.response?.data?.message ||
      "Terjadi kesalahan saat memproses pembayaran."

    berhasil.value = false


  } finally {

    loading.value = false

  }

}


/*
|--------------------------------------------------------------------------
| TUTUP INVOICE
|--------------------------------------------------------------------------
*/

function tutupInvoice() {

  showInvoice.value =
    false

}


/*
|--------------------------------------------------------------------------
| KEMBALI KE TRANSAKSI
|--------------------------------------------------------------------------
*/

function kembaliTransaksi() {

  showInvoice.value =
    false

  router.push(
    "/petugas/transaksi"
  )

}


/*
|--------------------------------------------------------------------------
| CETAK INVOICE PDF
|--------------------------------------------------------------------------
*/

async function cetakInvoice() {

  if (
    !invoice.value ||
    invoiceLoading.value
  ) {

    return

  }


  invoiceLoading.value =
    true


  try {

    const data =
      invoice.value


    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    const pdf =
      new jsPDF({

        orientation:
          "portrait",

        unit:
          "mm",

        format:
          [80, 160]

      })


    let y = 10


    /*
    |--------------------------------------------------------------------------
    | HEADER
    |--------------------------------------------------------------------------
    */

    pdf.setFont(
      "helvetica",
      "bold"
    )

    pdf.setFontSize(13)


    pdf.text(
      "PARKIR PLAZA ANDALAS",
      40,
      y,
      {
        align: "center"
      }
    )


    y += 7


    pdf.setFontSize(10)


    pdf.text(
      "INVOICE PEMBAYARAN",
      40,
      y,
      {
        align: "center"
      }
    )


    y += 6


    pdf.line(
      7,
      y,
      73,
      y
    )


    y += 7


    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    pdf.setFont(
      "helvetica",
      "normal"
    )

    pdf.setFontSize(8.5)


    pdf.text(
      `Kode Tiket : ${data.kode_tiket || "-"}`,
      7,
      y
    )


    y += 6


    pdf.text(
      `Kendaraan : ${data.jenis_kendaraan || "-"}`,
      7,
      y
    )


    y += 6


    pdf.text(
      `No. Polisi : ${data.no_polisi || "-"}`,
      7,
      y
    )


    y += 6


    pdf.text(
      `Waktu Masuk : ${formatTanggal(data.waktu_masuk)}`,
      7,
      y
    )


    y += 6


    pdf.text(
      `Waktu Keluar : ${formatTanggal(data.waktu_keluar)}`,
      7,
      y
    )


    y += 6


    pdf.text(
      `Durasi : ${data.durasi || 1} Jam`,
      7,
      y
    )


    y += 6


    pdf.text(
      `Harga / Jam : ${formatRupiah(data.harga_per_jam || 0)}`,
      7,
      y
    )


    y += 7


    pdf.line(
      7,
      y,
      73,
      y
    )


    y += 7


    /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

    pdf.setFont(
      "helvetica",
      "bold"
    )


    pdf.text(
      "TOTAL",
      7,
      y
    )


    pdf.text(
      formatRupiah(
        data.total_harga || 0
      ),
      73,
      y,
      {
        align: "right"
      }
    )


    y += 6


    /*
    |--------------------------------------------------------------------------
    | UANG BAYAR
    |--------------------------------------------------------------------------
    */

    pdf.setFont(
      "helvetica",
      "normal"
    )


    pdf.text(
      "Uang Bayar",
      7,
      y
    )


    pdf.text(
      formatRupiah(
        data.uang_bayar || 0
      ),
      73,
      y,
      {
        align: "right"
      }
    )


    y += 6


    /*
    |--------------------------------------------------------------------------
    | KEMBALIAN
    |--------------------------------------------------------------------------
    */

    pdf.text(
      "Kembalian",
      7,
      y
    )


    pdf.text(
      formatRupiah(
        data.kembalian || 0
      ),
      73,
      y,
      {
        align: "right"
      }
    )


    y += 9


    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    pdf.setFont(
      "helvetica",
      "bold"
    )


    pdf.text(
      "PEMBAYARAN LUNAS",
      40,
      y,
      {
        align: "center"
      }
    )


    y += 6


    pdf.setFont(
      "helvetica",
      "normal"
    )

    pdf.setFontSize(7)


    pdf.text(
      "Simpan invoice ini sebagai bukti pembayaran.",
      40,
      y,
      {
        align: "center"
      }
    )


    /*
    |--------------------------------------------------------------------------
    | SIMPAN PDF
    |--------------------------------------------------------------------------
    */

    pdf.save(
      `Invoice-Parkir-${data.kode_tiket || "transaksi"}.pdf`
    )


  } catch (error) {

    console.error(
      "Gagal mencetak invoice:",
      error
    )

    pesan.value =
      "Invoice gagal dibuat. Silakan coba lagi."

    berhasil.value = false


  } finally {

    invoiceLoading.value =
      false

  }

}

</script>