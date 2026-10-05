<template>
  <div class="min-h-screen bg-slate-100 px-4 py-8 md:px-8">

    <div class="max-w-3xl mx-auto">

      <!-- HEADER -->
      <div class="mb-7 flex items-center gap-4">
        <div
          class="w-14 h-14 rounded-2xl bg-blue-600
                 flex items-center justify-center
                 shadow-lg shadow-blue-200"
        >
          <span class="text-2xl">👤</span>
        </div>

        <div>
          <p class="text-sm font-semibold text-blue-600">
            SISTEM PARKIR
          </p>

          <h1 class="text-3xl font-bold text-slate-800">
            Tambah Member
          </h1>

          <p class="text-sm text-slate-500 mt-1">
            Daftarkan member baru ke dalam sistem
          </p>
        </div>
      </div>


      <!-- CARD -->
      <div
        class="bg-white rounded-3xl shadow-xl
               border border-slate-200 overflow-hidden"
      >

        <!-- CARD HEADER -->
        <div class="bg-blue-600 px-6 py-6 md:px-8">
          <div class="flex items-center gap-3">

            <div
              class="w-10 h-10 rounded-xl bg-white/20
                     flex items-center justify-center"
            >
              <span>📝</span>
            </div>

            <div>
              <h2 class="text-lg font-bold text-white">
                Informasi Member
              </h2>

              <p class="text-sm text-blue-100">
                Lengkapi data member dengan benar
              </p>
            </div>

          </div>
        </div>


        <!-- FORM -->
        <div class="p-6 md:p-8">

          <!-- DATA MEMBER -->
          <div class="mb-8">

            <div class="flex items-center gap-2 mb-5">
              <div class="w-2 h-6 bg-blue-600 rounded-full"></div>

              <h3 class="font-bold text-slate-800">
                Data Member
              </h3>
            </div>


            <!-- NAMA MEMBER -->
            <div class="mb-5">

              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nama Member
              </label>

              <div class="relative">

                <span
                  class="absolute left-4 top-1/2
                         -translate-y-1/2 text-lg"
                >
                  👤
                </span>

                <input
                  v-model="form.nama_member"
                  type="text"
                  placeholder="Masukkan nama member"
                  class="w-full pl-12 pr-4 py-3.5
                         border border-slate-300
                         bg-slate-50 rounded-xl
                         outline-none
                         focus:ring-2 focus:ring-blue-500
                         focus:border-blue-500
                         focus:bg-white
                         transition"
                />

              </div>

            </div>


            <!-- PERUSAHAAN -->
            <div>

              <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nama Perusahaan
              </label>

              <div class="relative">

                <span
                  class="absolute left-4 top-1/2
                         -translate-y-1/2 text-lg"
                >
                  🏢
                </span>

                <input
                  v-model="form.nama_perusahaan"
                  type="text"
                  placeholder="Masukkan nama perusahaan"
                  class="w-full pl-12 pr-4 py-3.5
                         border border-slate-300
                         bg-slate-50 rounded-xl
                         outline-none
                         focus:ring-2 focus:ring-blue-500
                         focus:border-blue-500
                         focus:bg-white
                         transition"
                />

              </div>

            </div>

          </div>


          <!-- PEMBAYARAN -->
          <div class="border-t border-slate-200 pt-7">

            <div class="flex items-center gap-2 mb-5">
              <div class="w-2 h-6 bg-green-500 rounded-full"></div>

              <h3 class="font-bold text-slate-800">
                Pembayaran
              </h3>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

              <!-- TAGIHAN -->
              <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Tagihan Bulanan
                </label>

                <div
                  class="rounded-xl border border-blue-200
                         bg-blue-50 p-4"
                >

                  <div class="flex items-center gap-3">

                    <div
                      class="w-10 h-10 rounded-xl bg-blue-600
                             flex items-center justify-center"
                    >
                      <span class="text-white">💳</span>
                    </div>

                    <div>

                      <p class="text-xs text-slate-500">
                        Biaya Member
                      </p>

                      <p class="text-xl font-bold text-blue-600">
                        Rp {{ formatRupiah(hargaMember) }}
                      </p>

                    </div>

                  </div>

                </div>

              </div>


              <!-- UANG BAYAR -->
              <div>

                <label class="block text-sm font-semibold text-slate-700 mb-2">
                  Uang Bayar
                </label>

                <div class="relative">

                  <span
                    class="absolute left-4 top-1/2
                           -translate-y-1/2
                           text-sm font-bold text-slate-500"
                  >
                    Rp
                  </span>

                  <input
                    v-model.number="form.uang_bayar"
                    type="number"
                    min="0"
                    placeholder="0"
                    class="w-full pl-11 pr-4 py-3.5
                           border border-slate-300
                           bg-slate-50 rounded-xl
                           outline-none
                           focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500
                           focus:bg-white
                           transition"
                  />

                </div>

              </div>

            </div>


            <!-- HASIL PEMBAYARAN -->
            <div
              v-if="form.uang_bayar > 0"
              class="mt-5 rounded-2xl border p-5"
              :class="
                statusPembayaran === 'lunas'
                  ? 'bg-green-50 border-green-200'
                  : 'bg-red-50 border-red-200'
              "
            >

              <div class="flex items-center justify-between mb-4">

                <div>

                  <p class="text-xs text-slate-500">
                    Status Pembayaran
                  </p>

                  <p
                    class="text-lg font-bold mt-1"
                    :class="
                      statusPembayaran === 'lunas'
                        ? 'text-green-600'
                        : 'text-red-600'
                    "
                  >
                    {{ statusPembayaran === 'lunas'
                      ? 'Pembayaran Lunas'
                      : 'Belum Lunas'
                    }}
                  </p>

                </div>

                <div
                  class="w-11 h-11 rounded-full bg-white
                         flex items-center justify-center shadow-sm"
                >
                  <span>
                    {{ statusPembayaran === 'lunas' ? '✓' : '!' }}
                  </span>
                </div>

              </div>


              <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                <div class="bg-white rounded-xl p-3">
                  <p class="text-xs text-slate-400">
                    Tagihan
                  </p>

                  <p class="font-bold text-slate-700 mt-1">
                    Rp {{ formatRupiah(hargaMember) }}
                  </p>
                </div>


                <div class="bg-white rounded-xl p-3">
                  <p class="text-xs text-slate-400">
                    Dibayar
                  </p>

                  <p class="font-bold text-slate-700 mt-1">
                    Rp {{ formatRupiah(form.uang_bayar) }}
                  </p>
                </div>


                <div class="bg-white rounded-xl p-3">
                  <p class="text-xs text-slate-400">
                    Kembalian
                  </p>

                  <p
                    class="font-bold mt-1"
                    :class="
                      statusPembayaran === 'lunas'
                        ? 'text-green-600'
                        : 'text-red-600'
                    "
                  >
                    Rp {{ formatRupiah(kembalian) }}
                  </p>
                </div>

              </div>

            </div>

          </div>


          <!-- TOMBOL -->
          <div class="border-t border-slate-200 mt-8 pt-6">

            <div class="flex flex-col sm:flex-row gap-3">

              <button
                type="button"
                @click="simpan"
                :disabled="loading"
                class="flex-1 bg-blue-600
                       hover:bg-blue-700
                       disabled:bg-blue-300
                       disabled:cursor-not-allowed
                       text-white py-3.5 px-5
                       rounded-xl font-semibold
                       shadow-lg shadow-blue-200
                       transition duration-200
                       active:scale-[0.98]
                       flex items-center justify-center gap-2"
              >

                <span v-if="!loading">
                  ✓
                </span>

                <span
                  v-else
                  class="w-5 h-5 border-2 border-white
                         border-t-transparent rounded-full
                         animate-spin"
                ></span>

                {{ loading ? 'Menyimpan...' : 'Simpan Member' }}

              </button>


              <button
                type="button"
                @click="kembali"
                class="flex-1 sm:flex-none
                       sm:min-w-37.5
                       bg-slate-600
                       hover:bg-slate-700
                       text-white py-3.5 px-5
                       rounded-xl font-semibold
                       transition duration-200
                       active:scale-[0.98]"
              >
                ← Kembali
              </button>

            </div>

          </div>

        </div>
      </div>


      <!-- FOOTER -->
      <p class="text-center text-xs text-slate-400 mt-5">
        Pastikan seluruh data member sudah benar sebelum disimpan.
      </p>

    </div>
  </div>
</template>


<script setup lang="ts">

import { computed, ref } from 'vue'

const { $api } = useNuxtApp()

const router = useRouter()


// FORM
const form = ref({
  nama_member: '',
  nama_perusahaan: '',
  uang_bayar: 0
})


// LOADING
const loading = ref(false)


// HARGA MEMBER
const hargaMember = 150000


// KEMBALIAN
const kembalian = computed(() => {

  const bayar = Number(
    form.value.uang_bayar || 0
  )

  const hasil = bayar - hargaMember

  return hasil > 0 ? hasil : 0

})


// STATUS
const statusPembayaran = computed(() => {

  const bayar = Number(
    form.value.uang_bayar || 0
  )

  return bayar >= hargaMember
    ? 'lunas'
    : 'belum lunas'

})


// FORMAT RUPIAH
const formatRupiah = (angka: number) => {

  return new Intl.NumberFormat('id-ID').format(
    Number(angka || 0)
  )

}


// SIMPAN
const simpan = async () => {

  if (!form.value.nama_member) {

    alert('Nama member harus diisi')

    return

  }


  if (!form.value.nama_perusahaan) {

    alert('Nama perusahaan harus diisi')

    return

  }


  if (
    form.value.uang_bayar < 0 ||
    form.value.uang_bayar === null
  ) {

    alert('Jumlah pembayaran tidak valid')

    return

  }


  loading.value = true


  try {

    const res = await $api.post(
      '/member',
      {
        nama_member:
          form.value.nama_member,

        nama_perusahaan:
          form.value.nama_perusahaan,

        uang_bayar:
          form.value.uang_bayar
      }
    )


    if (!res.data.status) {

      alert(
        res.data.message ||
        'Gagal membuat member'
      )

      return

    }


    alert('Member berhasil ditambahkan')


    router.push(
      '/petugas/member/select'
    )

  }

  catch (error: any) {

    console.error(
      'Gagal membuat member:',
      error
    )


    if (
      error?.response?.data?.errors
    ) {

      const errors =
        error.response.data.errors

      const pesan =
        Object.values(errors)
          .flat()
          .join('\n')

      alert(pesan)

    }

    else {

      alert(
        error?.response?.data?.message ||
        'Gagal menambahkan member'
      )

    }

  }

  finally {

    loading.value = false

  }

}


const kembali = () => {

  router.push(
    '/petugas/member/select'
  )

}

</script>