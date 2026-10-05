<template>
  <div class="min-h-screen bg-[#F8FAFC]">

    <!-- ================================================= -->
    <!-- SIDEBAR -->
    <!-- ================================================= -->
    <aside
      class="fixed left-0 top-0 bottom-0 w-64 bg-[#172033] text-white z-40 flex flex-col"
    >

      <!-- LOGO -->
      <div class="px-6 py-7 border-b border-white/10">

        <div class="flex items-center gap-3">

          <div
            class="w-12 h-12 rounded-2xl bg-[#38BDF8] flex items-center justify-center shadow-lg shadow-sky-500/20"
          >
            <span class="text-xl">
              🚗
            </span>
          </div>

          <div>
            <h1 class="text-lg font-extrabold tracking-wide">
              PARKIR
            </h1>

            <p class="text-[10px] text-slate-400 tracking-[0.2em]">
              PLAZA ANDALAS
            </p>
          </div>

        </div>

      </div>


      <!-- PROFILE -->
      <div class="px-5 py-5">

        <div
          class="rounded-2xl bg-white/4 border border-white/6 p-4"
        >

          <div class="flex items-center gap-3">

            <div
              class="w-11 h-11 rounded-xl bg-sky-400/15 border border-sky-400/20 text-sky-300 flex items-center justify-center font-bold"
            >
              P
            </div>

            <div class="min-w-0">

              <p class="text-sm font-semibold truncate">
                Petugas Parkir
              </p>

              <div class="flex items-center gap-2 mt-1">

                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>

                <span class="text-[11px] text-slate-400">
                  Online
                </span>

              </div>

            </div>

          </div>

        </div>

      </div>


      <!-- MENU -->
      <div class="px-4 flex-1 overflow-y-auto">

        <p class="px-3 mb-3 text-[10px] font-bold tracking-[0.2em] text-slate-500">
          MENU UTAMA
        </p>


        <!-- DASHBOARD -->
        <button
          @click="router.push('/petugas')"
          class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-[#38BDF8]/10 border border-[#38BDF8]/10 text-[#7DD3FC] mb-2"
        >

          <span class="w-8 text-center">
            🏠
          </span>

          <div class="text-left">

            <p class="text-sm font-semibold">
              Dashboard
            </p>

            <p class="text-[10px] text-slate-400 mt-0.5">
              Halaman utama
            </p>

          </div>

        </button>


        <!-- MEMBER -->
        <button
          @click="router.push('/petugas/member/select')"
          class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl hover:bg-white/5 transition group mb-1"
        >

          <span class="w-8 text-center">
            👥
          </span>

          <div class="text-left">

            <p class="text-sm font-semibold text-slate-200 group-hover:text-white">
              Kelola Member
            </p>

            <p class="text-[10px] text-slate-500 mt-0.5">
              Data & pembayaran
            </p>

          </div>

          <span class="ml-auto text-slate-600 group-hover:text-sky-400">
            →
          </span>

        </button>


        <!-- TRANSAKSI -->
        <button
          @click="router.push('/petugas/transaksi')"
          class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl hover:bg-white/5 transition group mb-1"
        >

          <span class="w-8 text-center">
            🚗
          </span>

          <div class="text-left">

            <p class="text-sm font-semibold text-slate-200 group-hover:text-white">
              Kelola Transaksi
            </p>

            <p class="text-[10px] text-slate-500 mt-0.5">
              Transaksi parkir
            </p>

          </div>

          <span class="ml-auto text-slate-600 group-hover:text-sky-400">
            →
          </span>

        </button>


        <!-- SCAN -->
        <button
          @click="router.push('/petugas/member/keluar')"
          class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl hover:bg-white/5 transition group mb-1"
        >

          <span class="w-8 text-center">
            📷
          </span>

          <div class="text-left">

            <p class="text-sm font-semibold text-slate-200 group-hover:text-white">
              Scan Keluar
            </p>

            <p class="text-[10px] text-slate-500 mt-0.5">
              Kendaraan keluar
            </p>

          </div>

          <span class="ml-auto text-slate-600 group-hover:text-sky-400">
            →
          </span>

        </button>


        <!-- LAPORAN -->
        <button
          @click="router.push('/laporan/l_petugas')"
          class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl hover:bg-white/5 transition group"
        >

          <span class="w-8 text-center">
            📊
          </span>

          <div class="text-left">

            <p class="text-sm font-semibold text-slate-200 group-hover:text-white">
              Laporan
            </p>

            <p class="text-[10px] text-slate-500 mt-0.5">
              Laporan parkir
            </p>

          </div>

          <span class="ml-auto text-slate-600 group-hover:text-sky-400">
            →
          </span>

        </button>

      </div>


      <!-- BOTTOM -->
      <div class="px-4 py-5 border-t border-white/10">

        <div
          class="p-3 rounded-2xl bg-white/4 border border-white/6 mb-2"
        >

          <div class="flex items-center gap-3">

            <div
              class="w-9 h-9 rounded-xl bg-sky-500/10 flex items-center justify-center"
            >
              ⚙️
            </div>

            <div>

              <p class="text-xs font-semibold text-sky-300">
                Status Sistem
              </p>

              <p class="text-[10px] text-slate-500 mt-0.5">
                Sistem Aktif
              </p>

            </div>

          </div>

        </div>


        <button
          @click="logout"
          class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition"
        >

          <span>
            🚪
          </span>

          <span class="text-sm font-semibold">
            Logout
          </span>

        </button>

      </div>

    </aside>


    <!-- ================================================= -->
    <!-- MAIN -->
    <!-- ================================================= -->
    <main class="ml-64 min-h-screen">


      <!-- ================================================= -->
      <!-- TOPBAR -->
      <!-- ================================================= -->
      <header
        class="h-20 bg-white border-b border-slate-200 px-8 flex items-center justify-between"
      >

        <div>

          <p class="text-[10px] uppercase tracking-[0.18em] font-bold text-sky-500">
            Dashboard Petugas
          </p>

          <h2 class="text-xl font-extrabold text-[#172033] mt-1">
            Selamat Datang 👋
          </h2>

        </div>


        <div class="flex items-center gap-3">

          <div
            class="hidden lg:flex items-center gap-3 px-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200"
          >

            <span class="text-base">
              📅
            </span>

            <div>

              <p class="text-[10px] text-slate-400">
                Hari ini
              </p>

              <p class="text-xs font-semibold text-slate-700">
                {{ tanggalHariIni }}
              </p>

            </div>

          </div>


          <button
            class="w-11 h-11 rounded-2xl bg-slate-50 border border-slate-200 hover:bg-sky-50 hover:border-sky-200 transition relative"
          >
            🔔

            <span
              class="absolute top-2.5 right-2.5 w-2 h-2 bg-sky-500 rounded-full ring-2 ring-white"
            ></span>
          </button>


          <div
            class="w-11 h-11 rounded-2xl bg-sky-100 border border-sky-200 text-sky-700 flex items-center justify-center font-bold"
          >
            P
          </div>

        </div>

      </header>


      <!-- ================================================= -->
      <!-- CONTENT -->
      <!-- ================================================= -->
      <div class="p-8">


        <!-- ================================================= -->
        <!-- HERO -->
        <!-- ================================================= -->
        <section
          class="relative overflow-hidden rounded-[28px] bg-[#172033] p-8 md:p-10 mb-7 shadow-xl"
        >

          <div
            class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-sky-400/10"
          ></div>

          <div
            class="absolute -bottom-28 right-20 w-80 h-80 rounded-full bg-sky-400/5"
          ></div>


          <div class="relative z-10">

            <div
              class="inline-flex items-center gap-2 rounded-full bg-sky-400/10 border border-sky-400/10 px-3 py-1.5 mb-5"
            >

              <span class="w-2 h-2 rounded-full bg-sky-400"></span>

              <span class="text-[10px] font-bold text-sky-300 uppercase tracking-wider">
                Sistem Parkir Aktif
              </span>

            </div>


            <h1
              class="text-3xl md:text-4xl font-extrabold text-white leading-tight max-w-xl"
            >
              Semua aktivitas parkir
              <span class="text-sky-400">
                dalam satu dashboard.
              </span>
            </h1>


            <p class="text-sm text-slate-400 mt-4 max-w-xl leading-relaxed">
              Pantau member, kendaraan, transaksi, pendapatan, dan kondisi area parkir dengan lebih mudah.
            </p>

          </div>


          <div
            class="absolute right-10 bottom-0 text-8xl opacity-[0.07]"
          >
            🚘
          </div>

        </section>


        <!-- ================================================= -->
        <!-- STATS -->
        <!-- ================================================= -->
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-7">


          <!-- MEMBER -->
          <button
            @click="router.push('/petugas/member/select')"
            class="group bg-white rounded-[22px] p-5 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-sky-200 transition-all text-left"
          >

            <div class="flex justify-between items-start">

              <div
                class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-500 flex items-center justify-center text-lg group-hover:bg-sky-500 group-hover:text-white transition"
              >
                👥
              </div>

              <span
                class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-600 text-[10px] font-bold"
              >
                MEMBER
              </span>

            </div>

            <p class="text-xs font-medium text-slate-400 mt-6">
              Total Member
            </p>

            <p class="text-3xl font-extrabold text-[#172033] mt-1">
              {{ totalMember }}
            </p>

            <p class="text-[10px] text-slate-400 mt-1">
              Member terdaftar
            </p>

          </button>


          <!-- KENDARAAN -->
          <button
            @click="router.push('/user')"
            class="group bg-white rounded-[22px] p-5 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-sky-200 transition-all text-left"
          >

            <div class="flex justify-between items-start">

              <div
                class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-500 flex items-center justify-center text-lg group-hover:bg-sky-500 group-hover:text-white transition"
              >
                🚙
              </div>

              <span
                class="px-2.5 py-1 rounded-full bg-slate-50 text-slate-400 text-[10px] font-semibold"
              >
                HARI INI
              </span>

            </div>

            <p class="text-xs font-medium text-slate-400 mt-6">
              Kendaraan Masuk
            </p>

            <p class="text-3xl font-extrabold text-[#172033] mt-1">
              {{ kendaraanMasuk }}
            </p>

            <p class="text-[10px] text-slate-400 mt-1">
              Kendaraan masuk
            </p>

          </button>


          <!-- PENDAPATAN -->
          <button
            @click="router.push('/laporan/l_petugas')"
            class="group bg-white rounded-[22px] p-5 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-sky-200 transition-all text-left"
          >

            <div class="flex justify-between items-start">

              <div
                class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-500 flex items-center justify-center text-lg group-hover:bg-sky-500 group-hover:text-white transition"
              >
                💰
              </div>

              <span
                class="px-2.5 py-1 rounded-full bg-slate-50 text-slate-400 text-[10px] font-semibold"
              >
                HARI INI
              </span>

            </div>

            <p class="text-xs font-medium text-slate-400 mt-6">
              Pendapatan
            </p>

            <p class="text-xl font-extrabold text-[#172033] mt-2">
              Rp {{ pendapatan }}
            </p>

            <p class="text-[10px] text-slate-400 mt-1">
              Total transaksi
            </p>

          </button>


          <!-- PARKIR -->
          <button
            @click="router.push('/petugas/transaksi')"
            class="group bg-white rounded-[22px] p-5 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-sky-200 transition-all text-left"
          >

            <div class="flex justify-between items-start">

              <div
                class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-500 flex items-center justify-center text-lg group-hover:bg-sky-500 group-hover:text-white transition"
              >
                🅿️
              </div>

              <span
                class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-600 text-[10px] font-bold"
              >
                LIVE
              </span>

            </div>

            <p class="text-xs font-medium text-slate-400 mt-6">
              Sedang Parkir
            </p>

            <p class="text-3xl font-extrabold text-[#172033] mt-1">
              {{ sedangParkir }}
            </p>

            <p class="text-[10px] text-slate-400 mt-1">
              Kendaraan di area parkir
            </p>

          </button>

        </section>


        <!-- ================================================= -->
        <!-- AKSES CEPAT -->
        <!-- ================================================= -->
        <section
          class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6"
        >

          <div class="flex items-center justify-between mb-6">

            <div>

              <p class="text-[10px] font-bold text-sky-500 uppercase tracking-wider">
                Shortcut
              </p>

              <h2 class="text-xl font-extrabold text-[#172033] mt-1">
                Akses Cepat
              </h2>

            </div>

            <span
              class="hidden sm:block px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-xl text-[10px] font-semibold text-slate-400"
            >
              MENU PETUGAS
            </span>

          </div>


          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">


            <!-- MEMBER -->
            <button
              @click="router.push('/petugas/member/select')"
              class="group p-5 rounded-2xl border border-slate-200 hover:border-sky-200 hover:bg-sky-50 transition-all text-center"
            >

              <div
                class="mx-auto w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
              >
                👥
              </div>

              <p class="text-sm font-bold text-slate-700 mt-4">
                Kelola Member
              </p>

              <p class="text-[10px] text-slate-400 mt-1">
                Tambah & lihat member
              </p>

            </button>


            <!-- TRANSAKSI -->
            <button
              @click="router.push('/petugas/transaksi')"
              class="group p-5 rounded-2xl border border-slate-200 hover:border-sky-200 hover:bg-sky-50 transition-all text-center"
            >

              <div
                class="mx-auto w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
              >
                🚗
              </div>

              <p class="text-sm font-bold text-slate-700 mt-4">
                Kelola Transaksi
              </p>

              <p class="text-[10px] text-slate-400 mt-1">
                Transaksi parkir
              </p>

            </button>


            <!-- SCAN -->
            <button
              @click="router.push('/petugas/member/keluar')"
              class="group p-5 rounded-2xl border border-slate-200 hover:border-sky-200 hover:bg-sky-50 transition-all text-center"
            >

              <div
                class="mx-auto w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
              >
                📷
              </div>

              <p class="text-sm font-bold text-slate-700 mt-4">
                Scan Keluar
              </p>

              <p class="text-[10px] text-slate-400 mt-1">
                Kendaraan keluar
              </p>

            </button>


            <!-- LAPORAN -->
            <button
              @click="router.push('/laporan/l_petugas')"
              class="group p-5 rounded-2xl border border-slate-200 hover:border-sky-200 hover:bg-sky-50 transition-all text-center"
            >

              <div
                class="mx-auto w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
              >
                📊
              </div>

              <p class="text-sm font-bold text-slate-700 mt-4">
                Laporan
              </p>

              <p class="text-[10px] text-slate-400 mt-1">
                Lihat laporan
              </p>

            </button>

          </div>


          <!-- INFO -->
          <div class="mt-6">

            <div
              class="flex items-center gap-3 p-4 rounded-2xl bg-sky-50 border border-sky-100"
            >

              <div
                class="w-10 h-10 rounded-xl bg-white text-sky-500 flex items-center justify-center shadow-sm"
              >
                ℹ️
              </div>

              <div>

                <p class="text-xs font-bold text-slate-700">
                  Informasi
                </p>

                <p class="text-[10px] text-slate-400 mt-1">
                  Gunakan menu di atas untuk mengelola sistem parkir.
                </p>

              </div>

            </div>

          </div>

        </section>


        <!-- FOOTER -->
        <div
          class="flex flex-col md:flex-row items-center justify-between gap-2 mt-7 pt-5 border-t border-slate-200"
        >

          <p class="text-[11px] text-slate-400">
            © 2026 PARKIR PLAZA ANDALAS
          </p>

          <p class="text-[11px] text-slate-400">
            Sistem Informasi Parkir
          </p>

        </div>

      </div>

    </main>

  </div>
</template>


<script setup lang="ts">

import { ref, computed, onMounted } from 'vue'


// =================================================
// ROUTER
// =================================================

const router = useRouter()


// =================================================
// DATA DASHBOARD
// =================================================

const totalMember = ref(0)

const kendaraanMasuk = ref(0)

const pendapatan = ref('0')

const sedangParkir = ref(0)


// =================================================
// AMBIL DATA DASHBOARD DARI API
// =================================================

const fetchDashboard = async () => {

  try {

    const token = localStorage.getItem('token')

    const res = await fetch(
      'http://localhost:8000/api/dashboard/petugas',
      {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      }
    )

    const json = await res.json()

    if (json.success) {

      totalMember.value =
        json.data.total_member

      kendaraanMasuk.value =
        json.data.kendaraan_masuk

      sedangParkir.value =
        json.data.sedang_parkir

      pendapatan.value =
        json.data.pendapatan.toLocaleString('id-ID')

    }

  } catch (error) {

    console.error(
      'Gagal mengambil data dashboard:',
      error
    )

  }

}


// =================================================
// TANGGAL HARI INI
// =================================================

const tanggalHariIni = computed(() => {

  const tanggal = new Date()

  return tanggal.toLocaleDateString(
    'id-ID',
    {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    }
  )

})


// =================================================
// LOGOUT
// =================================================

const logout = () => {

  if (import.meta.client) {

    localStorage.removeItem('role')

    localStorage.removeItem('email')

    localStorage.removeItem('token')

  }

  router.replace('/')

}


// =================================================
// CEK ROLE
// =================================================

onMounted(() => {

  fetchDashboard()

  const role = localStorage.getItem('role')

  if (
    role &&
    role !== 'petugas' &&
    role !== 'super_admin'
  ) {

    router.replace('/')

  }

})

</script>