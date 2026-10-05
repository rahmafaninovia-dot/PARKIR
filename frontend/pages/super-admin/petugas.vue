<template>
  <div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">

    <!-- HEADER -->
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
      <div>
        <p class="text-sm font-medium text-orange-500">
          Sistem Parkir Plaza Andalas
        </p>

        <h1 class="text-3xl font-bold text-slate-800">
          Kelola Petugas
        </h1>

        <p class="mt-1 text-sm text-slate-500">
          Kelola data petugas parkir dengan mudah.
        </p>
      </div>

      <div class="flex flex-wrap gap-3">

        <!-- KEMBALI -->
        <button
          type="button"
          @click="kembali"
          class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
          ← Kembali
        </button>

        <!-- REFRESH -->
        <button
          type="button"
          @click="ambilData"
          :disabled="loading"
          class="inline-flex items-center gap-2 rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60"
        >
          <span :class="{ 'animate-spin': loading }">
            ↻
          </span>

          {{ loading ? 'Memuat...' : 'Refresh Data' }}
        </button>

      </div>
    </div>


    <!-- PESAN -->
    <div
      v-if="pesan"
      class="mb-5 rounded-xl border px-4 py-3 text-sm font-medium"
      :class="
        pesanTipe === 'success'
          ? 'border-emerald-200 bg-emerald-50 text-emerald-700'
          : 'border-red-200 bg-red-50 text-red-700'
      "
    >
      {{ pesan }}
    </div>


    <!-- BANNER -->
    <div
      class="relative mb-6 overflow-hidden rounded-3xl bg-slate-800 p-6 text-white shadow-lg md:p-8"
    >
      <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-orange-400/20"></div>
      <div class="absolute -bottom-16 right-24 h-48 w-48 rounded-full bg-orange-300/10"></div>

      <div class="relative">
        <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-orange-400">
          Manajemen Petugas
        </p>

        <h2 class="text-2xl font-bold md:text-3xl">
          Manajemen Petugas Parkir
        </h2>

        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
          Tambah, edit, hapus, dan lihat data petugas parkir yang terdaftar
          dalam sistem.
        </p>
      </div>
    </div>


    <!-- STATISTIK -->
    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-3">

      <!-- TOTAL -->
      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-500">
              Total Petugas
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-800">
              {{ totalPetugas }}
            </h3>

            <p class="mt-1 text-xs text-slate-400">
              Petugas terdaftar
            </p>
          </div>

          <div
            class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-2xl"
          >
            👤
          </div>
        </div>
      </div>


      <!-- PAGI -->
      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-500">
              Shift Pagi
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-800">
              {{ jumlahShift('pagi') }}
            </h3>

            <p class="mt-1 text-xs text-slate-400">
              Petugas shift pagi
            </p>
          </div>

          <div
            class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-2xl"
          >
            🌅
          </div>
        </div>
      </div>


      <!-- MALAM -->
      <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-slate-500">
              Shift Malam
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-800">
              {{ jumlahShift('malam') }}
            </h3>

            <p class="mt-1 text-xs text-slate-400">
              Petugas shift malam
            </p>
          </div>

          <div
            class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-2xl"
          >
            🌙
          </div>
        </div>
      </div>

    </div>


    <!-- FILTER -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

      <div class="mb-4">
        <h2 class="text-lg font-bold text-slate-800">
          Data Petugas
        </h2>

        <p class="text-sm text-slate-500">
          Cari dan filter data petugas.
        </p>
      </div>


      <div class="grid grid-cols-1 gap-4 md:grid-cols-[1fr_220px_auto]">

        <!-- SEARCH -->
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-700">
            Cari Petugas
          </label>

          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
              🔍
            </span>

            <input
              v-model="pencarian"
              type="text"
              placeholder="Cari nama, email, atau nomor HP..."
              class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
            />
          </div>
        </div>


        <!-- SHIFT -->
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-700">
            Shift
          </label>

          <select
            v-model="filterShift"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
          >
            <option value="">
              Semua Shift
            </option>

            <option value="pagi">
              Pagi
            </option>

            <option value="malam">
              Malam
            </option>
          </select>
        </div>


        <!-- TAMBAH -->
        <div class="flex items-end">
          <button
            type="button"
            @click="bukaFormTambah"
            class="w-full rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-orange-600 md:w-auto"
          >
            + Tambah Petugas
          </button>
        </div>

      </div>
    </div>


    <!-- TABLE -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

      <!-- TABLE HEADER -->
      <div class="border-b border-slate-200 px-5 py-4">
        <div class="flex items-center justify-between">

          <div>
            <h3 class="font-bold text-slate-800">
              Daftar Petugas
            </h3>

            <p class="mt-1 text-xs text-slate-400">
              {{ dataPetugas.length }} data ditampilkan
            </p>
          </div>

        </div>
      </div>


      <!-- LOADING -->
      <div
        v-if="loading"
        class="flex min-h-75 flex-col items-center justify-center"
      >
        <div
          class="h-10 w-10 animate-spin rounded-full border-4 border-slate-200 border-t-orange-500"
        ></div>

        <p class="mt-4 text-sm font-medium text-slate-500">
          Memuat data petugas...
        </p>
      </div>


      <!-- EMPTY -->
      <div
        v-else-if="dataPetugas.length === 0"
        class="flex min-h-75 flex-col items-center justify-center px-5 text-center"
      >
        <div
          class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-3xl"
        >
          👤
        </div>

        <h3 class="text-lg font-bold text-slate-700">
          Belum ada data petugas
        </h3>

        <p class="mt-1 max-w-md text-sm text-slate-400">
          Belum ada petugas yang sesuai dengan pencarian atau filter yang dipilih.
        </p>

        <button
          type="button"
          @click="bukaFormTambah"
          class="mt-5 rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600"
        >
          + Tambah Petugas
        </button>
      </div>


      <!-- TABLE CONTENT -->
      <div
        v-else
        class="overflow-x-auto"
      >
        <table class="w-full min-w-225">

          <thead class="bg-slate-50">
            <tr class="border-b border-slate-200">

              <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                No
              </th>

              <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                Petugas
              </th>

              <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                Email
              </th>

              <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                No. HP
              </th>

              <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                Shift
              </th>

              <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                Aksi
              </th>

            </tr>
          </thead>


          <tbody class="divide-y divide-slate-100">

            <tr
              v-for="(item, index) in dataPetugas"
              :key="item.id"
              class="transition hover:bg-slate-50"
            >

              <!-- NO -->
              <td class="px-5 py-4 text-sm font-semibold text-slate-500">
                {{ index + 1 }}
              </td>


              <!-- PETUGAS -->
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">

                  <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-orange-100 font-bold text-orange-600"
                  >
                    {{ inisial(item.name) }}
                  </div>

                  <div>
                    <p class="font-bold text-slate-800">
                      {{ item.name || '-' }}
                    </p>

                    <p class="text-xs text-slate-400">
                      ID #{{ item.id }}
                    </p>
                  </div>

                </div>
              </td>


              <!-- EMAIL -->
              <td class="px-5 py-4">
                <span class="text-sm text-slate-600">
                  {{ item.email || '-' }}
                </span>
              </td>


              <!-- NO HP -->
              <td class="px-5 py-4">
                <span class="text-sm text-slate-600">
                  {{ item.no_hp || '-' }}
                </span>
              </td>


              <!-- SHIFT -->
              <td class="px-5 py-4">
                <span
                  class="inline-flex rounded-full px-3 py-1 text-xs font-bold"
                  :class="kelasShift(item.shift)"
                >
                  {{ item.shift || '-' }}
                </span>
              </td>


              <!-- AKSI -->
              <td class="px-5 py-4">
                <div class="flex justify-center gap-2">

                  <!-- EDIT -->
                  <button
                    type="button"
                    @click="bukaFormEdit(item)"
                    class="rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600 transition hover:bg-blue-100"
                  >
                    ✏️ Edit
                  </button>


                  <!-- HAPUS -->
                  <button
                    type="button"
                    @click="hapusPetugas(item)"
                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-100"
                  >
                    🗑️ Hapus
                  </button>

                </div>
              </td>

            </tr>

          </tbody>

        </table>
      </div>

    </div>


    <!-- MODAL -->
    <div
      v-if="tampilForm"
      class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm"
      @click.self="tutupForm"
    >

      <div
        class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
      >

        <!-- MODAL HEADER -->
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

          <div>
            <h2 class="text-xl font-bold text-slate-800">
              {{ modeForm === 'tambah' ? 'Tambah Petugas' : 'Edit Petugas' }}
            </h2>

            <p class="mt-1 text-sm text-slate-400">
              Lengkapi data petugas di bawah.
            </p>
          </div>

          <button
            type="button"
            @click="tutupForm"
            class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition hover:bg-slate-200"
          >
            ✕
          </button>

        </div>


        <!-- FORM -->
        <form
          @submit.prevent="simpanPetugas"
          class="space-y-5 p-6"
        >

          <!-- NAMA -->
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
              Nama Petugas
            </label>

            <input
              v-model="form.name"
              type="text"
              required
              placeholder="Masukkan nama petugas"
              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
            />
          </div>


          <!-- EMAIL -->
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
              Email
            </label>

            <input
              v-model="form.email"
              type="email"
              required
              placeholder="contoh@email.com"
              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
            />
          </div>


          <!-- PASSWORD -->
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
              Password
              <span
                v-if="modeForm === 'edit'"
                class="font-normal text-slate-400"
              >
                (kosongkan jika tidak ingin mengubah)
              </span>
            </label>

            <div class="relative">

              <input
                v-model="form.password"
                :type="lihatPassword ? 'text' : 'password'"
                :required="modeForm === 'tambah'"
                placeholder="Masukkan password"
                class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-12 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
              />

              <button
                type="button"
                @click="lihatPassword = !lihatPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
              >
                {{ lihatPassword ? '🙈' : '👁️' }}
              </button>

            </div>
          </div>


          <!-- NO HP -->
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
              Nomor HP
            </label>

            <input
              v-model="form.no_hp"
              type="text"
              required
              placeholder="08xxxxxxxxxx"
              class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
            />

            <p
              v-if="nomorHpDuplikat"
              class="mt-1 text-xs font-medium text-red-500"
            >
              Nomor HP sudah digunakan.
            </p>
          </div>


          <!-- SHIFT -->
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">
              Shift
            </label>

            <select
              v-model="form.shift"
              required
              class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-orange-400 focus:ring-2 focus:ring-orange-100"
            >
              <option value="">
                Pilih Shift
              </option>

              <option value="pagi">
                Pagi
              </option>

              <option value="malam">
                Malam
              </option>
            </select>
          </div>


          <!-- BUTTON -->
          <div class="flex gap-3 pt-2">

            <button
              type="button"
              @click="tutupForm"
              class="flex-1 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50"
            >
              Batal
            </button>

            <button
              type="submit"
              :disabled="saving || nomorHpDuplikat"
              class="flex-1 rounded-xl bg-orange-500 px-5 py-3 text-sm font-bold text-white transition hover:bg-orange-600 disabled:cursor-not-allowed disabled:opacity-60"
            >
              {{ saving ? 'Menyimpan...' : 'Simpan Petugas' }}
            </button>

          </div>

        </form>

      </div>

    </div>

  </div>
</template>


<script setup>
import { computed, onMounted, reactive, ref } from 'vue'


/* =========================================================
   STATE
========================================================= */

const petugas = ref([])

const loading = ref(false)
const saving = ref(false)

const pencarian = ref('')
const filterShift = ref('')

const tampilForm = ref(false)
const modeForm = ref('tambah')

const pesan = ref('')
const pesanTipe = ref('success')

const lihatPassword = ref(false)

const form = reactive({
  id: null,
  name: '',
  email: '',
  password: '',
  no_hp: '',
  shift: ''
})


/* =========================================================
   RUNTIME CONFIG
========================================================= */

const config = useRuntimeConfig()


/* =========================================================
   RESET FORM
========================================================= */

const resetForm = () => {
  form.id = null
  form.name = ''
  form.email = ''
  form.password = ''
  form.no_hp = ''
  form.shift = ''

  lihatPassword.value = false
}


/* =========================================================
   AMBIL DATA PETUGAS
========================================================= */

const ambilData = async () => {
  loading.value = true
  pesan.value = ''

  try {

    console.log('Mengambil data petugas...')
    console.log('API:', config.public.apiBase)

    const response = await $fetch(
      `${config.public.apiBase}/petugas`,
      {
        method: 'GET',
        timeout: 10000
      }
    )

    console.log('RESPONSE PETUGAS:', response)


    /*
     * Laravel:
     *
     * {
     *   success: true,
     *   data: [...]
     * }
     */

    if (
      response &&
      response.success === true &&
      Array.isArray(response.data)
    ) {

      petugas.value = response.data

    }

    /*
     * Kalau API langsung mengirim array
     */

    else if (Array.isArray(response)) {

      petugas.value = response

    }

    /*
     * Format salah
     */

    else {

      petugas.value = []

      throw new Error(
        'Format data petugas dari API tidak sesuai.'
      )

    }

  } catch (error) {

    console.error('ERROR PETUGAS:', error)

    petugas.value = []

    tampilkanPesan(
      error?.data?.message ||
      error?.message ||
      'Gagal mengambil data petugas.',
      'error'
    )

  } finally {

    loading.value = false

  }
}


/* =========================================================
   DATA FILTER
========================================================= */

const dataPetugas = computed(() => {

  /*
   * PENTING:
   * Pastikan selalu array supaya .filter()
   * tidak menyebabkan error.
   */

  const data = Array.isArray(petugas.value)
    ? petugas.value
    : []


  return data.filter((item) => {

    const keyword = pencarian.value
      .trim()
      .toLowerCase()


    const nama = String(
      item?.name || ''
    ).toLowerCase()

    const email = String(
      item?.email || ''
    ).toLowerCase()

    const noHp = String(
      item?.no_hp || ''
    ).toLowerCase()


    const cocokPencarian =
      !keyword ||
      nama.includes(keyword) ||
      email.includes(keyword) ||
      noHp.includes(keyword)


    const cocokShift =
      !filterShift.value ||
      String(item?.shift || '').toLowerCase() ===
        filterShift.value.toLowerCase()


    return cocokPencarian && cocokShift

  })

})


/* =========================================================
   TOTAL PETUGAS
========================================================= */

const totalPetugas = computed(() => {

  return Array.isArray(petugas.value)
    ? petugas.value.length
    : 0

})


/* =========================================================
   JUMLAH SHIFT
========================================================= */

const jumlahShift = (shift) => {

  const data = Array.isArray(petugas.value)
    ? petugas.value
    : []


  return data.filter((item) => {

    return String(
      item?.shift || ''
    ).toLowerCase() === shift.toLowerCase()

  }).length

}


/* =========================================================
   INISIAL
========================================================= */

const inisial = (nama) => {

  if (!nama) {
    return '?'
  }

  const kata = String(nama)
    .trim()
    .split(/\s+/)

  if (kata.length === 1) {
    return kata[0]
      .substring(0, 2)
      .toUpperCase()
  }

  return (
    kata[0][0] +
    kata[1][0]
  ).toUpperCase()

}


/* =========================================================
   CLASS SHIFT
========================================================= */

const kelasShift = (shift) => {

  const nilai = String(
    shift || ''
  ).toLowerCase()


  if (nilai === 'pagi') {

    return 'bg-amber-100 text-amber-700'

  }


  if (nilai === 'malam') {

    return 'bg-indigo-100 text-indigo-700'

  }


  return 'bg-slate-100 text-slate-600'

}


/* =========================================================
   CEK NOMOR HP DUPLIKAT
========================================================= */

const nomorHpDuplikat = computed(() => {

  const nomor = String(
    form.no_hp || ''
  ).trim()


  if (!nomor) {
    return false
  }


  const data = Array.isArray(petugas.value)
    ? petugas.value
    : []


  return data.some((item) => {

    /*
     * Saat edit, jangan anggap nomor miliknya sendiri
     * sebagai duplikat.
     */

    if (
      modeForm.value === 'edit' &&
      Number(item.id) === Number(form.id)
    ) {
      return false
    }


    return String(
      item?.no_hp || ''
    ).trim() === nomor

  })

})


/* =========================================================
   BUKA FORM TAMBAH
========================================================= */

const bukaFormTambah = () => {

  modeForm.value = 'tambah'

  resetForm()

  tampilForm.value = true

}


/* =========================================================
   BUKA FORM EDIT
========================================================= */

const bukaFormEdit = (item) => {

  modeForm.value = 'edit'

  form.id = item.id
  form.name = item.name || ''
  form.email = item.email || ''
  form.password = ''
  form.no_hp = item.no_hp || ''
  form.shift = item.shift || ''

  lihatPassword.value = false

  tampilForm.value = true

}


/* =========================================================
   TUTUP FORM
========================================================= */

const tutupForm = () => {

  if (saving.value) {
    return
  }

  tampilForm.value = false

  resetForm()

}


/* =========================================================
   SIMPAN PETUGAS
========================================================= */

const simpanPetugas = async () => {

  if (saving.value) {
    return
  }


  if (nomorHpDuplikat.value) {

    tampilkanPesan(
      'Nomor HP sudah digunakan oleh petugas lain.',
      'error'
    )

    return

  }


  saving.value = true
  pesan.value = ''


  try {

    const payload = {
      name: form.name,
      email: form.email,
      no_hp: form.no_hp,
      shift: form.shift
    }


    /*
     * Password hanya dikirim kalau diisi.
     */

    if (form.password) {
      payload.password = form.password
    }


    let response


    if (modeForm.value === 'tambah') {

      response = await $fetch(
        `${config.public.apiBase}/petugas`,
        {
          method: 'POST',
          body: payload
        }
      )

    } else {

      response = await $fetch(
        `${config.public.apiBase}/petugas/${form.id}`,
        {
          method: 'PUT',
          body: payload
        }
      )

    }


    console.log(
      'RESPONSE SIMPAN:',
      response
    )


    tampilkanPesan(
      response?.message ||
      (
        modeForm.value === 'tambah'
          ? 'Petugas berhasil ditambahkan.'
          : 'Data petugas berhasil diperbarui.'
      ),
      'success'
    )


    tampilForm.value = false

    resetForm()

    await ambilData()


  } catch (error) {

    console.error(
      'ERROR SIMPAN PETUGAS:',
      error
    )


    tampilkanPesan(
      error?.data?.message ||
      error?.data?.errors
        ? Object.values(
            error.data.errors || {}
          )
          .flat()
          .join(', ')
        : error?.message ||
          'Gagal menyimpan data petugas.',
      'error'
    )

  } finally {

    saving.value = false

  }

}


/* =========================================================
   HAPUS PETUGAS
========================================================= */

const hapusPetugas = async (item) => {

  const yakin = window.confirm(
    `Apakah kamu yakin ingin menghapus petugas "${item.name}"?`
  )


  if (!yakin) {
    return
  }


  try {

    await $fetch(
      `${config.public.apiBase}/petugas/${item.id}`,
      {
        method: 'DELETE'
      }
    )


    tampilkanPesan(
      'Petugas berhasil dihapus.',
      'success'
    )


    await ambilData()


  } catch (error) {

    console.error(
      'ERROR HAPUS PETUGAS:',
      error
    )


    tampilkanPesan(
      error?.data?.message ||
      error?.message ||
      'Gagal menghapus petugas.',
      'error'
    )

  }

}


/* =========================================================
   PESAN
========================================================= */

const tampilkanPesan = (
  teks,
  tipe = 'success'
) => {

  pesan.value = teks
  pesanTipe.value = tipe


  setTimeout(() => {

    pesan.value = ''

  }, 4000)

}


/* =========================================================
   KEMBALI
========================================================= */

const kembali = () => {

  navigateTo('/super-admin')

}


/* =========================================================
   ON MOUNTED
========================================================= */

onMounted(() => {

  ambilData()

})
</script>