<template>
  <div class="min-h-screen bg-slate-50 p-4 md:p-6 lg:p-8">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

      <div>
        <p class="text-sm font-medium text-sky-600">
          Sistem Parkir Plaza Andalas
        </p>

        <h1 class="text-3xl font-bold text-[#172033]">
          Laporan Admin
        </h1>

        <p class="mt-1 text-sm text-slate-500">
          Ringkasan keuangan, member, petugas, kendaraan, dan aktivitas parkir.
        </p>
      </div>


      <!-- BUTTON -->
      <div class="flex flex-wrap gap-3">

        <!-- KEMBALI -->
        <button
          @click="navigateTo('/super-admin')"
          class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-[#172033] shadow-sm transition hover:bg-slate-50"
        >
          <svg
            class="h-4 w-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 19l-7-7 7-7"
            />
          </svg>

          Kembali
        </button>


        <!-- REFRESH -->
        <button
          @click="ambilData"
          :disabled="loading"
          class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#172033] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-60"
        >
          <svg
            class="h-4 w-4"
            :class="{ 'animate-spin': loading }"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9M4 20v-5h.582m15.356-2a8.001 8.001 0 0115.356 2"
            />
          </svg>

          {{ loading ? 'Memuat...' : 'Refresh Data' }}
        </button>


        <!-- CETAK -->
        <button
          type="button"
          @click="cetakLaporan"
          class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-600"
        >
          🖨️ Cetak
        </button>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- BANNER -->
    <!-- ===================================================== -->
    <div
      class="relative mb-6 overflow-hidden rounded-3xl bg-[#172033] p-6 text-white shadow-lg md:p-8"
    >
      <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-sky-400/20"></div>
      <div class="absolute -bottom-20 right-20 h-48 w-48 rounded-full bg-sky-300/10"></div>

      <div class="relative">
        <p class="mb-2 text-sm font-medium text-sky-300">
          MONITORING ADMIN
        </p>

        <h2 class="text-2xl font-bold md:text-3xl">
          Monitoring Sistem Secara Menyeluruh
        </h2>

        <p class="mt-2 max-w-3xl text-sm leading-6 text-slate-300">
          Pantau pendapatan member, pendapatan non-member, kondisi kendaraan,
          aktivitas parkir, serta data petugas dalam satu halaman.
        </p>
      </div>
    </div>


    <!-- ===================================================== -->
    <!-- FILTER -->
    <!-- ===================================================== -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

      <div class="mb-4">
        <h3 class="text-lg font-bold text-[#172033]">
          Filter Laporan
        </h3>

        <p class="text-sm text-slate-500">
          Pilih periode dan data yang ingin ditampilkan.
        </p>
      </div>


      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        <!-- PERIODE -->
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-700">
            Periode
          </label>

          <select
            v-model="periode"
            @change="prosesData"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
          >
            <option value="hari">
              Hari Ini
            </option>

            <option value="minggu">
              Minggu Ini
            </option>

            <option value="bulan">
              Bulan Ini
            </option>

            <option value="bulan_lalu">
              Bulan Lalu
            </option>

            <option value="semua">
              Semua Data
            </option>
          </select>
        </div>


        <!-- STATUS -->
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-700">
            Status Parkir
          </label>

          <select
            v-model="filterStatus"
            @change="prosesData"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
          >
            <option value="semua">
              Semua Status
            </option>

            <option value="masuk">
              Masuk
            </option>

            <option value="keluar">
              Keluar
            </option>
          </select>
        </div>


        <!-- KENDARAAN -->
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-700">
            Jenis Kendaraan
          </label>

          <select
            v-model="filterKendaraan"
            @change="prosesData"
            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-sky-400 focus:ring-2 focus:ring-sky-100"
          >
            <option value="semua">
              Semua Kendaraan
            </option>

            <option value="Motor">
              Motor
            </option>

            <option value="Mobil">
              Mobil
            </option>
          </select>
        </div>

      </div>
    </div>


    <!-- ===================================================== -->
    <!-- INFO PERIODE -->
    <!-- ===================================================== -->
    <div class="mb-6 rounded-xl border border-sky-100 bg-sky-50 px-4 py-3">

      <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">

        <div>
          <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">
            Periode Laporan
          </p>

          <p class="text-sm font-bold capitalize text-[#172033]">
            {{ labelPeriode }}
          </p>
        </div>

        <p class="text-sm text-slate-500">
          Pendapatan member dan non-member dihitung secara terpisah.
        </p>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- OVERVIEW -->
    <!-- ===================================================== -->
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

      <!-- TOTAL -->
      <div class="rounded-2xl bg-[#172033] p-5 text-white shadow-sm">

        <div class="flex items-start justify-between">

          <div>
            <p class="text-sm text-slate-300">
              Total Pendapatan
            </p>

            <h3 class="mt-2 text-2xl font-bold">
              {{ formatRupiah(totalPendapatan) }}
            </h3>
          </div>

          <div class="rounded-xl bg-white/10 p-3">

            <svg
              class="h-6 w-6 text-sky-300"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8c-2.21 0-4 1.343-4 3s1.79 3 4 3 4 1.343 4 3-1.79 3-4 3m0-12V4m0 16v-4"
              />
            </svg>

          </div>

        </div>

        <p class="mt-4 text-xs text-slate-400">
          Member + Non-Member
        </p>

      </div>


      <!-- MEMBER -->
      <div class="rounded-2xl border border-violet-100 bg-white p-5 shadow-sm">

        <div class="flex items-start justify-between">

          <div>
            <p class="text-sm text-slate-500">
              Pendapatan Member
            </p>

            <h3 class="mt-2 text-2xl font-bold text-violet-600">
              {{ formatRupiah(pendapatanMember) }}
            </h3>
          </div>

          <div class="rounded-xl bg-violet-100 p-3">

            <svg
              class="h-6 w-6 text-violet-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 21a7 7 0 0114 0"
              />
            </svg>

          </div>

        </div>

        <div class="mt-4 flex items-center justify-between text-xs">

          <span class="text-slate-500">
            Pembayaran lunas
          </span>

          <span class="font-bold text-violet-600">
            {{ jumlahPembayaranMember }} pembayaran
          </span>

        </div>

      </div>


      <!-- NON MEMBER -->
      <div class="rounded-2xl border border-sky-100 bg-white p-5 shadow-sm">

        <div class="flex items-start justify-between">

          <div>
            <p class="text-sm text-slate-500">
              Pendapatan Non-Member
            </p>

            <h3 class="mt-2 text-2xl font-bold text-sky-600">
              {{ formatRupiah(pendapatanNonMember) }}
            </h3>
          </div>

          <div class="rounded-xl bg-sky-100 p-3">

            <svg
              class="h-6 w-6 text-sky-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 10h18M7 15h.01M11 15h2M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
              />
            </svg>

          </div>

        </div>

        <div class="mt-4 flex items-center justify-between text-xs">

          <span class="text-slate-500">
            Parkir selesai
          </span>

          <span class="font-bold text-sky-600">
            {{ transaksiNonMember }} transaksi
          </span>

        </div>

      </div>


      <!-- SEDANG PARKIR -->
      <div class="rounded-2xl border border-amber-100 bg-white p-5 shadow-sm">

        <div class="flex items-start justify-between">

          <div>
            <p class="text-sm text-slate-500">
              Sedang Parkir
            </p>

            <h3 class="mt-2 text-2xl font-bold text-amber-500">
              {{ totalMasuk }}
            </h3>
          </div>

          <div class="rounded-xl bg-amber-100 p-3">

            <svg
              class="h-6 w-6 text-amber-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2z"
              />
            </svg>

          </div>

        </div>

        <p class="mt-4 text-xs text-slate-500">
          Kendaraan masih berstatus masuk
        </p>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- ANALISIS PENDAPATAN -->
    <!-- ===================================================== -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:p-6">

      <div class="mb-6">

        <h2 class="text-xl font-bold text-[#172033]">
          Analisis Pendapatan
        </h2>

        <p class="mt-1 text-sm text-slate-500">
          Perbandingan pendapatan dari membership dan parkir non-member.
        </p>

      </div>


      <!-- MEMBER -->
      <div class="mb-6">

        <div class="mb-2 flex items-center justify-between">

          <div class="flex items-center gap-2">

            <span class="h-3 w-3 rounded-full bg-violet-500"></span>

            <span class="text-sm font-semibold text-slate-700">
              Member
            </span>

          </div>

          <div class="text-right">

            <p class="text-sm font-bold text-violet-600">
              {{ formatRupiah(pendapatanMember) }}
            </p>

            <p class="text-xs text-slate-400">
              {{ persentaseMember }}%
            </p>

          </div>

        </div>

        <div class="h-3 overflow-hidden rounded-full bg-violet-100">

          <div
            class="h-full rounded-full bg-violet-500 transition-all duration-500"
            :style="{ width: persentaseMember + '%' }"
          ></div>

        </div>

      </div>


      <!-- NON MEMBER -->
      <div>

        <div class="mb-2 flex items-center justify-between">

          <div class="flex items-center gap-2">

            <span class="h-3 w-3 rounded-full bg-sky-500"></span>

            <span class="text-sm font-semibold text-slate-700">
              Non-Member
            </span>

          </div>

          <div class="text-right">

            <p class="text-sm font-bold text-sky-600">
              {{ formatRupiah(pendapatanNonMember) }}
            </p>

            <p class="text-xs text-slate-400">
              {{ persentaseNonMember }}%
            </p>

          </div>

        </div>

        <div class="h-3 overflow-hidden rounded-full bg-sky-100">

          <div
            class="h-full rounded-full bg-sky-500 transition-all duration-500"
            :style="{ width: persentaseNonMember + '%' }"
          ></div>

        </div>

      </div>


      <!-- RINGKASAN -->
      <div class="mt-6 grid grid-cols-1 gap-3 border-t border-slate-100 pt-5 md:grid-cols-3">

        <div class="rounded-xl bg-violet-50 p-4">

          <p class="text-xs text-violet-500">
            Pembayaran Member
          </p>

          <p class="mt-1 text-lg font-bold text-violet-700">
            {{ jumlahPembayaranMember }}
          </p>

        </div>


        <div class="rounded-xl bg-sky-50 p-4">

          <p class="text-xs text-sky-500">
            Transaksi Non-Member
          </p>

          <p class="mt-1 text-lg font-bold text-sky-700">
            {{ transaksiNonMember }}
          </p>

        </div>


        <div class="rounded-xl bg-slate-50 p-4">

          <p class="text-xs text-slate-500">
            Total Pendapatan
          </p>

          <p class="mt-1 text-lg font-bold text-[#172033]">
            {{ formatRupiah(totalPendapatan) }}
          </p>

        </div>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- MEMBER + PETUGAS -->
    <!-- ===================================================== -->
    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

      <!-- MEMBER -->
      <div class="rounded-2xl border border-violet-100 bg-white p-5 shadow-sm">

        <div class="mb-5 flex items-center justify-between">

          <div>

            <h2 class="text-lg font-bold text-[#172033]">
              Statistik Member
            </h2>

            <p class="text-sm text-slate-500">
              Kondisi pembayaran member.
            </p>

          </div>

          <div class="rounded-xl bg-violet-100 p-3">

            <svg
              class="h-5 w-5 text-violet-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM5 21a7 7 0 0114 0"
              />
            </svg>

          </div>

        </div>


        <div class="grid grid-cols-2 gap-4">

          <div class="rounded-xl bg-violet-50 p-4">

            <p class="text-xs text-violet-500">
              Total Member
            </p>

            <p class="mt-1 text-2xl font-bold text-violet-700">
              {{ totalMember }}
            </p>

          </div>


          <div class="rounded-xl bg-green-50 p-4">

            <p class="text-xs text-green-500">
              Lunas
            </p>

            <p class="mt-1 text-2xl font-bold text-green-600">
              {{ memberLunas }}
            </p>

          </div>


          <div class="rounded-xl bg-amber-50 p-4">

            <p class="text-xs text-amber-500">
              Belum Lunas
            </p>

            <p class="mt-1 text-2xl font-bold text-amber-600">
              {{ memberBelumLunas }}
            </p>

          </div>


          <div class="rounded-xl bg-red-50 p-4">

            <p class="text-xs text-red-500">
              Expired
            </p>

            <p class="mt-1 text-2xl font-bold text-red-600">
              {{ memberExpired }}
            </p>

          </div>

        </div>

      </div>


      <!-- PETUGAS -->
      <div class="rounded-2xl border border-sky-100 bg-white p-5 shadow-sm">

        <div class="mb-5 flex items-center justify-between">

          <div>

            <h2 class="text-lg font-bold text-[#172033]">
              Statistik Petugas
            </h2>

            <p class="text-sm text-slate-500">
              Jumlah petugas yang terdaftar.
            </p>

          </div>

          <div class="rounded-xl bg-sky-100 p-3">

            <svg
              class="h-5 w-5 text-sky-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-5a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6zM9 20a5 5 0 0110 0"
              />
            </svg>

          </div>

        </div>


        <div class="grid grid-cols-2 gap-4">

          <div class="rounded-xl bg-sky-50 p-4">

            <p class="text-xs text-sky-500">
              Total Petugas
            </p>

            <p class="mt-1 text-2xl font-bold text-sky-700">
              {{ totalPetugas }}
            </p>

          </div>


          <div class="rounded-xl bg-slate-50 p-4">

            <p class="text-xs text-slate-500">
              Total Transaksi
            </p>

            <p class="mt-1 text-2xl font-bold text-[#172033]">
              {{ totalTransaksi }}
            </p>

          </div>


          <div class="rounded-xl bg-green-50 p-4">

            <p class="text-xs text-green-500">
              Kendaraan Keluar
            </p>

            <p class="mt-1 text-2xl font-bold text-green-600">
              {{ totalKeluar }}
            </p>

          </div>


          <div class="rounded-xl bg-amber-50 p-4">

            <p class="text-xs text-amber-500">
              Kendaraan Masuk
            </p>

            <p class="mt-1 text-2xl font-bold text-amber-600">
              {{ totalMasuk }}
            </p>

          </div>

        </div>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- KONDISI PARKIR -->
    <!-- ===================================================== -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

      <div class="mb-5">

        <h2 class="text-lg font-bold text-[#172033]">
          Kondisi Parkir Saat Ini
        </h2>

        <p class="text-sm text-slate-500">
          Perbandingan kendaraan yang masih masuk dan yang sudah keluar.
        </p>

      </div>


      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        <div class="rounded-xl bg-amber-50 p-5">

          <p class="text-sm text-amber-600">
            Sedang Parkir
          </p>

          <p class="mt-1 text-3xl font-bold text-amber-700">
            {{ totalMasuk }}
          </p>

        </div>


        <div class="rounded-xl bg-green-50 p-5">

          <p class="text-sm text-green-600">
            Sudah Keluar
          </p>

          <p class="mt-1 text-3xl font-bold text-green-700">
            {{ totalKeluar }}
          </p>

        </div>


        <div class="rounded-xl bg-slate-50 p-5">

          <p class="text-sm text-slate-500">
            Total Aktivitas
          </p>

          <p class="mt-1 text-3xl font-bold text-[#172033]">
            {{ totalAktivitas }}
          </p>

        </div>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- 7 HARI -->
    <!-- ===================================================== -->
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

      <div class="mb-6">

        <h2 class="text-lg font-bold text-[#172033]">
          Aktivitas 7 Hari Terakhir
        </h2>

        <p class="text-sm text-slate-500">
          Jumlah transaksi non-member yang sudah selesai.
        </p>

      </div>


      <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4 xl:grid-cols-7">

        <div
          v-for="item in grafik7Hari"
          :key="item.tanggal"
          class="rounded-xl border border-slate-100 bg-slate-50 p-4"
        >

          <p class="text-xs font-semibold text-slate-400">
            {{ item.label }}
          </p>

          <p class="mt-2 text-xl font-bold text-[#172033]">
            {{ item.jumlah }}
          </p>

          <p class="text-xs text-sky-600">
            transaksi
          </p>

          <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-200">

            <div
              class="h-full rounded-full bg-sky-500 transition-all duration-500"
              :style="{ width: item.persentase + '%' }"
            ></div>

          </div>

        </div>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- MONITORING TERBARU -->
    <!-- ===================================================== -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

      <div class="border-b border-slate-100 p-5">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

          <div>

            <h2 class="text-lg font-bold text-[#172033]">
              Monitoring Terbaru
            </h2>

            <p class="text-sm text-slate-500">
              Aktivitas parkir terbaru berdasarkan kategori pengguna.
            </p>

          </div>


          <!-- TAB MEMBER / NON MEMBER -->
          <div class="flex gap-2 rounded-2xl bg-slate-100 p-1.5 w-fit">

            <!-- MEMBER -->
            <button
              @click="gantiMonitoring('member')"
              :class="[
                'rounded-xl px-4 py-2.5 text-xs md:text-sm font-bold transition',
                jenisMonitoring === 'member'
                  ? 'bg-violet-500 text-white shadow-md shadow-violet-500/20'
                  : 'text-slate-500 hover:bg-white hover:text-slate-700'
              ]"
            >
              👤 Member
            </button>


            <!-- NON MEMBER -->
            <button
              @click="gantiMonitoring('non-member')"
              :class="[
                'rounded-xl px-4 py-2.5 text-xs md:text-sm font-bold transition',
                jenisMonitoring === 'non-member'
                  ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20'
                  : 'text-slate-500 hover:bg-white hover:text-slate-700'
              ]"
            >
              🚗 Non-Member
            </button>

          </div>

        </div>

      </div>


      <!-- ===================================================== -->
      <!-- INFO DATA -->
      <!-- ===================================================== -->
      <div class="flex flex-col gap-3 border-b border-slate-100 bg-slate-50/60 px-5 py-4 md:flex-row md:items-center md:justify-between">

        <div>

          <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
            Kategori Monitoring
          </p>

          <p
            v-if="jenisMonitoring === 'member'"
            class="mt-1 text-sm font-bold text-violet-600"
          >
            👤 Aktivitas Member
          </p>

          <p
            v-else
            class="mt-1 text-sm font-bold text-sky-600"
          >
            🚗 Aktivitas Non-Member
          </p>

        </div>


        <div
          :class="[
            'rounded-full px-3 py-1.5 text-xs font-bold',
            jenisMonitoring === 'member'
              ? 'bg-violet-100 text-violet-700'
              : 'bg-sky-100 text-sky-700'
          ]"
        >
          {{ dataMonitoring.length }} Data
        </div>

      </div>


      <!-- ===================================================== -->
      <!-- TABLE -->
      <!-- ===================================================== -->
      <div class="overflow-x-auto">

        <table class="min-w-full text-left text-sm">

          <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

            <tr>

              <th class="px-5 py-4 font-semibold">
                Tiket
              </th>

              <th class="px-5 py-4 font-semibold">
                Pengguna
              </th>

              <th class="px-5 py-4 font-semibold">
                Kendaraan
              </th>

              <th class="px-5 py-4 font-semibold">
                Status
              </th>

              <th class="px-5 py-4 font-semibold">
                Waktu
              </th>

              <th class="px-5 py-4 text-right font-semibold">
                Pendapatan
              </th>

            </tr>

          </thead>


          <tbody class="divide-y divide-slate-100">

            <tr
              v-for="item in dataMonitoringPagination"
              :key="item.id"
              class="transition hover:bg-slate-50"
            >

              <!-- TIKET -->
              <td class="whitespace-nowrap px-5 py-4">

                <div>

                  <p class="font-bold text-[#172033]">
                    {{ item.kode_tiket || '-' }}
                  </p>

                  <p class="text-xs text-slate-400">
                    #{{ item.id || '-' }}
                  </p>

                </div>

              </td>


              <!-- PENGGUNA -->
              <td class="whitespace-nowrap px-5 py-4">

                <span
                  v-if="item.member_id"
                  class="inline-flex items-center gap-2 rounded-full bg-violet-100 px-3 py-1.5 text-xs font-bold text-violet-700"
                >
                  <span class="h-2 w-2 rounded-full bg-violet-500"></span>
                  MEMBER
                </span>


                <span
                  v-else
                  class="inline-flex items-center gap-2 rounded-full bg-sky-100 px-3 py-1.5 text-xs font-bold text-sky-700"
                >
                  <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                  NON-MEMBER
                </span>

              </td>


              <!-- KENDARAAN -->
              <td class="whitespace-nowrap px-5 py-4">

                <div>

                  <p class="font-semibold text-slate-700">
                    {{ item.jenis_kendaraan || '-' }}
                  </p>

                  <p class="text-xs text-slate-400">
                    {{ item.no_polisi || '-' }}
                  </p>

                </div>

              </td>


              <!-- STATUS -->
              <td class="whitespace-nowrap px-5 py-4">

                <span
                  v-if="String(item.status || '').toLowerCase() === 'masuk'"
                  class="inline-flex rounded-full bg-amber-100 px-3 py-1.5 text-xs font-bold text-amber-700"
                >
                  MASUK
                </span>


                <span
                  v-else
                  class="inline-flex rounded-full bg-green-100 px-3 py-1.5 text-xs font-bold text-green-700"
                >
                  KELUAR
                </span>

              </td>


              <!-- WAKTU -->
              <td class="whitespace-nowrap px-5 py-4">

                <div>

                  <p class="font-medium text-slate-700">
                    {{ formatTanggal(item.waktu_keluar || item.waktu_masuk) }}
                  </p>

                  <p class="text-xs text-slate-400">
                    {{ formatJam(item.waktu_keluar || item.waktu_masuk) }}
                  </p>

                </div>

              </td>


              <!-- PENDAPATAN -->
              <td class="whitespace-nowrap px-5 py-4 text-right">

                <!-- MEMBER -->
                <div v-if="item.member_id">

                  <span
                    class="inline-flex rounded-full bg-violet-100 px-3 py-1.5 text-xs font-bold text-violet-700"
                  >
                    Aktivitas Member
                  </span>

                  <p class="mt-1 text-xs text-slate-400">
                    Bukan pembayaran membership
                  </p>

                </div>


                <!-- NON MEMBER -->
                <div
                  v-else-if="String(item.status || '').toLowerCase() === 'keluar'"
                >

                  <p class="font-bold text-sky-600">
                    {{ formatRupiah(hitungHargaTiket(item)) }}
                  </p>

                  <p class="mt-1 text-xs text-slate-400">
                    Parkir Non-Member
                  </p>

                </div>


                <!-- MASIH MASUK -->
                <span
                  v-else
                  class="text-slate-400"
                >
                  —
                </span>

              </td>

            </tr>


            <!-- EMPTY -->
            <tr v-if="dataMonitoringPagination.length === 0">

              <td
                colspan="6"
                class="px-5 py-12 text-center"
              >

                <div class="mx-auto max-w-sm">

                  <div
                    :class="[
                      'mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full',
                      jenisMonitoring === 'member'
                        ? 'bg-violet-100'
                        : 'bg-sky-100'
                    ]"
                  >

                    <span class="text-2xl">
                      {{ jenisMonitoring === 'member' ? '👤' : '🚗' }}
                    </span>

                  </div>

                  <p class="font-semibold text-slate-600">
                    {{
                      jenisMonitoring === 'member'
                        ? 'Belum ada aktivitas member'
                        : 'Belum ada aktivitas non-member'
                    }}
                  </p>

                  <p class="mt-1 text-sm text-slate-400">
                    Data sesuai kategori dan periode yang dipilih akan muncul di sini.
                  </p>

                </div>

              </td>

            </tr>

          </tbody>

        </table>

      </div>


      <!-- ===================================================== -->
      <!-- PAGINATION -->
      <!-- ===================================================== -->
      <div
        v-if="dataMonitoring.length > itemsPerPage"
        class="flex flex-col gap-4 border-t border-slate-100 px-5 py-5 md:flex-row md:items-center md:justify-between"
      >

        <p class="text-xs text-slate-400">

          Menampilkan

          <span class="font-bold text-slate-600">
            {{ startItemMonitoring }}
          </span>

          -

          <span class="font-bold text-slate-600">
            {{ endItemMonitoring }}
          </span>

          dari

          <span class="font-bold text-slate-600">
            {{ dataMonitoring.length }}
          </span>

          transaksi

        </p>


        <div class="flex items-center gap-1.5">

          <!-- PREVIOUS -->
          <button
            @click="halamanSebelumnyaMonitoring"
            :disabled="currentPageMonitoring === 1"
            class="h-9 w-9 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
          >
            ←
          </button>


          <!-- PAGE NUMBER -->
          <button
            v-for="halaman in totalPagesMonitoring"
            :key="halaman"
            @click="pilihHalamanMonitoring(halaman)"
            :class="[
              'h-9 w-9 rounded-xl text-sm font-bold transition',
              currentPageMonitoring === halaman
                ? jenisMonitoring === 'member'
                  ? 'bg-violet-500 text-white shadow-md shadow-violet-500/20'
                  : 'bg-sky-500 text-white shadow-md shadow-sky-500/20'
                : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
            ]"
          >
            {{ halaman }}
          </button>


          <!-- NEXT -->
          <button
            @click="halamanBerikutnyaMonitoring"
            :disabled="currentPageMonitoring === totalPagesMonitoring"
            class="h-9 w-9 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-600 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-40"
          >
            →
          </button>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import {
  computed,
  onMounted,
  ref,
  watch
} from 'vue'


const { $api } = useNuxtApp()


// ============================================================
// STATE
// ============================================================

const loading = ref(false)

const tiket = ref<any[]>([])
const member = ref<any[]>([])
const petugas = ref<any[]>([])

const tiketFilter = ref<any[]>([])
const memberFilter = ref<any[]>([])

const periode = ref('bulan')
const filterStatus = ref('semua')
const filterKendaraan = ref('semua')


// ============================================================
// PAGINATION MONITORING
// ============================================================

const itemsPerPage = 10

const jenisMonitoring = ref<
  'member' | 'non-member'
>('non-member')

const currentPageMonitoring = ref(1)


// ============================================================
// RUPIAH
// ============================================================

const formatRupiah = (
  angka: number | string
) => {

  const nilai = Number(angka || 0)

  return new Intl.NumberFormat(
    'id-ID',
    {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0
    }
  ).format(nilai)

}


// ============================================================
// PARSE TANGGAL LARAVEL
// ============================================================

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


// ============================================================
// TANGGAL
// ============================================================

const formatTanggal = (
  tanggal: string | null | undefined
) => {

  const date =
    parseTanggalLaravel(tanggal)


  if (!date) {
    return '-'
  }


  return date.toLocaleDateString(
    'id-ID',
    {
      day: '2-digit',
      month: 'short',
      year: 'numeric'
    }
  )

}


// ============================================================
// JAM
// ============================================================

const formatJam = (
  tanggal: string | null | undefined
) => {

  const date =
    parseTanggalLaravel(tanggal)


  if (!date) {
    return '-'
  }


  return date.toLocaleTimeString(
    'id-ID',
    {
      hour: '2-digit',
      minute: '2-digit'
    }
  )

}


// ============================================================
// PERIODE TIKET
// ============================================================

const sesuaiPeriode = (
  item: any
) => {

  if (periode.value === 'semua') {
    return true
  }


  const sumberTanggal =
    item.waktu_keluar ||
    item.waktu_masuk


  const tanggal =
    parseTanggalLaravel(
      sumberTanggal
    )


  if (!tanggal) {
    return false
  }


  const sekarang =
    new Date()


  // HARI
  if (
    periode.value === 'hari'
  ) {

    return (
      tanggal.getDate() ===
        sekarang.getDate() &&

      tanggal.getMonth() ===
        sekarang.getMonth() &&

      tanggal.getFullYear() ===
        sekarang.getFullYear()
    )

  }


  // MINGGU
  if (
    periode.value === 'minggu'
  ) {

    const awalMinggu =
      new Date(sekarang)


    const hari =
      awalMinggu.getDay()


    const selisihSenin =
      hari === 0
        ? 6
        : hari - 1


    awalMinggu.setDate(
      awalMinggu.getDate() -
      selisihSenin
    )


    awalMinggu.setHours(
      0,
      0,
      0,
      0
    )


    const akhirMinggu =
      new Date(awalMinggu)


    akhirMinggu.setDate(
      akhirMinggu.getDate() + 6
    )


    akhirMinggu.setHours(
      23,
      59,
      59,
      999
    )


    return (
      tanggal >= awalMinggu &&
      tanggal <= akhirMinggu
    )

  }


  // BULAN INI
  if (
    periode.value === 'bulan'
  ) {

    return (
      tanggal.getMonth() ===
        sekarang.getMonth() &&

      tanggal.getFullYear() ===
        sekarang.getFullYear()
    )

  }


  // BULAN LALU
  if (
    periode.value === 'bulan_lalu'
  ) {

    const bulanLalu =
      new Date(
        sekarang.getFullYear(),
        sekarang.getMonth() - 1,
        1
      )


    const awalBulanLalu =
      new Date(
        bulanLalu.getFullYear(),
        bulanLalu.getMonth(),
        1,
        0,
        0,
        0,
        0
      )


    const akhirBulanLalu =
      new Date(
        bulanLalu.getFullYear(),
        bulanLalu.getMonth() + 1,
        0,
        23,
        59,
        59,
        999
      )


    return (
      tanggal >= awalBulanLalu &&
      tanggal <= akhirBulanLalu
    )

  }


  return true

}


// ============================================================
// PERIODE MEMBER
// ============================================================

const sesuaiPeriodeMember = (
  item: any
) => {

  if (
    String(item.status || '').toLowerCase()
    !== 'lunas'
  ) {
    return false
  }


  const sumberTanggal =
    item.tanggal_bayar ||
    item.tanggal_mulai


  if (!sumberTanggal) {
    return false
  }


  if (
    periode.value === 'semua'
  ) {
    return true
  }


  const tanggal =
    parseTanggalLaravel(
      sumberTanggal
    )


  if (!tanggal) {
    return false
  }


  const sekarang =
    new Date()


  // HARI
  if (
    periode.value === 'hari'
  ) {

    return (
      tanggal.getDate() ===
        sekarang.getDate() &&

      tanggal.getMonth() ===
        sekarang.getMonth() &&

      tanggal.getFullYear() ===
        sekarang.getFullYear()
    )

  }


  // MINGGU
  if (
    periode.value === 'minggu'
  ) {

    const awalMinggu =
      new Date(sekarang)


    const hari =
      awalMinggu.getDay()


    const selisihSenin =
      hari === 0
        ? 6
        : hari - 1


    awalMinggu.setDate(
      awalMinggu.getDate() -
      selisihSenin
    )


    awalMinggu.setHours(
      0,
      0,
      0,
      0
    )


    const akhirMinggu =
      new Date(awalMinggu)


    akhirMinggu.setDate(
      akhirMinggu.getDate() + 6
    )


    akhirMinggu.setHours(
      23,
      59,
      59,
      999
    )


    return (
      tanggal >= awalMinggu &&
      tanggal <= akhirMinggu
    )

  }


  // BULAN INI
  if (
    periode.value === 'bulan'
  ) {

    return (
      tanggal.getMonth() ===
        sekarang.getMonth() &&

      tanggal.getFullYear() ===
        sekarang.getFullYear()
    )

  }


  // BULAN LALU
  if (
    periode.value === 'bulan_lalu'
  ) {

    const bulanLalu =
      new Date(
        sekarang.getFullYear(),
        sekarang.getMonth() - 1,
        1
      )


    const awalBulanLalu =
      new Date(
        bulanLalu.getFullYear(),
        bulanLalu.getMonth(),
        1,
        0,
        0,
        0,
        0
      )


    const akhirBulanLalu =
      new Date(
        bulanLalu.getFullYear(),
        bulanLalu.getMonth() + 1,
        0,
        23,
        59,
        59,
        999
      )


    return (
      tanggal >= awalBulanLalu &&
      tanggal <= akhirBulanLalu
    )

  }


  return true

}


// ============================================================
// LABEL PERIODE
// ============================================================

const labelPeriode =
  computed(() => {

    if (
      periode.value === 'hari'
    ) {
      return 'Hari Ini'
    }


    if (
      periode.value === 'minggu'
    ) {
      return 'Minggu Ini'
    }


    if (
      periode.value === 'bulan'
    ) {
      return 'Bulan Ini'
    }


    if (
      periode.value === 'bulan_lalu'
    ) {

      const sekarang =
        new Date()


      const bulanLalu =
        new Date(
          sekarang.getFullYear(),
          sekarang.getMonth() - 1,
          1
        )


      return bulanLalu.toLocaleDateString(
        'id-ID',
        {
          month: 'long',
          year: 'numeric'
        }
      )

    }


    return 'Semua Data'

  })


// ============================================================
// PROSES DATA
// ============================================================

const prosesData = () => {

  const hasilTiket =
    tiket.value.filter(
      (item: any) => {

        if (
          !sesuaiPeriode(item)
        ) {
          return false
        }


        if (
          filterStatus.value !== 'semua' &&
          String(
            item.status || ''
          ).toLowerCase()
          !== filterStatus.value
        ) {
          return false
        }


        if (
          filterKendaraan.value !== 'semua' &&
          String(
            item.jenis_kendaraan || ''
          ).toLowerCase()
          !== filterKendaraan.value.toLowerCase()
        ) {
          return false
        }


        return true

      }
    )


  tiketFilter.value =
    hasilTiket


  memberFilter.value =
    member.value.filter(
      (item: any) => {

        return sesuaiPeriodeMember(item)

      }
    )


  // KEMBALI KE HALAMAN 1
  currentPageMonitoring.value = 1

}


// ============================================================
// AMBIL DATA
// ============================================================

const ambilData = async () => {

  loading.value = true


  try {

    const [
      resTiket,
      resMember,
      resPetugas
    ] = await Promise.all([

      $api.get('/tiket'),

      $api.get('/member'),

      $api.get('/petugas')

    ])


    // TIKET
    const dataTiket =
      resTiket?.data?.data ??
      resTiket?.data ??
      []


    tiket.value =
      Array.isArray(dataTiket)
        ? dataTiket
        : []


    // MEMBER
    const dataMember =
      resMember?.data?.data ??
      resMember?.data ??
      []


    member.value =
      Array.isArray(dataMember)
        ? dataMember
        : []


    // PETUGAS
    const dataPetugas =
      resPetugas?.data?.data ??
      resPetugas?.data ??
      []


    petugas.value =
      Array.isArray(dataPetugas)
        ? dataPetugas
        : []


    prosesData()

  } catch (error) {

    console.error(
      'Gagal mengambil laporan:',
      error
    )


    tiket.value = []
    member.value = []
    petugas.value = []

    tiketFilter.value = []
    memberFilter.value = []

  } finally {

    loading.value = false

  }

}


// ============================================================
// HITUNG HARGA TIKET NON-MEMBER
// ============================================================

const hitungHargaTiket = (
  item: any
) => {

  const totalBackend =
    Number(
      item.total_harga || 0
    )


  if (
    totalBackend > 0
  ) {
    return totalBackend
  }


  const durasi =
    Math.max(
      1,
      Number(
        item.durasi || 1
      )
    )


  // MOBIL
  if (
    String(
      item.jenis_kendaraan || ''
    ).toLowerCase()
    === 'mobil'
  ) {

    return durasi * 5000

  }


  // MOTOR
  return durasi * 3000

}


// ============================================================
// PENDAPATAN MEMBER
// ============================================================

const pendapatanMember =
  computed(() => {

    return memberFilter.value.reduce(
      (
        total: number,
        item: any
      ) => {

        const harga =
          Number(
            item.total_harga || 150000
          )


        return total + harga

      },
      0
    )

  })


// ============================================================
// JUMLAH PEMBAYARAN MEMBER
// ============================================================

const jumlahPembayaranMember =
  computed(() => {

    return memberFilter.value.length

  })


// ============================================================
// PENDAPATAN NON-MEMBER
// ============================================================

const pendapatanNonMember =
  computed(() => {

    return tiketFilter.value
      .filter(
        (item: any) => {

          if (
            item.member_id
          ) {
            return false
          }


          return (
            String(
              item.status || ''
            ).toLowerCase()
            === 'keluar'
          )

        }
      )
      .reduce(
        (
          total: number,
          item: any
        ) => {

          return (
            total +
            hitungHargaTiket(item)
          )

        },
        0
      )

  })


// ============================================================
// TRANSAKSI NON-MEMBER
// ============================================================

const transaksiNonMember =
  computed(() => {

    return tiketFilter.value.filter(
      (item: any) => {

        if (
          item.member_id
        ) {
          return false
        }


        return (
          String(
            item.status || ''
          ).toLowerCase()
          === 'keluar'
        )

      }
    ).length

  })


// ============================================================
// TOTAL PENDAPATAN
// ============================================================

const totalPendapatan =
  computed(() => {

    return (
      pendapatanMember.value +
      pendapatanNonMember.value
    )

  })


// ============================================================
// PERSENTASE MEMBER
// ============================================================

const persentaseMember =
  computed(() => {

    if (
      totalPendapatan.value === 0
    ) {
      return 0
    }


    return Math.round(
      (
        pendapatanMember.value /
        totalPendapatan.value
      ) * 100
    )

  })


// ============================================================
// PERSENTASE NON MEMBER
// ============================================================

const persentaseNonMember =
  computed(() => {

    if (
      totalPendapatan.value === 0
    ) {
      return 0
    }


    return Math.round(
      (
        pendapatanNonMember.value /
        totalPendapatan.value
      ) * 100
    )

  })


// ============================================================
// TOTAL MEMBER
// ============================================================

const totalMember =
  computed(() => {

    return member.value.length

  })


// ============================================================
// MEMBER LUNAS
// ============================================================

const memberLunas =
  computed(() => {

    return member.value.filter(
      (item: any) => {

        return (
          String(
            item.status || ''
          ).toLowerCase()
          === 'lunas'
        )

      }
    ).length

  })


// ============================================================
// MEMBER BELUM LUNAS
// ============================================================

const memberBelumLunas =
  computed(() => {

    return member.value.filter(
      (item: any) => {

        return (
          String(
            item.status || ''
          ).toLowerCase()
          !== 'lunas'
        )

      }
    ).length

  })


// ============================================================
// MEMBER EXPIRED
// ============================================================

const memberExpired =
  computed(() => {

    const sekarang =
      new Date()


    return member.value.filter(
      (item: any) => {

        if (
          !item.tanggal_expired
        ) {
          return false
        }


        const expired =
          parseTanggalLaravel(
            item.tanggal_expired
          )


        if (!expired) {
          return false
        }


        return expired < sekarang

      }
    ).length

  })


// ============================================================
// PETUGAS
// ============================================================

const totalPetugas =
  computed(() => {

    return petugas.value.length

  })


// ============================================================
// TOTAL TRANSAKSI
// ============================================================

const totalTransaksi =
  computed(() => {

    return tiketFilter.value.length

  })


// ============================================================
// TOTAL KELUAR
// ============================================================

const totalKeluar =
  computed(() => {

    return tiketFilter.value.filter(
      (item: any) => {

        return (
          String(
            item.status || ''
          ).toLowerCase()
          === 'keluar'
        )

      }
    ).length

  })


// ============================================================
// TOTAL MASUK
// ============================================================

const totalMasuk =
  computed(() => {

    return tiketFilter.value.filter(
      (item: any) => {

        return (
          String(
            item.status || ''
          ).toLowerCase()
          === 'masuk'
        )

      }
    ).length

  })


// ============================================================
// TOTAL AKTIVITAS
// ============================================================

const totalAktivitas =
  computed(() => {

    return tiketFilter.value.length

  })


// ============================================================
// DATA MONITORING MEMBER
// ============================================================

const monitoringMember =
  computed(() => {

    return [...tiketFilter.value]
      .filter(
        (item: any) =>
          !!item.member_id
      )
      .sort(
        (
          a: any,
          b: any
        ) => {

          const tanggalA =
            parseTanggalLaravel(
              a.waktu_keluar ||
              a.waktu_masuk
            )?.getTime() || 0


          const tanggalB =
            parseTanggalLaravel(
              b.waktu_keluar ||
              b.waktu_masuk
            )?.getTime() || 0


          return tanggalB - tanggalA

        }
      )

  })


// ============================================================
// DATA MONITORING NON MEMBER
// ============================================================

const monitoringNonMember =
  computed(() => {

    return [...tiketFilter.value]
      .filter(
        (item: any) =>
          !item.member_id
      )
      .sort(
        (
          a: any,
          b: any
        ) => {

          const tanggalA =
            parseTanggalLaravel(
              a.waktu_keluar ||
              a.waktu_masuk
            )?.getTime() || 0


          const tanggalB =
            parseTanggalLaravel(
              b.waktu_keluar ||
              b.waktu_masuk
            )?.getTime() || 0


          return tanggalB - tanggalA

        }
      )

  })


// ============================================================
// DATA MONITORING AKTIF
// ============================================================

const dataMonitoring =
  computed(() => {

    if (
      jenisMonitoring.value === 'member'
    ) {
      return monitoringMember.value
    }


    return monitoringNonMember.value

  })


// ============================================================
// PAGINATION MONITORING
// ============================================================

const totalPagesMonitoring =
  computed(() => {

    return Math.max(
      1,
      Math.ceil(
        dataMonitoring.value.length /
        itemsPerPage
      )
    )

  })


const dataMonitoringPagination =
  computed(() => {

    const start =
      (
        currentPageMonitoring.value - 1
      ) * itemsPerPage


    return dataMonitoring.value.slice(
      start,
      start + itemsPerPage
    )

  })


const startItemMonitoring =
  computed(() => {

    if (
      dataMonitoring.value.length === 0
    ) {
      return 0
    }


    return (
      (
        currentPageMonitoring.value - 1
      ) * itemsPerPage
    ) + 1

  })


const endItemMonitoring =
  computed(() => {

    return Math.min(
      currentPageMonitoring.value *
        itemsPerPage,

      dataMonitoring.value.length
    )

  })


function halamanSebelumnyaMonitoring() {

  if (
    currentPageMonitoring.value > 1
  ) {

    currentPageMonitoring.value--

  }

}


function halamanBerikutnyaMonitoring() {

  if (
    currentPageMonitoring.value <
    totalPagesMonitoring.value
  ) {

    currentPageMonitoring.value++

  }

}


function pilihHalamanMonitoring(
  halaman: number
) {

  if (
    halaman >= 1 &&
    halaman <= totalPagesMonitoring.value
  ) {

    currentPageMonitoring.value =
      halaman

  }

}


// ============================================================
// GANTI TAB MONITORING
// ============================================================

function gantiMonitoring(
  jenis:
    'member' |
    'non-member'
) {

  jenisMonitoring.value =
    jenis


  currentPageMonitoring.value =
    1

}


// ============================================================
// TRANSAKSI TERBARU
// ============================================================

const transaksiTerbaru =
  computed(() => {

    return [...tiketFilter.value]
      .sort(
        (
          a: any,
          b: any
        ) => {

          const tanggalA =
            parseTanggalLaravel(
              a.waktu_keluar ||
              a.waktu_masuk
            )?.getTime() || 0


          const tanggalB =
            parseTanggalLaravel(
              b.waktu_keluar ||
              b.waktu_masuk
            )?.getTime() || 0


          return tanggalB - tanggalA

        }
      )
      .slice(0, 10)

  })


// ============================================================
// GRAFIK 7 HARI
// ============================================================

const grafik7Hari =
  computed(() => {

    const hasil: any[] = []

    const sekarang =
      new Date()


    for (
      let i = 6;
      i >= 0;
      i--
    ) {

      const tanggalTarget =
        new Date(sekarang)


      tanggalTarget.setDate(
        sekarang.getDate() - i
      )


      tanggalTarget.setHours(
        0,
        0,
        0,
        0
      )


      const tanggalBesok =
        new Date(tanggalTarget)


      tanggalBesok.setDate(
        tanggalTarget.getDate() + 1
      )


      const jumlah =
        tiket.value.filter(
          (item: any) => {

            if (
              item.member_id
            ) {
              return false
            }


            if (
              String(
                item.status || ''
              ).toLowerCase()
              !== 'keluar'
            ) {
              return false
            }


            const sumberTanggal =
              item.waktu_keluar ||
              item.waktu_masuk


            const tanggal =
              parseTanggalLaravel(
                sumberTanggal
              )


            if (!tanggal) {
              return false
            }


            return (
              tanggal >= tanggalTarget &&
              tanggal < tanggalBesok
            )

          }
        ).length


      hasil.push({

        tanggal:
          tanggalTarget.toISOString(),

        label:
          tanggalTarget.toLocaleDateString(
            'id-ID',
            {
              day: '2-digit',
              month: 'short'
            }
          ),

        jumlah

      })

    }


    const maksimal =
      Math.max(
        ...hasil.map(
          (item) =>
            item.jumlah
        ),
        1
      )


    return hasil.map(
      (item) => {

        return {

          ...item,

          persentase:
            Math.max(
              8,
              Math.round(
                (
                  item.jumlah /
                  maksimal
                ) * 100
              )
            )

        }

      }
    )

  })


// ============================================================
// RESET PAGINATION KETIKA FILTER BERUBAH
// ============================================================

watch(
  [
    periode,
    filterStatus,
    filterKendaraan
  ],
  () => {

    currentPageMonitoring.value =
      1

  }
)


// ============================================================
// CETAK LAPORAN
// ============================================================

function cetakLaporan() {
  window.print()
}


// ============================================================
// LOAD
// ============================================================

onMounted(() => {

  ambilData()

})

</script>
<style>
@media print {
  body {
    background: white !important;
  }

  button,
  input,
  select {
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

  @page {
    size: A4;
    margin: 12mm;
  }
}
</style>
