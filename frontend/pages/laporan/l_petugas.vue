<template>
  <div class="min-h-screen bg-slate-100">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="bg-[#172033] text-white">

      <div class="max-w-7xl mx-auto px-5 md:px-8 py-7">

        <div
          class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5"
        >

          <div>

            <div class="flex items-center gap-3 mb-2">

              <div
                class="w-11 h-11 rounded-xl bg-[#38BDF8] text-white flex items-center justify-center text-xl shadow-lg"
              >
                📊
              </div>

              <div>

                <p
                  class="text-xs uppercase tracking-[0.18em] text-sky-300"
                >
                  PARKIR PLAZA ANDALAS
                </p>

                <h1 class="text-2xl md:text-3xl font-bold mt-1">
                  Laporan Petugas
                </h1>

              </div>

            </div>

            <p class="text-sm text-slate-300 max-w-2xl">
              Ringkasan aktivitas parkir, transaksi, kendaraan, dan pendapatan berdasarkan data sistem.
            </p>

          </div>


          <div class="flex flex-wrap gap-2">

            <button
              type="button"
              @click="ambilData"
              :disabled="loading"
              class="px-4 py-2.5 rounded-xl bg-[#38BDF8] hover:bg-sky-500 text-white font-semibold text-sm shadow-lg shadow-sky-900/20 transition disabled:opacity-50"
            >
              <span v-if="loading">
                Memuat...
              </span>

              <span v-else>
                ↻ Refresh
              </span>
            </button>


            <button
              type="button"
              @click="kembali"
              class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-white font-semibold text-sm transition"
            >
              ← Kembali
            </button>


            <!-- CETAK -->
            <button
              type="button"
              @click="cetakLaporan"
              class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm shadow-lg transition"
            >
              🖨️ Cetak
            </button>

          </div>

        </div>

      </div>

    </div>


    <!-- ===================================================== -->
    <!-- CONTENT -->
    <!-- ===================================================== -->

    <main class="max-w-7xl mx-auto px-5 md:px-8 py-6">


      <!-- ===================================================== -->
      <!-- PERIODE AKTIF -->
      <!-- ===================================================== -->

      <section
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-6"
      >

        <div
          class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5"
        >

          <div>

            <p
              class="text-xs uppercase tracking-wider font-semibold text-slate-400"
            >
              Periode Laporan
            </p>

            <h2 class="text-xl font-bold text-slate-800 mt-1">
              {{ namaBulanAktif }}
            </h2>

            <p class="text-sm text-slate-500 mt-1">
              Data pendapatan dihitung berdasarkan transaksi pada periode yang dipilih.
            </p>

          </div>


          <div class="flex flex-col sm:flex-row gap-3">

            <div>

              <label
                class="block text-xs font-semibold text-slate-600 mb-1.5"
              >
                Bulan Pendapatan
              </label>

              <input
                v-model="bulanDipilih"
                type="month"
                class="w-full sm:w-56 h-11 px-3 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400"
              />

            </div>


            <button
              type="button"
              @click="resetFilter"
              class="h-11 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition sm:self-end"
            >
              Reset Tanggal
            </button>

          </div>

        </div>


        <!-- FILTER TANGGAL -->
        <div
          class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5 pt-5 border-t border-slate-100"
        >

          <div>

            <label
              class="block text-xs font-semibold text-slate-600 mb-1.5"
            >
              Tanggal Mulai
            </label>

            <input
              v-model="tanggalMulai"
              type="date"
              class="w-full h-11 px-3 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400"
            />

          </div>


          <div>

            <label
              class="block text-xs font-semibold text-slate-600 mb-1.5"
            >
              Tanggal Akhir
            </label>

            <input
              v-model="tanggalAkhir"
              type="date"
              class="w-full h-11 px-3 rounded-xl border border-slate-300 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-sky-400 focus:border-sky-400"
            />

          </div>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- STATUS BAR -->
      <!-- ===================================================== -->

      <section
        class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"
      >

        <div
          class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm"
        >

          <p
            class="text-xs font-semibold uppercase tracking-wide text-slate-400"
          >
            Periode Aktif
          </p>

          <p class="text-base font-bold text-slate-800 mt-1">
            {{ namaBulanAktif }}
          </p>

        </div>


        <div
          class="bg-sky-50 border border-sky-100 rounded-2xl p-4"
        >

          <p
            class="text-xs font-semibold uppercase tracking-wide text-sky-500"
          >
            Pembayaran Membership
          </p>

          <p class="text-base font-bold text-sky-700 mt-1">
            {{ formatRupiah(totalPendapatanMember) }}
          </p>

        </div>


        <div
          class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4"
        >

          <p
            class="text-xs font-semibold uppercase tracking-wide text-emerald-500"
          >
            Parkir Non-Member
          </p>

          <p class="text-base font-bold text-emerald-700 mt-1">
            {{ formatRupiah(totalPendapatanNonMember) }}
          </p>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- STATISTIK UTAMA -->
      <!-- ===================================================== -->

      <section
        class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6"
      >

        <!-- TOTAL TRANSAKSI -->
        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <div class="flex items-start justify-between gap-3">

            <div>

              <p
                class="text-xs uppercase tracking-wide font-semibold text-slate-400"
              >
                Total Transaksi
              </p>

              <p class="text-3xl font-bold text-slate-800 mt-2">
                {{ totalTransaksi }}
              </p>

            </div>

            <div
              class="w-11 h-11 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl"
            >
              🎫
            </div>

          </div>

          <p class="text-xs text-slate-400 mt-4">
            Sesuai periode filter tanggal
          </p>

        </div>


        <!-- SEDANG PARKIR -->
        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <div class="flex items-start justify-between gap-3">

            <div>

              <p
                class="text-xs uppercase tracking-wide font-semibold text-slate-400"
              >
                Sedang Parkir
              </p>

              <p class="text-3xl font-bold text-amber-600 mt-2">
                {{ sedangParkir }}
              </p>

            </div>

            <div
              class="w-11 h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl"
            >
              🚗
            </div>

          </div>

          <p class="text-xs text-slate-400 mt-4">
            Tiket dengan status masuk
          </p>

        </div>


        <!-- SUDAH KELUAR -->
        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <div class="flex items-start justify-between gap-3">

            <div>

              <p
                class="text-xs uppercase tracking-wide font-semibold text-slate-400"
              >
                Sudah Keluar
              </p>

              <p class="text-3xl font-bold text-emerald-600 mt-2">
                {{ sudahKeluar }}
              </p>

            </div>

            <div
              class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl"
            >
              🚙
            </div>

          </div>

          <p class="text-xs text-slate-400 mt-4">
            Tiket dengan status keluar
          </p>

        </div>


        <!-- TOTAL PENDAPATAN -->
        <div
          class="bg-[#172033] border border-[#172033] rounded-2xl p-5 shadow-sm"
        >

          <div class="flex items-start justify-between gap-3">

            <div>

              <p
                class="text-xs uppercase tracking-wide font-semibold text-slate-400"
              >
                Total Pendapatan
              </p>

              <p class="text-xl font-bold text-white mt-3">
                {{ formatRupiah(totalPendapatanBulan) }}
              </p>

            </div>

            <div
              class="w-11 h-11 rounded-xl bg-sky-400/15 text-sky-300 flex items-center justify-center text-xl"
            >
              💰
            </div>

          </div>

          <p class="text-xs text-slate-400 mt-4">
            Membership + parkir non-member
          </p>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- PENDAPATAN -->
      <!-- ===================================================== -->

      <section
        class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6"
      >

        <!-- MEMBERSHIP -->
        <div
          class="relative overflow-hidden bg-white border border-sky-200 rounded-2xl p-6 shadow-sm"
        >

          <div
            class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-sky-50"
          ></div>

          <div class="relative flex items-start justify-between">

            <div>

              <div class="flex items-center gap-2">

                <span
                  class="w-2.5 h-2.5 rounded-full bg-sky-500"
                ></span>

                <p
                  class="text-xs uppercase tracking-wide font-bold text-slate-400"
                >
                  Pembayaran Membership
                </p>

              </div>

              <p class="text-3xl font-bold text-sky-600 mt-3">
                {{ formatRupiah(totalPendapatanMember) }}
              </p>

              <p class="text-sm text-slate-500 mt-2">
                {{ jumlahPembayaranMember }} pembayaran lunas pada bulan aktif.
              </p>

            </div>


            <div
              class="w-12 h-12 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl"
            >
              👤
            </div>

          </div>

        </div>


        <!-- NON MEMBER -->
        <div
          class="relative overflow-hidden bg-white border border-emerald-200 rounded-2xl p-6 shadow-sm"
        >

          <div
            class="absolute -right-10 -top-10 w-32 h-32 rounded-full bg-emerald-50"
          ></div>

          <div class="relative flex items-start justify-between">

            <div>

              <div class="flex items-center gap-2">

                <span
                  class="w-2.5 h-2.5 rounded-full bg-emerald-500"
                ></span>

                <p
                  class="text-xs uppercase tracking-wide font-bold text-slate-400"
                >
                  Parkir Non-Member
                </p>

              </div>

              <p class="text-3xl font-bold text-emerald-600 mt-3">
                {{ formatRupiah(totalPendapatanNonMember) }}
              </p>

              <p class="text-sm text-slate-500 mt-2">
                {{ jumlahTransaksiNonMemberBulan }} transaksi keluar pada bulan aktif.
              </p>

            </div>


            <div
              class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl"
            >
              🎫
            </div>

          </div>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- GRAFIK -->
      <!-- ===================================================== -->

      <section
        class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 md:p-6 mb-6"
      >

        <div
          class="flex flex-col md:flex-row md:items-end md:justify-between gap-4"
        >

          <div>

            <p
              class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
            >
              Analisis Pendapatan
            </p>

            <h2 class="text-xl font-bold text-slate-800 mt-1">
              Pendapatan Harian
            </h2>

            <p class="text-sm text-slate-500 mt-1">
              Perbandingan pembayaran membership dan parkir non-member.
            </p>

          </div>


          <div class="flex items-center gap-4">

            <div class="flex items-center gap-2">

              <span
                class="w-3 h-3 rounded-full bg-sky-500"
              ></span>

              <span
                class="text-xs font-semibold text-slate-600"
              >
                Membership
              </span>

            </div>


            <div class="flex items-center gap-2">

              <span
                class="w-3 h-3 rounded-full bg-emerald-500"
              ></span>

              <span
                class="text-xs font-semibold text-slate-600"
              >
                Non-Member
              </span>

            </div>

          </div>

        </div>


        <div
          v-if="pendapatanHarian.length"
          class="mt-6 overflow-x-auto"
        >

          <div
            class="min-w-250 h-90 flex items-end gap-1 px-4 pb-8 border-b border-slate-200"
          >

            <div
              v-for="item in pendapatanHarian"
              :key="item.tanggal"
              class="flex-1 h-full flex flex-col items-center justify-end"
            >

              <div
                class="h-72.5 w-full flex items-end justify-center"
              >

                <div
                  class="flex items-end justify-center gap-1 w-full h-full"
                >

                  <!-- MEMBER -->
                  <div
                    class="w-3 md:w-5 bg-sky-500 hover:bg-sky-600 rounded-t-md transition-all"
                    :style="{
                      height:
                        getBarHeight(item.memberTotal) + '%',
                      minHeight:
                        item.memberTotal > 0
                          ? '6px'
                          : '0px'
                    }"
                    :title="`Membership ${item.tanggalLabel}: ${formatRupiah(item.memberTotal)}`"
                  ></div>


                  <!-- NON MEMBER -->
                  <div
                    class="w-3 md:w-5 bg-emerald-500 hover:bg-emerald-600 rounded-t-md transition-all"
                    :style="{
                      height:
                        getBarHeight(item.nonMemberTotal) + '%',
                      minHeight:
                        item.nonMemberTotal > 0
                          ? '6px'
                          : '0px'
                    }"
                    :title="`Non-Member ${item.tanggalLabel}: ${formatRupiah(item.nonMemberTotal)}`"
                  ></div>

                </div>

              </div>


              <span
                class="mt-3 text-[10px] font-semibold text-slate-500"
              >
                {{ item.hari }}
              </span>

            </div>

          </div>

        </div>


        <div
          v-else
          class="py-14 text-center"
        >

          <div
            class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-2xl"
          >
            📊
          </div>

          <p class="font-semibold text-slate-700 mt-4">
            Belum ada data pendapatan
          </p>

          <p class="text-sm text-slate-400 mt-1">
            Belum ada transaksi pada bulan yang dipilih.
          </p>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- RINGKASAN PERFORMA -->
      <!-- ===================================================== -->

      <section
        class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"
      >

        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <p
            class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
          >
            Rata-rata Harian
          </p>

          <p class="text-2xl font-bold text-sky-600 mt-2">
            {{ formatRupiah(rataPendapatanHari) }}
          </p>

          <p class="text-xs text-slate-400 mt-2">
            Berdasarkan hari yang memiliki pendapatan.
          </p>

        </div>


        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <p
            class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
          >
            Pendapatan Tertinggi
          </p>

          <p class="text-2xl font-bold text-violet-600 mt-2">
            {{ formatRupiah(pendapatanTertinggi) }}
          </p>

          <p class="text-xs text-slate-400 mt-2">
            {{ tanggalPendapatanTertinggi }}
          </p>

        </div>


        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <p
            class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
          >
            Rata-rata Durasi
          </p>

          <p class="text-2xl font-bold text-amber-600 mt-2">
            {{ rataRataDurasi }} jam
          </p>

          <p class="text-xs text-slate-400 mt-2">
            Berdasarkan transaksi yang memiliki durasi.
          </p>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- STATISTIK KENDARAAN & PENGGUNA -->
      <!-- ===================================================== -->

      <section
        class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6"
      >

        <!-- KENDARAAN -->
        <div
          class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6"
        >

          <div
            class="flex items-start justify-between mb-6"
          >

            <div>

              <p
                class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
              >
                Distribusi Kendaraan
              </p>

              <h2
                class="text-xl font-bold text-slate-800 mt-1"
              >
                Motor & Mobil
              </h2>

            </div>

            <div
              class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-xl"
            >
              🚘
            </div>

          </div>


          <!-- MOTOR -->
          <div class="mb-6">

            <div
              class="flex items-center justify-between mb-2"
            >

              <div class="flex items-center gap-2">

                <span>🏍️</span>

                <span
                  class="text-sm font-semibold text-slate-700"
                >
                  Motor
                </span>

              </div>

              <span
                class="text-sm font-bold text-slate-800"
              >
                {{ jumlahMotor }}
              </span>

            </div>


            <div
              class="h-3 rounded-full bg-slate-100 overflow-hidden"
            >

              <div
                class="h-full bg-sky-500 rounded-full transition-all duration-500"
                :style="{
                  width:
                    persenMotor + '%'
                }"
              ></div>

            </div>


            <p class="text-xs text-slate-400 mt-2">
              {{ persenMotor }}% dari kendaraan pada periode filter.
            </p>

          </div>


          <!-- MOBIL -->
          <div>

            <div
              class="flex items-center justify-between mb-2"
            >

              <div class="flex items-center gap-2">

                <span>🚗</span>

                <span
                  class="text-sm font-semibold text-slate-700"
                >
                  Mobil
                </span>

              </div>

              <span
                class="text-sm font-bold text-slate-800"
              >
                {{ jumlahMobil }}
              </span>

            </div>


            <div
              class="h-3 rounded-full bg-slate-100 overflow-hidden"
            >

              <div
                class="h-full bg-emerald-500 rounded-full transition-all duration-500"
                :style="{
                  width:
                    persenMobil + '%'
                }"
              ></div>

            </div>


            <p class="text-xs text-slate-400 mt-2">
              {{ persenMobil }}% dari kendaraan pada periode filter.
            </p>

          </div>

        </div>


        <!-- PENGGUNA -->
        <div
          class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6"
        >

          <div
            class="flex items-start justify-between mb-6"
          >

            <div>

              <p
                class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
              >
                Distribusi Pengguna
              </p>

              <h2
                class="text-xl font-bold text-slate-800 mt-1"
              >
                Member & Non-Member
              </h2>

            </div>

            <div
              class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-xl"
            >
              👥
            </div>

          </div>


          <div
            class="flex flex-col sm:flex-row items-center justify-center gap-8"
          >

            <!-- DONUT -->
            <div class="relative shrink-0">

              <div
                class="w-44 h-44 rounded-full"
                :style="donutStyle"
              ></div>


              <div
                class="absolute inset-0 m-auto w-24 h-24 bg-white rounded-full flex flex-col items-center justify-center shadow-sm"
              >

                <span
                  class="text-2xl font-bold text-slate-800"
                >
                  {{ totalPengguna }}
                </span>

                <span
                  class="text-xs text-slate-500"
                >
                  Transaksi
                </span>

              </div>

            </div>


            <div class="space-y-5">

              <div class="flex items-center gap-3">

                <span
                  class="w-3 h-3 rounded-full bg-sky-500"
                ></span>

                <div>

                  <p
                    class="text-sm font-semibold text-slate-700"
                  >
                    Member
                  </p>

                  <p
                    class="text-xs text-slate-500"
                  >
                    {{ jumlahMember }} transaksi
                  </p>

                </div>

              </div>


              <div class="flex items-center gap-3">

                <span
                  class="w-3 h-3 rounded-full bg-emerald-500"
                ></span>

                <div>

                  <p
                    class="text-sm font-semibold text-slate-700"
                  >
                    Non-Member
                  </p>

                  <p
                    class="text-xs text-slate-500"
                  >
                    {{ jumlahNonMember }} transaksi
                  </p>

                </div>

              </div>


              <div
                class="pt-3 border-t border-slate-200"
              >

                <p class="text-xs text-slate-500">
                  Persentase Member
                </p>

                <p
                  class="text-lg font-bold text-sky-600"
                >
                  {{ persenMember }}%
                </p>

              </div>

            </div>

          </div>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- INFORMASI OPERASIONAL -->
      <!-- ===================================================== -->

      <section
        class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6"
      >

        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <p
            class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
          >
            Total Motor
          </p>

          <div
            class="flex items-end justify-between mt-3"
          >

            <p
              class="text-3xl font-bold text-slate-800"
            >
              {{ jumlahMotor }}
            </p>

            <span class="text-3xl">
              🏍️
            </span>

          </div>

        </div>


        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <p
            class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
          >
            Total Mobil
          </p>

          <div
            class="flex items-end justify-between mt-3"
          >

            <p
              class="text-3xl font-bold text-slate-800"
            >
              {{ jumlahMobil }}
            </p>

            <span class="text-3xl">
              🚗
            </span>

          </div>

        </div>


        <div
          class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm"
        >

          <p
            class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
          >
            Rata-rata Durasi
          </p>

          <div
            class="flex items-end justify-between mt-3"
          >

            <p
              class="text-3xl font-bold text-slate-800"
            >
              {{ rataRataDurasi }}

              <span
                class="text-base font-semibold text-slate-400"
              >
                jam
              </span>

            </p>

            <span class="text-3xl">
              ⏱️
            </span>

          </div>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- REKAP TRANSAKSI -->
      <!-- ===================================================== -->

      <section
        class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden"
      >

        <div
          class="px-5 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3"
        >

          <div>

            <p
              class="text-xs uppercase tracking-wide text-slate-400 font-semibold"
            >
              Detail Aktivitas
            </p>

            <h2 class="text-xl font-bold text-slate-800 mt-1">
              Rekap Transaksi
            </h2>

            <p class="text-sm text-slate-500 mt-1">
              {{ dataLaporan.length }} data ditemukan pada periode filter.
            </p>

          </div>


          <div
            class="px-3 py-2 rounded-xl bg-slate-100 text-slate-600 text-xs font-semibold"
          >
            {{ namaBulanAktif }}
          </div>

        </div>


        <!-- TABEL -->
        <div class="overflow-x-auto">

          <table class="w-full text-sm">

            <thead>

              <tr
                class="bg-slate-50 text-slate-500 text-left"
              >

                <th class="px-4 py-3 font-semibold">
                  No
                </th>

                <th class="px-4 py-3 font-semibold">
                  Kode Tiket
                </th>

                <th class="px-4 py-3 font-semibold">
                  Kendaraan
                </th>

                <th class="px-4 py-3 font-semibold">
                  No Polisi
                </th>

                <th class="px-4 py-3 font-semibold">
                  Waktu Masuk
                </th>

                <th class="px-4 py-3 font-semibold">
                  Waktu Keluar
                </th>

                <th class="px-4 py-3 font-semibold">
                  Durasi
                </th>

                <th class="px-4 py-3 font-semibold">
                  Total
                </th>

                <th class="px-4 py-3 font-semibold">
                  Jenis
                </th>

                <th class="px-4 py-3 font-semibold">
                  Status
                </th>

              </tr>

            </thead>


            <tbody>

              <tr
                v-for="(
                  item,
                  index
                ) in dataLaporanPagination"
                :key="item.id"
                class="border-t border-slate-100 hover:bg-slate-50 transition"
              >

                <td
                  class="px-4 py-3 text-slate-400"
                >
                  {{ startItem + index }}
                </td>


                <td class="px-4 py-3">

                  <span
                    class="font-bold text-sky-600"
                  >
                    {{ item.kode_tiket || '-' }}
                  </span>

                </td>


                <td
                  class="px-4 py-3 whitespace-nowrap"
                >

                  <span
                    v-if="
                      item.jenis_kendaraan ===
                      'Motor'
                    "
                  >
                    🏍️ Motor
                  </span>

                  <span
                    v-else-if="
                      item.jenis_kendaraan ===
                      'Mobil'
                    "
                  >
                    🚗 Mobil
                  </span>

                  <span v-else>
                    -
                  </span>

                </td>


                <td
                  class="px-4 py-3 font-semibold whitespace-nowrap"
                >
                  {{ item.no_polisi || '-' }}
                </td>


                <td
                  class="px-4 py-3 whitespace-nowrap text-slate-600"
                >
                  {{ formatTanggal(item.waktu_masuk) }}
                </td>


                <td
                  class="px-4 py-3 whitespace-nowrap text-slate-600"
                >
                  {{ formatTanggal(item.waktu_keluar) }}
                </td>


                <td
                  class="px-4 py-3 whitespace-nowrap"
                >

                  <span v-if="item.durasi">
                    {{ item.durasi }} jam
                  </span>

                  <span v-else>
                    -
                  </span>

                </td>


                <td
                  class="px-4 py-3 font-bold whitespace-nowrap"
                >

                  <span
                    v-if="item.member_id"
                  >

                    <span class="text-sky-600">
                      Aktivitas Member
                    </span>

                  </span>

                  <span v-else>
                    {{ formatRupiah(getTotal(item)) }}
                  </span>

                </td>


                <td class="px-4 py-3">

                  <span
                    v-if="item.member_id"
                    class="inline-flex px-2.5 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold"
                  >
                    MEMBER
                  </span>

                  <span
                    v-else
                    class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold"
                  >
                    NON-MEMBER
                  </span>

                </td>


                <td class="px-4 py-3">

                  <span
                    v-if="
                      item.status ===
                      'masuk'
                    "
                    class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold"
                  >
                    Masuk
                  </span>

                  <span
                    v-else
                    class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold"
                  >
                    Keluar
                  </span>

                </td>

              </tr>


              <tr
                v-if="
                  dataLaporan.length === 0
                "
              >

                <td
                  colspan="10"
                  class="px-4 py-14 text-center"
                >

                  <div
                    class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-2xl"
                  >
                    📋
                  </div>

                  <p
                    class="font-semibold text-slate-700 mt-4"
                  >
                    Tidak ada data transaksi
                  </p>

                  <p
                    class="text-sm text-slate-400 mt-1"
                  >
                    Coba ubah periode tanggal laporan.
                  </p>

                </td>

              </tr>

            </tbody>

          </table>

        </div>


        <!-- ===================================================== -->
        <!-- PAGINATION -->
        <!-- ===================================================== -->

        <div
          v-if="dataLaporan.length > 0"
          class="px-5 py-4 border-t border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4"
        >

          <p class="text-sm text-slate-500">

            Menampilkan

            <span
              class="font-bold text-slate-700"
            >
              {{ startItem }}–{{ endItem }}
            </span>

            dari

            <span
              class="font-bold text-slate-700"
            >
              {{ dataLaporan.length }}
            </span>

            transaksi

          </p>


          <div class="flex items-center gap-2">

            <button
              type="button"
              @click="halamanSebelumnya"
              :disabled="
                currentPage === 1
              "
              class="w-10 h-10 rounded-lg border border-slate-200 text-slate-600 font-bold hover:bg-slate-100 transition disabled:opacity-40 disabled:cursor-not-allowed"
            >
              ←
            </button>


            <button
              v-for="
                halaman in totalPages
              "
              :key="halaman"
              type="button"
              @click="
                pilihHalaman(halaman)
              "
              class="min-w-10 h-10 px-3 rounded-lg text-sm font-bold transition"
              :class="
                currentPage === halaman
                  ? 'bg-[#172033] text-white shadow'
                  : 'border border-slate-200 text-slate-600 hover:bg-slate-100'
              "
            >
              {{ halaman }}
            </button>


            <button
              type="button"
              @click="halamanBerikutnya"
              :disabled="
                currentPage === totalPages
              "
              class="w-10 h-10 rounded-lg border border-slate-200 text-slate-600 font-bold hover:bg-slate-100 transition disabled:opacity-40 disabled:cursor-not-allowed"
            >
              →
            </button>

          </div>

        </div>

      </section>


      <!-- ===================================================== -->
      <!-- FOOTER -->
      <!-- ===================================================== -->

      <div class="text-center py-7">

        <p class="text-xs text-slate-400">
          Sistem Informasi Parkir • Laporan Petugas
        </p>

      </div>

    </main>

  </div>
</template>


<script setup lang="ts">

const { $api } = useNuxtApp()
const router = useRouter()


// =====================================================
// DATA
// =====================================================

const tiket = ref<any[]>([])
const members = ref<any[]>([])
const loading = ref(false)


// =====================================================
// FILTER
// =====================================================

const tanggalMulai = ref("")
const tanggalAkhir = ref("")


// =====================================================
// BULAN AKTIF
// =====================================================

const sekarang = new Date()

const bulanDipilih = ref(
  `${sekarang.getFullYear()}-${String(
    sekarang.getMonth() + 1
  ).padStart(2, "0")}`
)


// =====================================================
// FORMAT RUPIAH
// =====================================================

function formatRupiah(value: any) {

  return new Intl.NumberFormat(
    "id-ID",
    {
      style: "currency",
      currency: "IDR",
      maximumFractionDigits: 0
    }
  ).format(
    Number(value || 0)
  )

}


// =====================================================
// PARSE TANGGAL LARAVEL
// =====================================================
// Data Laravel:
// 2026-09-21 20:01:36
//
// Dibaca sebagai waktu lokal WIB.
// Tidak memakai new Date(string) langsung.
// =====================================================

function parseTanggalLaravel(value: any) {

  if (!value) {
    return null
  }

  const teks =
    String(value).trim()

  const cocok =
    teks.match(
      /^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/
    )

  if (!cocok) {
    return null
  }

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


// =====================================================
// FORMAT TANGGAL
// =====================================================

function formatTanggal(value: any) {

  const tanggal =
    parseTanggalLaravel(value)

  if (!tanggal) {
    return "-"
  }

  const hari =
    String(
      tanggal.getDate()
    ).padStart(2, "0")

  const bulan =
    String(
      tanggal.getMonth() + 1
    ).padStart(2, "0")

  const tahun =
    tanggal.getFullYear()

  const jam =
    String(
      tanggal.getHours()
    ).padStart(2, "0")

  const menit =
    String(
      tanggal.getMinutes()
    ).padStart(2, "0")

  return `${hari}/${bulan}/${tahun} ${jam}:${menit}`
}


// =====================================================
// FORMAT TANGGAL PENDEK
// =====================================================

function formatTanggalPendek(
  value: string
) {

  const bagian =
    value.split("-")

  if (
    bagian.length !== 3
  ) {
    return value
  }

  const tahun =
    Number(bagian[0])

  const bulan =
    Number(bagian[1])

  const hari =
    Number(bagian[2])

  const tanggal =
    new Date(
      tahun,
      bulan - 1,
      hari
    )

  if (
    isNaN(
      tanggal.getTime()
    )
  ) {
    return value
  }

  return tanggal.toLocaleDateString(
    "id-ID",
    {
      day: "2-digit",
      month: "short"
    }
  )
}


// =====================================================
// NAMA BULAN AKTIF
// =====================================================

const namaBulanAktif =
  computed(() => {

    if (
      !bulanDipilih.value
    ) {
      return "-"
    }

    const bagian =
      bulanDipilih.value.split("-")

    if (
      bagian.length !== 2
    ) {
      return "-"
    }

    const tahun =
      Number(bagian[0])

    const bulan =
      Number(bagian[1])

    const tanggal =
      new Date(
        tahun,
        bulan - 1,
        1
      )

    if (
      isNaN(
        tanggal.getTime()
      )
    ) {
      return "-"
    }

    return tanggal.toLocaleDateString(
      "id-ID",
      {
        month: "long",
        year: "numeric"
      }
    )
  })


// =====================================================
// TOTAL PARKIR NON-MEMBER
// =====================================================

function getTotal(item: any) {

  if (
    item.total_harga !== null &&
    item.total_harga !== undefined &&
    Number(item.total_harga) > 0
  ) {

    return Number(
      item.total_harga
    )

  }


  if (
    item.harga_per_jam !== null &&
    item.harga_per_jam !== undefined &&
    Number(item.harga_per_jam) > 0
  ) {

    return (
      Number(item.durasi || 0) *
      Number(item.harga_per_jam)
    )

  }


  const kendaraan =
    String(
      item.jenis_kendaraan || ""
    ).toLowerCase()

  let tarif = 0

  if (
    kendaraan === "motor"
  ) {
    tarif = 3000
  }

  if (
    kendaraan === "mobil"
  ) {
    tarif = 5000
  }

  return (
    Number(item.durasi || 0) *
    tarif
  )
}


// =====================================================
// TOTAL PEMBAYARAN MEMBER
// =====================================================

function getMemberTotal(
  member: any
) {

  return Number(
    member?.total_harga || 0
  )

}


// =====================================================
// AMBIL DATA
// =====================================================

async function ambilData() {

  loading.value = true

  try {

    const [
      responseTiket,
      responseMember
    ] = await Promise.all([

      $api.get("/tiket"),

      $api.get("/member")

    ])

    tiket.value =
      responseTiket.data?.data ||
      []

    members.value =
      responseMember.data?.data ||
      []

  } catch (error) {

    console.error(
      "Gagal mengambil data laporan:",
      error
    )

    tiket.value = []
    members.value = []

  } finally {

    loading.value = false

  }
}


// =====================================================
// DATA LAPORAN BERDASARKAN FILTER
// =====================================================

const dataLaporan =
  computed(() => {

    let data =
      [...tiket.value]


    if (
      tanggalMulai.value
    ) {

      const bagian =
        tanggalMulai.value.split("-")

      const mulai =
        new Date(
          Number(bagian[0]),
          Number(bagian[1]) - 1,
          Number(bagian[2]),
          0,
          0,
          0
        )


      data =
        data.filter(
          (item: any) => {

            const nilaiTanggal =
              item.status === "keluar" &&
              item.waktu_keluar
                ? item.waktu_keluar
                : item.waktu_masuk

            const tanggal =
              parseTanggalLaravel(
                nilaiTanggal
              )

            if (!tanggal) {
              return false
            }

            return (
              tanggal >= mulai
            )
          }
        )
    }


    if (
      tanggalAkhir.value
    ) {

      const bagian =
        tanggalAkhir.value.split("-")

      const akhir =
        new Date(
          Number(bagian[0]),
          Number(bagian[1]) - 1,
          Number(bagian[2]),
          23,
          59,
          59
        )


      data =
        data.filter(
          (item: any) => {

            const nilaiTanggal =
              item.status === "keluar" &&
              item.waktu_keluar
                ? item.waktu_keluar
                : item.waktu_masuk

            const tanggal =
              parseTanggalLaravel(
                nilaiTanggal
              )

            if (!tanggal) {
              return false
            }

            return (
              tanggal <= akhir
            )
          }
        )
    }


    return data

  })


// =====================================================
// PAGINATION
// =====================================================

const currentPage =
  ref(1)

const itemsPerPage =
  10


const totalPages =
  computed(() => {

    return Math.max(
      1,
      Math.ceil(
        dataLaporan.value.length /
        itemsPerPage
      )
    )

  })


const dataLaporanPagination =
  computed(() => {

    const start =
      (
        currentPage.value - 1
      ) *
      itemsPerPage

    return dataLaporan.value.slice(
      start,
      start + itemsPerPage
    )

  })


const startItem =
  computed(() => {

    if (
      !dataLaporan.value.length
    ) {
      return 0
    }

    return (
      (
        currentPage.value - 1
      ) *
      itemsPerPage
    ) + 1

  })


const endItem =
  computed(() => {

    return Math.min(
      currentPage.value *
        itemsPerPage,
      dataLaporan.value.length
    )

  })


function halamanSebelumnya() {

  if (
    currentPage.value > 1
  ) {

    currentPage.value--

  }

}


function halamanBerikutnya() {

  if (
    currentPage.value <
    totalPages.value
  ) {

    currentPage.value++

  }

}


function pilihHalaman(
  halaman: number
) {

  currentPage.value =
    halaman

}


// =====================================================
// MEMBER LUNAS
// =====================================================

const dataMemberLunas =
  computed(() => {

    return members.value.filter(
      (member: any) => {

        return (
          String(
            member?.status || ""
          ).toLowerCase() ===
          "lunas"
        )

      }
    )

  })


// =====================================================
// PEMBAYARAN MEMBER BULAN AKTIF
// =====================================================

const dataMemberBulan =
  computed(() => {

    if (
      !bulanDipilih.value
    ) {
      return []
    }

    return dataMemberLunas.value.filter(
      (member: any) => {

        const tanggalBayar =
          member?.tanggal_bayar ||
          member?.tanggal_mulai

        if (!tanggalBayar) {
          return false
        }

        const tanggal =
          parseTanggalLaravel(
            tanggalBayar
          ) ||
          new Date(tanggalBayar)

        if (
          !tanggal ||
          isNaN(
            tanggal.getTime()
          )
        ) {
          return false
        }

        const tahun =
          tanggal.getFullYear()

        const bulan =
          String(
            tanggal.getMonth() + 1
          ).padStart(
            2,
            "0"
          )

        return (
          `${tahun}-${bulan}` ===
          bulanDipilih.value
        )
      }
    )
  })


// =====================================================
// NON-MEMBER BULAN AKTIF
// =====================================================

const dataNonMemberBulan =
  computed(() => {

    if (
      !bulanDipilih.value
    ) {
      return []
    }

    return tiket.value.filter(
      (item: any) => {

        if (
          item.status !==
          "keluar"
        ) {
          return false
        }

        if (
          !item.waktu_keluar
        ) {
          return false
        }

        if (
          item.member_id
        ) {
          return false
        }

        const tanggal =
          parseTanggalLaravel(
            item.waktu_keluar
          )

        if (
          !tanggal
        ) {
          return false
        }

        const tahun =
          tanggal.getFullYear()

        const bulan =
          String(
            tanggal.getMonth() + 1
          ).padStart(
            2,
            "0"
          )

        return (
          `${tahun}-${bulan}` ===
          bulanDipilih.value
        )
      }
    )
  })


// =====================================================
// PENDAPATAN HARIAN
// =====================================================

const pendapatanHarian =
  computed(() => {

    if (
      !bulanDipilih.value
    ) {
      return []
    }

    const bagian =
      bulanDipilih.value.split("-")

    const tahun =
      Number(
        bagian[0] || 0
      )

    const bulan =
      Number(
        bagian[1] || 0
      )

    if (
      !tahun ||
      !bulan
    ) {
      return []
    }

    const jumlahHari =
      new Date(
        tahun,
        bulan,
        0
      ).getDate()

    const hasil: any[] = []


    for (
      let hari = 1;
      hari <= jumlahHari;
      hari++
    ) {

      const tanggalKey =
        `${tahun}-${String(
          bulan
        ).padStart(
          2,
          "0"
        )}-${String(
          hari
        ).padStart(
          2,
          "0"
        )}`


      const transaksiMember =
        dataMemberBulan.value.filter(
          (member: any) => {

            const nilaiTanggal =
              member?.tanggal_bayar ||
              member?.tanggal_mulai

            if (!nilaiTanggal) {
              return false
            }

            const tanggal =
              parseTanggalLaravel(
                nilaiTanggal
              ) ||
              new Date(nilaiTanggal)

            if (
              !tanggal ||
              isNaN(
                tanggal.getTime()
              )
            ) {
              return false
            }

            const key =
              `${tanggal.getFullYear()}-${String(
                tanggal.getMonth() + 1
              ).padStart(
                2,
                "0"
              )}-${String(
                tanggal.getDate()
              ).padStart(
                2,
                "0"
              )}`

            return (
              key ===
              tanggalKey
            )
          }
        )


      const transaksiNonMember =
        dataNonMemberBulan.value.filter(
          (item: any) => {

            const tanggal =
              parseTanggalLaravel(
                item.waktu_keluar
              )

            if (
              !tanggal
            ) {
              return false
            }

            const key =
              `${tanggal.getFullYear()}-${String(
                tanggal.getMonth() + 1
              ).padStart(
                2,
                "0"
              )}-${String(
                tanggal.getDate()
              ).padStart(
                2,
                "0"
              )}`

            return (
              key ===
              tanggalKey
            )
          }
        )


      const memberTotal =
        transaksiMember.reduce(
          (
            total: number,
            member: any
          ) => {

            return (
              total +
              getMemberTotal(
                member
              )
            )
          },
          0
        )


      const nonMemberTotal =
        transaksiNonMember.reduce(
          (
            total: number,
            item: any
          ) => {

            return (
              total +
              getTotal(item)
            )
          },
          0
        )


      hasil.push({

        tanggal:
          tanggalKey,

        tanggalLabel:
          formatTanggalPendek(
            tanggalKey
          ),

        hari:
          String(hari),

        memberTotal,

        nonMemberTotal,

        total:
          memberTotal +
          nonMemberTotal

      })

    }


    return hasil
  })


// =====================================================
// NILAI MAKSIMAL GRAFIK
// =====================================================

const pendapatanMaksimal =
  computed(() => {

    if (
      !pendapatanHarian.value.length
    ) {
      return 0
    }

    return Math.max(
      ...pendapatanHarian.value.map(
        (item: any) =>
          Math.max(
            Number(
              item.memberTotal || 0
            ),
            Number(
              item.nonMemberTotal || 0
            )
          )
      ),
      0
    )
  })


// =====================================================
// TINGGI BAR
// =====================================================

function getBarHeight(
  total: number
) {

  if (
    !pendapatanMaksimal.value ||
    !total
  ) {
    return 0
  }

  return Math.max(
    3,
    (
      Number(total) /
      pendapatanMaksimal.value
    ) * 100
  )
}


// =====================================================
// TOTAL PEMBAYARAN MEMBERSHIP
// =====================================================

const totalPendapatanMember =
  computed(() => {

    return dataMemberBulan.value.reduce(
      (
        total: number,
        member: any
      ) => {

        return (
          total +
          getMemberTotal(
            member
          )
        )
      },
      0
    )
  })


// =====================================================
// TOTAL NON-MEMBER
// =====================================================

const totalPendapatanNonMember =
  computed(() => {

    return dataNonMemberBulan.value.reduce(
      (
        total: number,
        item: any
      ) => {

        return (
          total +
          getTotal(item)
        )
      },
      0
    )
  })


// =====================================================
// TOTAL SEMUA PENDAPATAN
// =====================================================

const totalPendapatanBulan =
  computed(() => {

    return (
      totalPendapatanMember.value +
      totalPendapatanNonMember.value
    )

  })


// =====================================================
// JUMLAH PEMBAYARAN MEMBER
// =====================================================

const jumlahPembayaranMember =
  computed(() => {

    return (
      dataMemberBulan.value.length
    )

  })


// =====================================================
// JUMLAH TRANSAKSI NON-MEMBER BULAN
// =====================================================

const jumlahTransaksiNonMemberBulan =
  computed(() => {

    return (
      dataNonMemberBulan.value.length
    )

  })


// =====================================================
// RATA-RATA PENDAPATAN
// =====================================================

const rataPendapatanHari =
  computed(() => {

    const hariAdaPendapatan =
      pendapatanHarian.value.filter(
        (item: any) =>
          Number(
            item.total || 0
          ) > 0
      )


    if (
      !hariAdaPendapatan.length
    ) {
      return 0
    }


    return (
      totalPendapatanBulan.value /
      hariAdaPendapatan.length
    )

  })


// =====================================================
// HARI TERTINGGI
// =====================================================

const hariTertinggi =
  computed(() => {

    if (
      !pendapatanHarian.value.length
    ) {
      return null
    }

    return (
      [
        ...pendapatanHarian.value
      ].sort(
        (a: any, b: any) =>
          Number(
            b.total || 0
          ) -
          Number(
            a.total || 0
          )
      )[0] || null
    )
  })


const pendapatanTertinggi =
  computed(() => {

    return Number(
      hariTertinggi.value?.total ||
      0
    )

  })


const tanggalPendapatanTertinggi =
  computed(() => {

    if (
      !hariTertinggi.value ||
      !hariTertinggi.value.total
    ) {
      return "-"
    }

    return (
      hariTertinggi.value
        .tanggalLabel
    )
  })


// =====================================================
// TOTAL TRANSAKSI
// =====================================================

const totalTransaksi =
  computed(() => {

    return (
      dataLaporan.value.length
    )

  })


// =====================================================
// SEDANG PARKIR
// =====================================================

const sedangParkir =
  computed(() => {

    return tiket.value.filter(
      (item: any) =>
        item.status === "masuk"
    ).length

  })


// =====================================================
// SUDAH KELUAR
// =====================================================

const sudahKeluar =
  computed(() => {

    return tiket.value.filter(
      (item: any) =>
        item.status === "keluar"
    ).length

  })


// =====================================================
// JUMLAH MOTOR
// =====================================================

const jumlahMotor =
  computed(() => {

    return dataLaporan.value.filter(
      (item: any) =>
        String(
          item.jenis_kendaraan ||
          ""
        ).toLowerCase() ===
        "motor"
    ).length

  })


// =====================================================
// JUMLAH MOBIL
// =====================================================

const jumlahMobil =
  computed(() => {

    return dataLaporan.value.filter(
      (item: any) =>
        String(
          item.jenis_kendaraan ||
          ""
        ).toLowerCase() ===
        "mobil"
    ).length

  })


// =====================================================
// TOTAL KENDARAAN
// =====================================================

const totalKendaraan =
  computed(() => {

    return (
      jumlahMotor.value +
      jumlahMobil.value
    )

  })


// =====================================================
// PERSEN MOTOR
// =====================================================

const persenMotor =
  computed(() => {

    if (
      !totalKendaraan.value
    ) {
      return 0
    }

    return Number(
      (
        (
          jumlahMotor.value /
          totalKendaraan.value
        ) *
        100
      ).toFixed(1)
    )
  })


// =====================================================
// PERSEN MOBIL
// =====================================================

const persenMobil =
  computed(() => {

    if (
      !totalKendaraan.value
    ) {
      return 0
    }

    return Number(
      (
        (
          jumlahMobil.value /
          totalKendaraan.value
        ) *
        100
      ).toFixed(1)
    )
  })


// =====================================================
// JUMLAH MEMBER
// =====================================================

const jumlahMember =
  computed(() => {

    return dataLaporan.value.filter(
      (item: any) =>
        !!item.member_id
    ).length

  })


// =====================================================
// JUMLAH NON MEMBER
// =====================================================

const jumlahNonMember =
  computed(() => {

    return dataLaporan.value.filter(
      (item: any) =>
        !item.member_id
    ).length

  })


// =====================================================
// TOTAL PENGGUNA
// =====================================================

const totalPengguna =
  computed(() => {

    return (
      jumlahMember.value +
      jumlahNonMember.value
    )

  })


// =====================================================
// PERSEN MEMBER
// =====================================================

const persenMember =
  computed(() => {

    if (
      !totalPengguna.value
    ) {
      return 0
    }

    return Number(
      (
        (
          jumlahMember.value /
          totalPengguna.value
        ) *
        100
      ).toFixed(1)
    )
  })


// =====================================================
// DONUT
// =====================================================

const donutStyle =
  computed(() => {

    const sudut =
      persenMember.value *
      3.6

    return {

      background:
        `conic-gradient(
          #38BDF8 0deg ${sudut}deg,
          #10B981 ${sudut}deg 360deg
        )`

    }
  })


// =====================================================
// RATA-RATA DURASI
// =====================================================

const rataRataDurasi =
  computed(() => {

    const data =
      dataLaporan.value.filter(
        (item: any) =>
          Number(
            item.durasi || 0
          ) > 0
      )


    if (
      !data.length
    ) {
      return "0"
    }


    const total =
      data.reduce(
        (
          jumlah: number,
          item: any
        ) => {

          return (
            jumlah +
            Number(
              item.durasi || 0
            )
          )
        },
        0
      )


    return (
      total /
      data.length
    ).toFixed(1)

  })


// =====================================================
// RESET FILTER
// =====================================================

function resetFilter() {

  tanggalMulai.value =
    ""

  tanggalAkhir.value =
    ""

  currentPage.value =
    1

}


// =====================================================
// WATCH FILTER
// =====================================================

watch(
  [
    tanggalMulai,
    tanggalAkhir,
    bulanDipilih
  ],
  () => {

    currentPage.value =
      1

  }
)


// =====================================================
// KEMBALI
// =====================================================

function kembali() {

  router.back()

}


// =====================================================
// CETAK LAPORAN
// =====================================================

function cetakLaporan() {
  window.print()
}


// =====================================================
// LOAD DATA
// =====================================================

onMounted(() => {

  ambilData()

})

</script>
<style>
@media print {
  body {
    background: white !important;
  }

  @page {
    size: A4;
    margin: 12mm;
  }
}
</style>
