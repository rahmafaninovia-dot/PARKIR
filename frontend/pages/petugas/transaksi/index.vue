<template>
  <div
    class="min-h-screen bg-linear-to-br from-slate-50 via-white to-sky-100 p-4 md:p-6 lg:p-8"
  >

    <!-- ================================================= -->
    <!-- HEADER / HERO -->
    <!-- ================================================= -->
    <div class="max-w-7xl mx-auto mb-6">

      <div
        class="relative overflow-hidden rounded-[30px] bg-[#172033] px-6 py-7 md:px-8 md:py-8 shadow-xl"
      >

        <!-- dekorasi -->
        <div
          class="absolute -top-24 -right-20 w-80 h-80 rounded-full bg-sky-400/10"
        ></div>

        <div
          class="absolute -bottom-28 right-28 w-72 h-72 rounded-full bg-sky-300/5"
        ></div>

        <div
          class="absolute inset-y-0 right-0 w-1/3 bg-linear-to-l from-sky-400/5 to-transparent"
        ></div>

        <div
          class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6"
        >

          <div>

            <div
              class="inline-flex items-center gap-2 rounded-full bg-sky-400/10 border border-sky-400/10 px-3 py-1.5 mb-4"
            >

              <span
                class="w-2 h-2 rounded-full bg-sky-400"
              ></span>

              <span
                class="text-[10px] font-bold uppercase tracking-[0.16em] text-sky-300"
              >
                Monitoring Parkir
              </span>

            </div>

            <h1
              class="text-3xl md:text-4xl font-extrabold text-white leading-tight"
            >
              Kelola Transaksi
            </h1>

            <p
              class="text-sm text-slate-400 mt-3 max-w-2xl leading-relaxed"
            >
              Pantau transaksi kendaraan, status parkir, durasi, dan pendapatan
              dalam satu halaman.
            </p>

          </div>

          <button
            @click="kembali"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 text-white text-sm font-bold transition"
          >
            ← Kembali
          </button>

        </div>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- STATISTIK -->
    <!-- ================================================= -->
    <div
      class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6"
    >

      <!-- TOTAL -->
      <div
        class="group bg-white rounded-[22px] border border-slate-200 p-5 shadow-sm hover:-translate-y-1 hover:shadow-xl hover:border-sky-200 transition-all"
      >

        <div class="flex items-start justify-between">

          <div>

            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
              Total Transaksi
            </p>

            <h2
              class="text-3xl font-extrabold text-[#172033] mt-2"
            >
              {{ totalTransaksi }}
            </h2>

            <p class="text-[10px] text-slate-400 mt-1">
              Semua data transaksi
            </p>

          </div>

          <div
            class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
          >
            🎫
          </div>

        </div>

        <div
          class="mt-5 h-1.5 rounded-full bg-slate-100 overflow-hidden"
        >

          <div
            class="h-full w-full bg-sky-400 rounded-full"
          ></div>

        </div>

      </div>


      <!-- SEDANG PARKIR -->
      <div
        class="group bg-white rounded-[22px] border border-slate-200 p-5 shadow-sm hover:-translate-y-1 hover:shadow-xl hover:border-amber-200 transition-all"
      >

        <div class="flex items-start justify-between">

          <div>

            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
              Sedang Parkir
            </p>

            <h2
              class="text-3xl font-extrabold text-[#172033] mt-2"
            >
              {{ sedangParkir }}
            </h2>

            <p class="text-[10px] text-slate-400 mt-1">
              Kendaraan masih di area
            </p>

          </div>

          <div
            class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl group-hover:bg-amber-500 group-hover:text-white transition"
          >
            🚗
          </div>

        </div>

        <div
          class="mt-5 flex items-center gap-2"
        >

          <span
            class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"
          ></span>

          <span class="text-[10px] font-semibold text-amber-600">
            Kendaraan aktif
          </span>

        </div>

      </div>


      <!-- SUDAH KELUAR -->
      <div
        class="group bg-white rounded-[22px] border border-slate-200 p-5 shadow-sm hover:-translate-y-1 hover:shadow-xl hover:border-sky-200 transition-all"
      >

        <div class="flex items-start justify-between">

          <div>

            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
              Sudah Keluar
            </p>

            <h2
              class="text-3xl font-extrabold text-[#172033] mt-2"
            >
              {{ sudahKeluar }}
            </h2>

            <p class="text-[10px] text-slate-400 mt-1">
              Transaksi selesai
            </p>

          </div>

          <div
            class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
          >
            🚙
          </div>

        </div>

        <div class="mt-5 flex items-center gap-2">

          <span
            class="w-2 h-2 rounded-full bg-sky-500"
          ></span>

          <span class="text-[10px] font-semibold text-sky-600">
            Selesai
          </span>

        </div>

      </div>


      <!-- PENDAPATAN -->
      <div
        class="group bg-white rounded-[22px] border border-slate-200 p-5 shadow-sm hover:-translate-y-1 hover:shadow-xl hover:border-sky-200 transition-all"
      >

        <div class="flex items-start justify-between">

          <div>

            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
              Total Pendapatan
            </p>

            <h2
              class="text-xl font-extrabold text-[#172033] mt-3"
            >
              {{ formatRupiah(totalPendapatan) }}
            </h2>

            <p class="text-[10px] text-slate-400 mt-1">
              Pendapatan non-member
            </p>

          </div>

          <div
            class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-100 text-sky-600 flex items-center justify-center text-xl group-hover:bg-sky-500 group-hover:text-white transition"
          >
            💰
          </div>

        </div>

        <div
          class="mt-5 text-[10px] font-bold text-sky-600"
        >
          PARKIR NON-MEMBER
        </div>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- FILTER PANEL -->
    <!-- ================================================= -->
    <div
      class="max-w-7xl mx-auto bg-white rounded-[22px] border border-slate-200 shadow-sm p-5 mb-6"
    >

      <div
        class="flex flex-col xl:flex-row xl:items-end gap-4"
      >

        <!-- SEARCH -->
        <div class="flex-1">

          <label
            class="block text-xs font-bold text-slate-600 mb-2"
          >
            Cari Transaksi
          </label>

          <div class="relative">

            <span
              class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
            >
              🔎
            </span>

            <input
              v-model="pencarian"
              type="text"
              placeholder="Kode tiket / nomor polisi / kendaraan..."
              class="w-full h-12 pl-11 pr-4 rounded-xl border border-slate-300 bg-slate-50 focus:bg-white text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-sky-100 focus:border-sky-400 transition"
            />

          </div>

        </div>


        <!-- STATUS -->
        <div class="w-full xl:w-52">

          <label
            class="block text-xs font-bold text-slate-600 mb-2"
          >
            Status
          </label>

          <select
            v-model="filterStatus"
            class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-slate-50 focus:bg-white text-sm text-slate-700 focus:outline-none focus:ring-4 focus:ring-sky-100 focus:border-sky-400 transition"
          >

            <option value="">
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


        <!-- REFRESH -->
        <button
          @click="ambilData"
          :disabled="loading"
          class="h-12 px-5 rounded-xl bg-[#172033] hover:bg-slate-800 disabled:bg-slate-400 text-white text-sm font-bold transition"
        >
          {{ loading ? 'Memuat...' : '↻ Refresh Data' }}
        </button>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- TABLE CARD -->
    <!-- ================================================= -->
    <div
      class="max-w-7xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden"
    >

      <!-- TABLE TOP -->
      <div
        class="p-5 md:p-6 border-b border-slate-200"
      >

        <div
          class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4"
        >

          <div>

            <p
              class="text-[10px] uppercase tracking-[0.18em] font-bold text-sky-500"
            >
              Monitoring
            </p>

            <h2
              class="text-xl font-extrabold text-[#172033] mt-1"
            >
              Data Transaksi
            </h2>

            <p
              class="text-xs text-slate-400 mt-1"
            >
              Pilih kategori transaksi yang ingin dilihat.
            </p>

          </div>


          <!-- TAB -->
          <div
            class="flex gap-2 bg-slate-100 p-1.5 rounded-2xl w-fit"
          >

            <!-- NON MEMBER -->
            <button
              @click="gantiJenisData('non-member')"
              :class="[
                'px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition',
                jenisData === 'non-member'
                  ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20'
                  : 'text-slate-500 hover:text-slate-700 hover:bg-white'
              ]"
            >
              🚗 Non-Member
            </button>


            <!-- MEMBER -->
            <button
              @click="gantiJenisData('member')"
              :class="[
                'px-4 md:px-5 py-2.5 rounded-xl text-xs md:text-sm font-bold transition',
                jenisData === 'member'
                  ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20'
                  : 'text-slate-500 hover:text-slate-700 hover:bg-white'
              ]"
            >
              👤 Member
            </button>

          </div>

        </div>

      </div>


      <!-- ================================================= -->
      <!-- NON MEMBER -->
      <!-- ================================================= -->
      <div
        v-if="jenisData === 'non-member'"
        class="p-4 md:p-6"
      >

        <div
          class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5"
        >

          <div>

            <h3 class="text-sm font-extrabold text-[#172033]">
              Transaksi Non-Member
            </h3>

            <p class="text-xs text-slate-400 mt-1">
              Kendaraan umum dengan sistem pembayaran parkir.
            </p>

          </div>

          <div
            class="px-3 py-1.5 rounded-full bg-sky-50 border border-sky-100 text-sky-600 text-xs font-bold"
          >
            {{ transaksiNonMember.length }} Data
          </div>

        </div>


        <div
          class="overflow-x-auto rounded-2xl border border-slate-200"
        >

          <table class="w-full min-w-275 text-sm">

            <thead>

              <tr class="bg-slate-50 border-b border-slate-200">

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Tiket
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Kendaraan
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  No Polisi
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Masuk
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Keluar
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Durasi
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Tarif
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Total
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Status
                </th>

              </tr>

            </thead>


            <tbody>

              <tr
                v-for="item in transaksiNonMemberPagination"
                :key="item.id"
                class="border-b border-slate-100 hover:bg-sky-50/40 transition"
              >

                <!-- TIKET -->
                <td class="px-4 py-4">

                  <span
                    class="inline-flex px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 font-bold text-xs border border-sky-100"
                  >
                    {{ item.kode_tiket || '-' }}
                  </span>

                </td>


                <!-- KENDARAAN -->
                <td class="px-4 py-4">

                  <div class="flex items-center gap-2">

                    <div
                      class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-sm"
                    >
                      🚗
                    </div>

                    <span class="font-semibold text-slate-700">
                      {{ item.jenis_kendaraan || '-' }}
                    </span>

                  </div>

                </td>


                <!-- POLISI -->
                <td class="px-4 py-4">

                  <span class="font-bold text-[#172033] uppercase">
                    {{ item.no_polisi || '-' }}
                  </span>

                </td>


                <!-- MASUK -->
                <td class="px-4 py-4 text-xs text-slate-600 whitespace-nowrap">
                  {{ formatTanggal(item.waktu_masuk) }}
                </td>


                <!-- KELUAR -->
                <td class="px-4 py-4 text-xs text-slate-600 whitespace-nowrap">
                  {{ formatTanggal(item.waktu_keluar) }}
                </td>


                <!-- DURASI -->
                <td class="px-4 py-4">

                  <span
                    class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold"
                  >
                    {{ item.durasi ? item.durasi + ' jam' : '-' }}
                  </span>

                </td>


                <!-- TARIF -->
                <td class="px-4 py-4 text-xs text-slate-600">
                  {{ formatRupiah(item.harga_per_jam) }}
                </td>


                <!-- TOTAL -->
                <td class="px-4 py-4">

                  <span
                    class="font-extrabold text-[#172033]"
                  >
                    {{ formatRupiah(getTotal(item)) }}
                  </span>

                </td>


                <!-- STATUS -->
                <td class="px-4 py-4">

                  <span
                    :class="[
                      'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold',
                      item.status === 'masuk'
                        ? 'bg-amber-100 text-amber-700'
                        : 'bg-sky-100 text-sky-700'
                    ]"
                  >

                    <span
                      class="w-1.5 h-1.5 rounded-full bg-current"
                    ></span>

                    {{ item.status === 'masuk' ? 'Masuk' : 'Keluar' }}

                  </span>

                </td>

              </tr>


              <!-- EMPTY -->
              <tr v-if="transaksiNonMember.length === 0">

                <td
                  colspan="9"
                  class="py-16 text-center"
                >

                  <div class="flex flex-col items-center">

                    <div
                      class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl"
                    >
                      🎫
                    </div>

                    <p class="text-sm font-bold text-slate-700 mt-4">
                      Tidak ada transaksi non-member
                    </p>

                    <p class="text-xs text-slate-400 mt-1 max-w-sm">
                      Belum ada transaksi atau data tidak sesuai dengan filter yang dipilih.
                    </p>

                  </div>

                </td>

              </tr>

            </tbody>

          </table>

        </div>


        <!-- ================================================= -->
        <!-- PAGINATION NON MEMBER -->
        <!-- ================================================= -->
        <div
          v-if="transaksiNonMember.length > itemsPerPage"
          class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-5"
        >

          <p class="text-xs text-slate-400">
            Menampilkan
            <span class="font-bold text-slate-600">
              {{ startItemNonMember }}
            </span>
            -
            <span class="font-bold text-slate-600">
              {{ endItemNonMember }}
            </span>
            dari
            <span class="font-bold text-slate-600">
              {{ transaksiNonMember.length }}
            </span>
            transaksi
          </p>


          <div class="flex items-center gap-1.5">

            <button
              @click="halamanSebelumnya"
              :disabled="currentPageNonMember === 1"
              class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition"
            >
              ←
            </button>


            <button
              v-for="halaman in totalPagesNonMember"
              :key="halaman"
              @click="pilihHalaman(halaman)"
              :class="[
                'w-9 h-9 rounded-xl text-sm font-bold transition',
                currentPageNonMember === halaman
                  ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20'
                  : 'border border-slate-200 bg-white text-slate-600 hover:bg-sky-50 hover:text-sky-600'
              ]"
            >
              {{ halaman }}
            </button>


            <button
              @click="halamanBerikutnya"
              :disabled="currentPageNonMember === totalPagesNonMember"
              class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition"
            >
              →
            </button>

          </div>

        </div>

      </div>


      <!-- ================================================= -->
      <!-- MEMBER -->
      <!-- ================================================= -->
      <div
        v-else
        class="p-4 md:p-6"
      >

        <div
          class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5"
        >

          <div>

            <h3 class="text-sm font-extrabold text-[#172033]">
              Transaksi Member
            </h3>

            <p class="text-xs text-slate-400 mt-1">
              Aktivitas kendaraan yang terhubung dengan member.
            </p>

          </div>

          <div
            class="px-3 py-1.5 rounded-full bg-sky-50 border border-sky-100 text-sky-600 text-xs font-bold"
          >
            {{ transaksiMember.length }} Data
          </div>

        </div>


        <div
          class="overflow-x-auto rounded-2xl border border-slate-200"
        >

          <table class="w-full min-w-225 text-sm">

            <thead>

              <tr class="bg-slate-50 border-b border-slate-200">

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Member
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Nama
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Perusahaan
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Masuk
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Keluar
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Durasi
                </th>

                <th class="px-4 py-4 text-left text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                  Status
                </th>

              </tr>

            </thead>


            <tbody>

              <tr
                v-for="item in transaksiMemberPagination"
                :key="item.id"
                class="border-b border-slate-100 hover:bg-sky-50/40 transition"
              >

                <!-- MEMBER -->
                <td class="px-4 py-4">

                  <span
                    class="inline-flex px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 font-bold text-xs border border-sky-100"
                  >
                    {{ item.kode_member || '-' }}
                  </span>

                </td>


                <!-- NAMA -->
                <td class="px-4 py-4">

                  <div class="flex items-center gap-2">

                    <div
                      class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-sm font-bold"
                    >
                      👤
                    </div>

                    <span class="font-bold text-[#172033]">
                      {{ item.nama_member || '-' }}
                    </span>

                  </div>

                </td>


                <!-- PERUSAHAAN -->
                <td class="px-4 py-4 text-slate-600">
                  {{ item.nama_perusahaan || '-' }}
                </td>


                <!-- MASUK -->
                <td class="px-4 py-4 text-xs text-slate-600 whitespace-nowrap">
                  {{ formatTanggal(item.waktu_masuk) }}
                </td>


                <!-- KELUAR -->
                <td class="px-4 py-4 text-xs text-slate-600 whitespace-nowrap">
                  {{ formatTanggal(item.waktu_keluar) }}
                </td>


                <!-- DURASI -->
                <td class="px-4 py-4">

                  <span
                    class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-xs font-semibold"
                  >
                    {{ item.durasi ? item.durasi + ' jam' : '-' }}
                  </span>

                </td>


                <!-- STATUS -->
                <td class="px-4 py-4">

                  <span
                    :class="[
                      'inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold',
                      item.status === 'masuk'
                        ? 'bg-amber-100 text-amber-700'
                        : 'bg-sky-100 text-sky-700'
                    ]"
                  >

                    <span
                      class="w-1.5 h-1.5 rounded-full bg-current"
                    ></span>

                    {{ item.status === 'masuk' ? 'Masuk' : 'Keluar' }}

                  </span>

                </td>

              </tr>


              <!-- EMPTY -->
              <tr v-if="transaksiMember.length === 0">

                <td
                  colspan="7"
                  class="py-16 text-center"
                >

                  <div class="flex flex-col items-center">

                    <div
                      class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl"
                    >
                      👤
                    </div>

                    <p class="text-sm font-bold text-slate-700 mt-4">
                      Tidak ada transaksi member
                    </p>

                    <p class="text-xs text-slate-400 mt-1 max-w-sm">
                      Belum ada aktivitas member atau data tidak sesuai dengan filter.
                    </p>

                  </div>

                </td>

              </tr>

            </tbody>

          </table>

        </div>


        <!-- ================================================= -->
        <!-- PAGINATION MEMBER -->
        <!-- ================================================= -->
        <div
          v-if="transaksiMember.length > itemsPerPage"
          class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-5"
        >

          <p class="text-xs text-slate-400">
            Menampilkan
            <span class="font-bold text-slate-600">
              {{ startItemMember }}
            </span>
            -
            <span class="font-bold text-slate-600">
              {{ endItemMember }}
            </span>
            dari
            <span class="font-bold text-slate-600">
              {{ transaksiMember.length }}
            </span>
            transaksi
          </p>


          <div class="flex items-center gap-1.5">

            <button
              @click="halamanSebelumnyaMember"
              :disabled="currentPageMember === 1"
              class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition"
            >
              ←
            </button>


            <button
              v-for="halaman in totalPagesMember"
              :key="halaman"
              @click="pilihHalamanMember(halaman)"
              :class="[
                'w-9 h-9 rounded-xl text-sm font-bold transition',
                currentPageMember === halaman
                  ? 'bg-sky-500 text-white shadow-md shadow-sky-500/20'
                  : 'border border-slate-200 bg-white text-slate-600 hover:bg-sky-50 hover:text-sky-600'
              ]"
            >
              {{ halaman }}
            </button>


            <button
              @click="halamanBerikutnyaMember"
              :disabled="currentPageMember === totalPagesMember"
              class="w-9 h-9 rounded-xl border border-slate-200 bg-white text-slate-600 text-sm font-bold hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed transition"
            >
              →
            </button>

          </div>

        </div>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- FOOTER -->
    <!-- ================================================= -->
    <div class="max-w-7xl mx-auto mt-6">

      <div
        class="flex flex-col md:flex-row items-center justify-between gap-2 pt-5 border-t border-slate-200"
      >

        <p class="text-[11px] text-slate-400">
          © 2026 PARKIR PLAZA ANDALAS
        </p>

        <p class="text-[11px] text-slate-400">
          Sistem Informasi Parkir
        </p>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

const { $api } = useNuxtApp()
const router = useRouter()

const tiket = ref<any[]>([])
const members = ref<any[]>([])

const jenisData = ref<"non-member" | "member">("non-member")
const pencarian = ref("")
const filterStatus = ref("")
const loading = ref(false)


// ===============================
// PAGINATION
// ===============================
const itemsPerPage = 10

const currentPageNonMember = ref(1)
const currentPageMember = ref(1)


// ===============================
// FORMAT RUPIAH
// ===============================
function formatRupiah(value: any) {

  const angka = Number(value || 0)

  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0
  }).format(angka)

}


// ===============================
// FORMAT TANGGAL
// ===============================
function formatTanggal(value: any) {

  if (!value) return "-"

  const teks = String(value).trim()

  const cocok = teks.match(
    /^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2}))?/
  )

  if (cocok) {

    const tahun = Number(cocok[1])
    const bulan = Number(cocok[2])
    const hari = Number(cocok[3])
    const jam = Number(cocok[4])
    const menit = Number(cocok[5])

    const tanggal = new Date(
      tahun,
      bulan - 1,
      hari,
      jam,
      menit,
      Number(cocok[6] || 0)
    )

    if (isNaN(tanggal.getTime())) {
      return "-"
    }

    return tanggal.toLocaleString("id-ID", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit"
    })

  }

  const tanggal = new Date(teks)

  if (isNaN(tanggal.getTime())) {
    return "-"
  }

  return tanggal.toLocaleString("id-ID", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit"
  })

}


// ===============================
// TOTAL HARGA
// ===============================
function getTotal(item: any) {

  if (item.total_harga) {
    return Number(item.total_harga)
  }

  const durasi = Number(item.durasi || 0)
  const tarif = Number(item.harga_per_jam || 0)

  return durasi * tarif

}


// ===============================
// FETCH DATA
// ===============================
async function ambilData() {

  loading.value = true

  try {

    const [tiketResponse, memberResponse] = await Promise.all([
      $api.get("/tiket"),
      $api.get("/member")
    ])

    tiket.value = tiketResponse.data?.data || []
    members.value = memberResponse.data?.data || []

    currentPageNonMember.value = 1
    currentPageMember.value = 1

  } catch (error) {

    console.error("Gagal mengambil data:", error)

  } finally {

    loading.value = false

  }

}


// ===============================
// NON MEMBER
// ===============================
const transaksiNonMember = computed(() => {

  let data = tiket.value.filter(
    (item: any) => !item.member_id
  )

  if (filterStatus.value) {

    data = data.filter(
      (item: any) =>
        item.status === filterStatus.value
    )

  }

  const keyword = pencarian.value
    .trim()
    .toLowerCase()

  if (keyword) {

    data = data.filter((item: any) => {

      const kode =
        String(item.kode_tiket || "").toLowerCase()

      const polisi =
        String(item.no_polisi || "").toLowerCase()

      const kendaraan =
        String(item.jenis_kendaraan || "").toLowerCase()

      return (
        kode.includes(keyword) ||
        polisi.includes(keyword) ||
        kendaraan.includes(keyword)
      )

    })

  }

  return data

})


// ===============================
// MEMBER
// ===============================
const transaksiMember = computed(() => {

  const tiketMember = tiket.value.filter(
    (item: any) => !!item.member_id
  )

  let data = tiketMember.map((item: any) => {

    const member = members.value.find(
      (m: any) =>
        Number(m.id) === Number(item.member_id)
    )

    return {
      ...item,

      kode_member:
        member?.kode_member || "-",

      nama_member:
        member?.nama_member || "-",

      nama_perusahaan:
        member?.nama_perusahaan || "-"
    }

  })

  if (filterStatus.value) {

    data = data.filter(
      (item: any) =>
        item.status === filterStatus.value
    )

  }

  const keyword = pencarian.value
    .trim()
    .toLowerCase()

  if (keyword) {

    data = data.filter((item: any) => {

      return (
        String(item.kode_member || "")
          .toLowerCase()
          .includes(keyword) ||

        String(item.nama_member || "")
          .toLowerCase()
          .includes(keyword) ||

        String(item.nama_perusahaan || "")
          .toLowerCase()
          .includes(keyword)

      )

    })

  }

  return data

})


// ===============================
// PAGINATION NON MEMBER
// ===============================
const totalPagesNonMember = computed(() => {

  return Math.max(
    1,
    Math.ceil(
      transaksiNonMember.value.length / itemsPerPage
    )
  )

})


const transaksiNonMemberPagination = computed(() => {

  const start =
    (currentPageNonMember.value - 1) * itemsPerPage

  return transaksiNonMember.value.slice(
    start,
    start + itemsPerPage
  )

})


const startItemNonMember = computed(() => {

  if (transaksiNonMember.value.length === 0) {
    return 0
  }

  return (
    (currentPageNonMember.value - 1) *
      itemsPerPage +
    1
  )

})


const endItemNonMember = computed(() => {

  return Math.min(
    currentPageNonMember.value * itemsPerPage,
    transaksiNonMember.value.length
  )

})


function halamanSebelumnya() {

  if (currentPageNonMember.value > 1) {
    currentPageNonMember.value--
  }

}


function halamanBerikutnya() {

  if (
    currentPageNonMember.value <
    totalPagesNonMember.value
  ) {
    currentPageNonMember.value++
  }

}


function pilihHalaman(halaman: number) {

  if (
    halaman >= 1 &&
    halaman <= totalPagesNonMember.value
  ) {
    currentPageNonMember.value = halaman
  }

}


// ===============================
// PAGINATION MEMBER
// ===============================
const totalPagesMember = computed(() => {

  return Math.max(
    1,
    Math.ceil(
      transaksiMember.value.length / itemsPerPage
    )
  )

})


const transaksiMemberPagination = computed(() => {

  const start =
    (currentPageMember.value - 1) * itemsPerPage

  return transaksiMember.value.slice(
    start,
    start + itemsPerPage
  )

})


const startItemMember = computed(() => {

  if (transaksiMember.value.length === 0) {
    return 0
  }

  return (
    (currentPageMember.value - 1) *
      itemsPerPage +
    1
  )

})


const endItemMember = computed(() => {

  return Math.min(
    currentPageMember.value * itemsPerPage,
    transaksiMember.value.length
  )

})


function halamanSebelumnyaMember() {

  if (currentPageMember.value > 1) {
    currentPageMember.value--
  }

}


function halamanBerikutnyaMember() {

  if (
    currentPageMember.value <
    totalPagesMember.value
  ) {
    currentPageMember.value++
  }

}


function pilihHalamanMember(halaman: number) {

  if (
    halaman >= 1 &&
    halaman <= totalPagesMember.value
  ) {
    currentPageMember.value = halaman
  }

}


// ===============================
// GANTI TAB
// ===============================
function gantiJenisData(
  jenis: "non-member" | "member"
) {

  jenisData.value = jenis

  currentPageNonMember.value = 1
  currentPageMember.value = 1

}


// ===============================
// RESET HALAMAN SAAT FILTER
// ===============================
watch(
  [pencarian, filterStatus],
  () => {

    currentPageNonMember.value = 1
    currentPageMember.value = 1

  }
)


// ===============================
// STATISTIK
// ===============================
const totalTransaksi = computed(
  () => tiket.value.length
)


const sedangParkir = computed(
  () =>
    tiket.value.filter(
      (item: any) =>
        item.status === "masuk"
    ).length
)


const sudahKeluar = computed(
  () =>
    tiket.value.filter(
      (item: any) =>
        item.status === "keluar"
    ).length
)


const totalPendapatan = computed(() => {

  return tiket.value
    .filter(
      (item: any) =>
        !item.member_id &&
        item.status === "keluar"
    )
    .reduce(
      (total: number, item: any) =>
        total + getTotal(item),
      0
    )

})


// ===============================
// KEMBALI
// ===============================
function kembali() {
  router.replace("/petugas")
}


// ===============================
// LOAD
// ===============================
onMounted(() => {
  ambilData()
})

</script>