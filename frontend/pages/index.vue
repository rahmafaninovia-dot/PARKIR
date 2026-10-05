<template>
  <div
    class="min-h-screen bg-linear-to-br from-[#0F172A] via-[#172033] to-[#1E3A5F] flex items-center justify-center px-4 py-6 relative overflow-hidden"
  >

    <!-- ================================================= -->
    <!-- BACKGROUND DECORATION -->
    <!-- ================================================= -->

    <div
      class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-[#38BDF8]/15 blur-3xl"
    ></div>

    <div
      class="absolute -bottom-24 -left-24 w-80 h-80 rounded-full bg-[#38BDF8]/10 blur-3xl"
    ></div>

    <div
      class="absolute top-20 left-10 w-20 h-20 rounded-full border border-white/5"
    ></div>

    <div
      class="absolute bottom-20 right-10 w-16 h-16 rounded-full border border-[#38BDF8]/10"
    ></div>


    <!-- ================================================= -->
    <!-- LOGIN CARD -->
    <!-- ================================================= -->

    <div
      class="relative z-10 w-full max-w-sm bg-white rounded-3xl shadow-[0_30px_80px_rgba(15,23,42,0.45)] overflow-hidden"
    >

      <!-- ================================================= -->
      <!-- HEADER -->
      <!-- ================================================= -->

      <div
        class="relative bg-[#172033] px-6 py-8 text-center overflow-hidden"
      >

        <div
          class="absolute -top-12 -right-12 w-40 h-40 rounded-full bg-[#38BDF8]/10"
        ></div>

        <div
          class="absolute -bottom-16 -left-16 w-44 h-44 rounded-full border border-[#38BDF8]/10"
        ></div>

        <div class="relative z-10">

          <!-- LOGO -->

          <div
            class="w-14 h-14 mx-auto rounded-2xl bg-[#38BDF8] text-[#172033] flex items-center justify-center shadow-lg shadow-[#38BDF8]/20"
          >
            <span class="text-2xl">
              🚗
            </span>
          </div>


          <!-- TITLE -->

          <h1
            class="mt-4 text-2xl font-extrabold text-white tracking-tight"
          >
            PARKIR PLAZA ANDALAS
          </h1>

          <p class="text-xs text-slate-300 mt-1">
            Sistem Informasi Manajemen Parkir
          </p>

        </div>

      </div>


      <!-- ================================================= -->
      <!-- LOGIN -->
      <!-- ================================================= -->

      <div class="px-6 py-6">

        <!-- JUDUL -->

        <div class="mb-5">

          <h2 class="text-lg font-bold text-[#172033]">
            Masuk ke Sistem
          </h2>

          <p class="text-xs text-slate-500 mt-1">
            Silakan masukkan email dan password Anda
          </p>

        </div>


        <!-- ERROR -->

        <div
          v-if="error"
          class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-xs text-red-600"
        >
          {{ error }}
        </div>


        <!-- EMAIL -->

        <div class="mb-4">

          <label
            class="block text-xs font-semibold text-slate-700 mb-2"
          >
            Email
          </label>

          <input
            v-model="email"
            type="email"
            placeholder="Masukkan email"
            autocomplete="email"
            class="w-full h-11 px-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none focus:bg-white focus:border-[#38BDF8] focus:ring-2 focus:ring-[#38BDF8]/20 transition"
            @keyup.enter="login"
          />

        </div>


        <!-- PASSWORD -->

        <div class="mb-4">

          <div class="flex items-center justify-between mb-2">

            <label
              class="text-xs font-semibold text-slate-700"
            >
              Password
            </label>


            <!-- LUPA PASSWORD -->

            <NuxtLink
              to="/forgot-password"
              class="text-[11px] font-semibold text-[#0284C7] hover:text-[#0369A1] transition"
            >
              Lupa password?
            </NuxtLink>

          </div>


          <!-- PASSWORD INPUT -->

          <div class="relative">

            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Masukkan password"
              autocomplete="current-password"
              class="w-full h-11 px-3 pr-11 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 outline-none focus:bg-white focus:border-[#38BDF8] focus:ring-2 focus:ring-[#38BDF8]/20 transition"
              @keyup.enter="login"
            />


            <!-- TOMBOL MATA -->

            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-[#38BDF8] transition"
              :title="
                showPassword
                  ? 'Sembunyikan password'
                  : 'Lihat password'
              "
              aria-label="Tampilkan atau sembunyikan password"
            >

              <!-- MATA TERBUKA -->

              <svg
                v-if="showPassword"
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >

                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
                />

                <circle
                  cx="12"
                  cy="12"
                  r="2.5"
                />

              </svg>


              <!-- MATA TERTUTUP -->

              <svg
                v-else
                class="w-5 h-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
              >

                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 3l18 18"
                />

                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M10.6 10.6a2 2 0 001.4 4"
                />

                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9.9 5.2A10.6 10.6 0 0112 5c6 0 9.5 7 9.5 7a17.4 17.4 0 01-4.1 4.8"
                />

                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6.3 6.3C3.8 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1 0 2-.1 2.9-.4"
                />

              </svg>

            </button>

          </div>

        </div>


        <!-- LOGIN BUTTON -->

        <button
          type="button"
          @click="login"
          :disabled="loading"
          class="w-full h-11 rounded-xl bg-[#38BDF8] hover:bg-[#0EA5E9] text-[#172033] text-sm font-extrabold shadow-md shadow-[#38BDF8]/20 transition disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ loading ? 'MEMPROSES...' : 'MASUK KE SISTEM' }}
        </button>


        <!-- INFO -->

        <div
          class="mt-5 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3"
        >

          <p
            class="text-[10px] text-slate-400 text-center leading-relaxed"
          >
            Masukkan email dan password sesuai akun yang telah
            terdaftar di sistem.
          </p>

        </div>


        <!-- FOOTER -->

        <p
          class="text-center text-[10px] text-slate-400 mt-5"
        >
          © 2026 Parkir Plaza Andalas
        </p>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import { ref } from 'vue'

const router = useRouter()


// ==========================================
// LOGIN
// ==========================================

const email = ref('')
const password = ref('')

const loading = ref(false)
const error = ref('')

const showPassword = ref(false)


// ==========================================
// AKUN DEFAULT
// ==========================================

const ADMIN_EMAIL = 'admin@parkir.com'
const ADMIN_PASSWORD = 'admin123'

const PETUGAS_EMAIL = 'petugas@parkir.com'
const PETUGAS_PASSWORD = 'petugas123'


// ==========================================
// AMBIL PASSWORD ADMIN
// ==========================================

const getPasswordAdmin = () => {

  if (!process.client) {
    return ADMIN_PASSWORD
  }

  return (
    localStorage.getItem('password_admin') ||
    ADMIN_PASSWORD
  )
}


// ==========================================
// AMBIL PASSWORD PETUGAS
// ==========================================

const getPasswordPetugas = () => {

  if (!process.client) {
    return PETUGAS_PASSWORD
  }

  return (
    localStorage.getItem('password_petugas') ||
    PETUGAS_PASSWORD
  )
}


// ==========================================
// LOGIN
// ==========================================

const login = async () => {

  error.value = ''


  // ==========================================
  // VALIDASI
  // ==========================================

  if (!email.value || !password.value) {

    error.value =
      'Email dan password wajib diisi.'

    return
  }


  loading.value = true


  // ==========================================
  // SUPER ADMIN
  // ==========================================

  if (
    email.value.trim() === ADMIN_EMAIL &&
    password.value === getPasswordAdmin()
  ) {

    localStorage.setItem(
      'role',
      'super_admin'
    )

    localStorage.setItem(
      'email',
      ADMIN_EMAIL
    )

    loading.value = false

    await router.push(
      '/super-admin'
    )

    return
  }


  // ==========================================
  // PETUGAS
  // ==========================================

  if (
    email.value.trim() === PETUGAS_EMAIL &&
    password.value === getPasswordPetugas()
  ) {

    localStorage.setItem(
      'role',
      'petugas'
    )

    localStorage.setItem(
      'email',
      PETUGAS_EMAIL
    )

    loading.value = false

    await router.push(
      '/petugas'
    )

    return
  }


  // ==========================================
  // LOGIN GAGAL
  // ==========================================

  error.value =
    'Email atau password salah.'

  loading.value = false
}

</script>