<template>
  <div class="min-h-screen bg-slate-50 flex">

    <!-- ================= SIDEBAR ================= -->

    <aside
      class="w-64 min-h-screen bg-[#172033] text-white flex flex-col fixed left-0 top-0 bottom-0"
    >

      <!-- LOGO -->

      <div
        class="px-6 py-6 border-b border-white/10"
      >

        <div class="flex items-center gap-3">

          <div
            class="w-10 h-10 rounded-xl bg-[#38BDF8] text-[#172033] flex items-center justify-center font-bold text-lg shadow-lg"
          >
            P
          </div>

          <div>

            <h1
              class="font-bold text-sm tracking-wide"
            >
              PARKIR
            </h1>

            <p
              class="text-[10px] text-slate-400"
            >
              SISTEM INFORMASI PARKIR
            </p>

          </div>

        </div>

      </div>


      <!-- PROFIL ADMIN -->

      <div class="px-5 py-6">

        <div class="flex items-center gap-3">

          <div
            class="w-10 h-10 rounded-full bg-[#38BDF8]/15 border border-[#38BDF8]/50 flex items-center justify-center text-[#7DD3FC] font-bold text-sm"
          >
            {{ inisialUser }}
          </div>

          <div class="min-w-0">

            <p
              class="text-sm font-semibold truncate"
            >
              {{ namaUser }}
            </p>

            <p
              class="text-xs text-slate-400"
            >
              Super Admin
            </p>

          </div>

        </div>

      </div>


      <!-- MENU -->

      <nav class="px-4 space-y-2">

        <!-- Dashboard -->

        <NuxtLink
          to="/super-admin"
          class="flex items-center gap-3 px-4 py-3 rounded-lg bg-[#38BDF8] text-[#172033] shadow-md shadow-[#38BDF8]/20"
        >

          <span class="text-lg">
            ⌂
          </span>

          <span class="text-sm font-semibold">
            Dashboard
          </span>

        </NuxtLink>


        <!-- Kelola Petugas -->

        <NuxtLink
          to="/super-admin/petugas"
          class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-white/5 hover:text-white transition"
        >

          <span class="text-lg">
            ♟
          </span>

          <span class="text-sm font-medium">
            Kelola Petugas
          </span>

        </NuxtLink>


        <!-- Laporan -->

        <NuxtLink
          to="/laporan/l_admin"
          class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-white/5 hover:text-white transition"
        >

          <span class="text-lg">
            ▣
          </span>

          <span class="text-sm font-medium">
            Laporan
          </span>

        </NuxtLink>

      </nav>


      <!-- BOTTOM SIDEBAR -->

      <div
        class="mt-auto px-5 py-5 border-t border-white/10 space-y-3"
      >

        <!-- LOGOUT -->

        <button
          @click="showLogoutModal = true"
          class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-red-500/10 border border-red-400/20 text-red-300 text-sm font-medium hover:bg-red-500 hover:text-white transition"
        >

          <span class="text-lg">
            ⏻
          </span>

          <span>
            Logout
          </span>

        </button>


        <!-- FOOTER -->

        <p
          class="text-[10px] text-slate-500 text-center"
        >
          Sistem Informasi Parkir
        </p>

      </div>

    </aside>


    <!-- ================= MAIN CONTENT ================= -->

    <main class="ml-64 flex-1 min-h-screen">


      <!-- HEADER -->

      <header
        class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-10"
      >

        <div>

          <p class="text-xs text-slate-400 mb-1">
            Dashboard
          </p>

          <h2
            class="text-xl font-bold text-[#172033]"
          >
            Selamat Datang, {{ namaUser }} 👋
          </h2>

        </div>


        <!-- PROFILE -->

        <div
          class="flex items-center gap-4"
        >

          <div class="text-right">

            <p
              class="text-sm font-semibold text-slate-700"
            >
              {{ namaUser }}
            </p>

            <p
              class="text-xs text-slate-400"
            >
              Super Admin
            </p>

          </div>


          <div
            class="w-10 h-10 rounded-full bg-[#38BDF8] text-[#172033] flex items-center justify-center font-bold shadow-sm"
          >
            {{ inisialUser }}
          </div>

        </div>

      </header>


      <!-- CONTENT -->

      <section class="p-8">


        <!-- ================= BANNER ================= -->

        <div
          class="relative overflow-hidden rounded-2xl bg-linear-to-r from-[#172033] via-[#1E3A5F] to-[#2563A8] p-7 text-white shadow-lg shadow-slate-900/10"
        >

          <!-- Dekorasi -->

          <div
            class="absolute -right-10 -top-16 w-48 h-48 rounded-full bg-[#38BDF8]/10"
          ></div>

          <div
            class="absolute right-24 -bottom-20 w-40 h-40 rounded-full bg-white/5"
          ></div>


          <div
            class="relative z-10 flex items-center justify-between"
          >

            <div>

              <p
                class="text-[11px] uppercase tracking-widest text-[#BAE6FD] mb-2"
              >
                Sistem Informasi Parkir
              </p>

              <h1
                class="text-2xl font-bold mb-2"
              >
                Halo, {{ namaUser }} 👋
              </h1>

              <p
                class="text-sm text-slate-200 max-w-xl"
              >
                Selamat datang di Dashboard Super Admin.
                Kelola petugas, pantau aktivitas parkir,
                dan akses laporan sistem dalam satu tempat.
              </p>

            </div>


            <!-- ICON -->

            <div
              class="hidden sm:flex w-14 h-14 rounded-2xl bg-white/10 border border-white/15 backdrop-blur-sm items-center justify-center text-2xl"
            >
              👤
            </div>

          </div>

        </div>


        <!-- ================= MENU UTAMA ================= -->

        <div class="mt-8">

          <div class="mb-5">

            <h2
              class="text-lg font-bold text-[#172033]"
            >
              Menu Utama
            </h2>

            <p
              class="text-xs text-slate-400 mt-1"
            >
              Akses fitur utama sistem
            </p>

          </div>


          <!-- CARDS -->

          <div
            class="grid grid-cols-1 md:grid-cols-2 gap-6"
          >


            <!-- ================= KELOLA PETUGAS ================= -->

            <NuxtLink
              to="/super-admin/petugas"
              class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:-translate-y-1 hover:shadow-lg transition duration-300"
            >

              <div
                class="flex items-start justify-between"
              >

                <div
                  class="w-12 h-12 rounded-xl bg-[#E0F2FE] text-[#0284C7] flex items-center justify-center text-xl"
                >
                  ♟
                </div>

                <span
                  class="text-slate-300 group-hover:text-[#38BDF8] transition text-xl"
                >
                  →
                </span>

              </div>


              <h3
                class="mt-5 text-base font-bold text-[#172033]"
              >
                Kelola Petugas
              </h3>

              <p
                class="mt-2 text-sm text-slate-400 leading-relaxed"
              >
                Tambah, edit, dan kelola data
                petugas parkir.
              </p>


              <div
                class="mt-5 text-xs text-[#0284C7] font-semibold"
              >
                Kelola Petugas →
              </div>

            </NuxtLink>


            <!-- ================= LAPORAN ================= -->

            <NuxtLink
              to="/laporan/l_admin"
              class="group bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:-translate-y-1 hover:shadow-lg transition duration-300"
            >

              <div
                class="flex items-start justify-between"
              >

                <div
                  class="w-12 h-12 rounded-xl bg-slate-100 text-[#172033] flex items-center justify-center text-xl"
                >
                  ▣
                </div>

                <span
                  class="text-slate-300 group-hover:text-[#38BDF8] transition text-xl"
                >
                  →
                </span>

              </div>


              <h3
                class="mt-5 text-base font-bold text-[#172033]"
              >
                Laporan
              </h3>

              <p
                class="mt-2 text-sm text-slate-400 leading-relaxed"
              >
                Lihat dan pantau berbagai laporan
                aktivitas parkir.
              </p>


              <div
                class="mt-5 text-xs text-[#0284C7] font-semibold"
              >
                Lihat Laporan →
              </div>

            </NuxtLink>

          </div>

        </div>


        <!-- ================= INFORMASI SISTEM ================= -->

        <div
          class="mt-6 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm"
        >

          <div class="flex items-start gap-4">

            <div
              class="w-10 h-10 rounded-xl bg-[#E0F2FE] text-[#0284C7] flex items-center justify-center text-lg shrink-0"
            >
              💡
            </div>

            <div>

              <h3
                class="font-semibold text-[#172033]"
              >
                Informasi Sistem
              </h3>

              <p
                class="text-sm text-slate-400 mt-1 leading-relaxed"
              >
                Gunakan menu di atas untuk mengelola
                petugas dan melihat laporan sistem parkir.
              </p>

            </div>

          </div>

        </div>


        <!-- FOOTER -->

        <div class="text-center mt-8">

          <p
            class="text-xs text-slate-400"
          >
            © 2026 Sistem Informasi Parkir
          </p>

        </div>

      </section>

    </main>


    <!-- ================= MODAL KONFIRMASI LOGOUT ================= -->

    <Teleport to="body">

      <div
        v-if="showLogoutModal"
        class="fixed inset-0 z-9999 bg-black/50 backdrop-blur-sm flex items-center justify-center px-4"
      >

        <div
          class="bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6"
        >

          <!-- ICON + JUDUL -->

          <div class="flex items-center gap-4">

            <div
              class="w-12 h-12 rounded-xl bg-red-50 text-red-500 flex items-center justify-center text-2xl shrink-0"
            >
              ⏻
            </div>


            <div>

              <h3
                class="font-bold text-slate-800"
              >
                Konfirmasi Logout
              </h3>

              <p
                class="text-sm text-slate-400 mt-1"
              >
                Apakah kamu yakin ingin keluar dari Super Admin?
              </p>

            </div>

          </div>


          <!-- BUTTON -->

          <div class="flex gap-3 mt-6">

            <!-- BATAL -->

            <button
              @click="showLogoutModal = false"
              class="flex-1 px-4 py-2.5 rounded-lg border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition"
            >
              Batal
            </button>


            <!-- YA LOGOUT -->

            <button
              @click="handleLogout"
              class="flex-1 px-4 py-2.5 rounded-lg bg-red-500 text-white text-sm font-medium hover:bg-red-600 transition"
            >
              Ya, Logout
            </button>

          </div>

        </div>

      </div>

    </Teleport>

  </div>
</template>


<script setup lang="ts">

import {
  ref,
  onMounted
} from 'vue'


// ==========================================
// DATA USER LOGIN
// ==========================================

const namaUser =
  ref('Super Admin')


const inisialUser =
  ref('SA')


// ==========================================
// MODAL LOGOUT
// ==========================================

const showLogoutModal =
  ref(false)


// ==========================================
// AMBIL DATA USER LOGIN
// ==========================================

const ambilDataUser = () => {

  if (!import.meta.client) {

    return

  }


  const nama =
    localStorage.getItem(
      'login_name'
    )


  const inisial =
    localStorage.getItem(
      'login_initials'
    )


  if (nama) {

    namaUser.value =
      nama

  }


  if (inisial) {

    inisialUser.value =
      inisial

  }

}


// ==========================================
// LOGOUT SUPER ADMIN
// ==========================================

function handleLogout() {

  try {

    localStorage.removeItem(
      "role"
    )

    localStorage.removeItem(
      "email"
    )

    localStorage.removeItem(
      "token"
    )

    localStorage.removeItem(
      "auth_token"
    )

    localStorage.removeItem(
      "loggedIn"
    )

    localStorage.removeItem(
      "user"
    )

    localStorage.removeItem(
      "login_name"
    )

    localStorage.removeItem(
      "login_initials"
    )


    sessionStorage.clear()


    showLogoutModal.value =
      false


    window.location.href =
      "/"

  } catch (error) {

    console.error(
      "Logout gagal:",
      error
    )


    window.location.href =
      "/"

  }

}


// ==========================================
// SAAT HALAMAN DIBUKA
// ==========================================

onMounted(() => {

  ambilDataUser()

})

</script>