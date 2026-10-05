<template>
  <div
    class="min-h-screen bg-slate-100 flex items-center justify-center px-4 py-8"
  >

    <!-- CARD -->

    <div
      class="w-full max-w-lg bg-white rounded-3xl shadow-[0_20px_60px_rgba(15,23,42,0.15)] overflow-hidden"
    >

      <!-- ============================== -->
      <!-- HEADER -->
      <!-- ============================== -->

      <div class="px-6 pt-8 pb-6 text-center">

        <!-- ICON -->

        <div
          class="mx-auto w-16 h-16 rounded-full bg-[#EFF6FF] flex items-center justify-center"
        >

          <!-- ICON EMAIL -->

          <svg
            v-if="step === 1"
            xmlns="http://www.w3.org/2000/svg"
            class="w-8 h-8 text-[#2563EB]"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M16 12a4 4 0 10-8 0 4 4 0 008 0z"
            />

            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 14v2"
            />

            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M7 20h10"
            />

            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M5 20h14"
            />
          </svg>


          <!-- ICON OTP -->

          <svg
            v-else-if="step === 2"
            xmlns="http://www.w3.org/2000/svg"
            class="w-8 h-8 text-[#2563EB]"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M15 10l4.55-2.275A1 1 0 0121 8.618v6.764a1 1 0 01-1.45.893L15 14"
            />

            <rect
              width="10"
              height="12"
              x="3"
              y="6"
              rx="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />

            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M8 10h.01M8 14h.01M11 10h.01M11 14h.01"
            />
          </svg>


          <!-- ICON PASSWORD -->

          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="w-8 h-8 text-[#2563EB]"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
          >
            <rect
              x="4"
              y="11"
              width="16"
              height="10"
              rx="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />

            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M8 11V8a4 4 0 018 0v3"
            />

            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M12 15v2"
            />
          </svg>

        </div>


        <!-- TITLE -->

        <h1
          class="mt-5 text-3xl font-extrabold text-slate-800"
        >
          Lupa Password
        </h1>

        <p class="mt-2 text-sm text-slate-500">
          Masukkan detail akun kamu
        </p>


        <!-- ============================== -->
        <!-- STEP INDICATOR -->
        <!-- ============================== -->

        <div
          class="mt-8 flex items-center justify-center"
        >

          <!-- STEP 1 -->

          <div class="flex items-center">

            <div class="flex flex-col items-center">

              <div
                :class="
                  step === 1
                    ? 'bg-[#2563EB] text-white'
                    : step > 1
                      ? 'bg-[#2563EB] text-white'
                      : 'bg-slate-200 text-slate-500'
                "
                class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition"
              >
                <span v-if="step > 1">
                  ✓
                </span>

                <span v-else>
                  1
                </span>
              </div>

              <span
                :class="
                  step >= 1
                    ? 'text-[#2563EB]'
                    : 'text-slate-400'
                "
                class="mt-2 text-xs font-semibold"
              >
                Email
              </span>

            </div>

          </div>


          <!-- LINE -->

          <div
            :class="
              step >= 2
                ? 'bg-[#2563EB]'
                : 'bg-slate-200'
            "
            class="w-20 h-1 mx-2 rounded-full transition"
          ></div>


          <!-- STEP 2 -->

          <div class="flex items-center">

            <div class="flex flex-col items-center">

              <div
                :class="
                  step === 2
                    ? 'bg-[#2563EB] text-white'
                    : step > 2
                      ? 'bg-[#2563EB] text-white'
                      : 'bg-slate-200 text-slate-500'
                "
                class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition"
              >

                <span v-if="step > 2">
                  ✓
                </span>

                <span v-else>
                  2
                </span>

              </div>

              <span
                :class="
                  step >= 2
                    ? 'text-[#2563EB]'
                    : 'text-slate-400'
                "
                class="mt-2 text-xs font-semibold"
              >
                OTP
              </span>

            </div>

          </div>


          <!-- LINE -->

          <div
            :class="
              step >= 3
                ? 'bg-[#2563EB]'
                : 'bg-slate-200'
            "
            class="w-20 h-1 mx-2 rounded-full transition"
          ></div>


          <!-- STEP 3 -->

          <div class="flex flex-col items-center">

            <div
              :class="
                step === 3
                  ? 'bg-[#2563EB] text-white'
                  : 'bg-slate-200 text-slate-500'
              "
              class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold transition"
            >
              3
            </div>

            <span
              :class="
                step === 3
                  ? 'text-[#2563EB]'
                  : 'text-slate-400'
              "
              class="mt-2 text-xs font-semibold"
            >
              Password
            </span>

          </div>

        </div>

      </div>


      <!-- ============================== -->
      <!-- CONTENT -->
      <!-- ============================== -->

      <div class="px-6 pb-8">


        <!-- ============================== -->
        <!-- ERROR -->
        <!-- ============================== -->

        <div
          v-if="errorMessage"
          class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600"
        >
          {{ errorMessage }}
        </div>


        <!-- ============================== -->
        <!-- SUCCESS -->
        <!-- ============================== -->

        <div
          v-if="successMessage"
          class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-600"
        >
          {{ successMessage }}
        </div>


        <!-- ============================== -->
        <!-- STEP 1 EMAIL -->
        <!-- ============================== -->

        <div v-if="step === 1">

          <div
            class="mb-5 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3"
          >

            <p
              class="text-xs font-semibold text-slate-700"
            >
              1. Email Akun
            </p>

            <p
              class="text-xs text-slate-500 mt-1"
            >
              Masukkan email Admin atau Petugas yang
              terdaftar pada sistem.
            </p>

          </div>


          <label
            class="block text-sm font-semibold text-slate-700 mb-2"
          >
            Email
          </label>


          <input
            v-model="email"
            type="email"
            placeholder="Masukkan email"
            autocomplete="email"
            class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white text-sm text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/10"
            @keyup.enter="kirimOtp"
          />


          <p class="mt-2 text-xs text-slate-400">
            OTP akan dikirim ke nomor WhatsApp yang sudah
            dikonfigurasi untuk fitur lupa password.
          </p>


          <button
            type="button"
            @click="kirimOtp"
            :disabled="loading"
            class="w-full h-12 mt-5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-bold transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{
              loading
                ? 'Mengirim OTP...'
                : 'Kirim OTP WhatsApp'
            }}
          </button>


          <NuxtLink
            to="/"
            class="block text-center text-sm font-semibold text-slate-500 hover:text-[#2563EB] mt-5 transition"
          >
            ← Kembali ke Login
          </NuxtLink>

        </div>


        <!-- ============================== -->
        <!-- STEP 2 OTP -->
        <!-- ============================== -->

        <div v-else-if="step === 2">

          <div
            class="mb-5 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3"
          >

            <p
              class="text-xs font-semibold text-slate-700"
            >
              2. Verifikasi OTP
            </p>

            <p
              class="text-xs text-slate-500 mt-1"
            >
              Masukkan kode OTP 6 digit yang dikirim
              ke WhatsApp.
            </p>

          </div>


          <div class="text-center mb-5">

            <p class="text-xs text-slate-500">
              Email akun
            </p>

            <p
              class="mt-1 text-sm font-bold text-slate-800"
            >
              {{ email }}
            </p>

          </div>


          <label
            class="block text-sm font-semibold text-slate-700 mb-2"
          >
            Kode OTP
          </label>


          <input
            v-model="otp"
            type="text"
            inputmode="numeric"
            maxlength="6"
            placeholder="000000"
            class="w-full h-14 rounded-xl border border-slate-300 bg-white text-center text-2xl font-extrabold tracking-[0.5em] text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/10"
            @input="
              otp = otp
                .replace(/\D/g, '')
                .slice(0, 6)
            "
            @keyup.enter="verifikasiOtp"
          />


          <!-- COUNTDOWN -->

          <div
            class="mt-5 text-center"
          >

            <p
              class="text-xs text-slate-500"
            >
              Kode OTP berlaku selama
            </p>

            <p
              :class="
                sisaWaktu <= 30
                  ? 'text-red-500'
                  : 'text-[#2563EB]'
              "
              class="mt-1 text-2xl font-extrabold"
            >
              {{ formatWaktu(sisaWaktu) }}
            </p>

          </div>


          <button
            type="button"
            @click="verifikasiOtp"
            :disabled="
              loading ||
              otp.length !== 6 ||
              sisaWaktu <= 0
            "
            class="w-full h-12 mt-5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-bold transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{
              loading
                ? 'Memverifikasi...'
                : 'Verifikasi OTP'
            }}
          </button>


          <button
            type="button"
            @click="kembaliKeEmail"
            class="w-full mt-4 text-sm font-semibold text-slate-500 hover:text-[#2563EB] transition"
          >
            ← Ganti Email
          </button>

        </div>


        <!-- ============================== -->
        <!-- STEP 3 PASSWORD -->
        <!-- ============================== -->

        <div v-else>

          <div
            class="mb-5 rounded-xl bg-slate-50 border border-slate-200 px-4 py-3"
          >

            <p
              class="text-xs font-semibold text-slate-700"
            >
              3. Password Baru
            </p>

            <p
              class="text-xs text-slate-500 mt-1"
            >
              Buat password baru untuk akun kamu.
            </p>

          </div>


          <label
            class="block text-sm font-semibold text-slate-700 mb-2"
          >
            Password Baru
          </label>


          <input
            v-model="password"
            type="password"
            placeholder="Masukkan password baru"
            autocomplete="new-password"
            class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white text-sm text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/10"
          />


          <label
            class="block text-sm font-semibold text-slate-700 mb-2 mt-4"
          >
            Konfirmasi Password
          </label>


          <input
            v-model="passwordConfirmation"
            type="password"
            placeholder="Ulangi password baru"
            autocomplete="new-password"
            class="w-full h-12 px-4 rounded-xl border border-slate-300 bg-white text-sm text-slate-800 outline-none transition focus:border-[#2563EB] focus:ring-4 focus:ring-[#2563EB]/10"
          />


          <button
            type="button"
            @click="resetPassword"
            :disabled="loading"
            class="w-full h-12 mt-5 rounded-xl bg-[#2563EB] hover:bg-[#1D4ED8] text-white text-sm font-bold transition disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{
              loading
                ? 'Menyimpan...'
                : 'Ubah Password'
            }}
          </button>


          <p
            class="mt-3 text-center text-xs text-slate-400"
          >
            Setelah berhasil, silakan login kembali
            menggunakan password baru.
          </p>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

const { $api } = useNuxtApp()

const router = useRouter()


// ==================================================
// DATA
// ==================================================

const step = ref(1)

const email = ref('')

const otp = ref('')

const password = ref('')

const passwordConfirmation = ref('')

const loading = ref(false)

const errorMessage = ref('')

const successMessage = ref('')

const sisaWaktu = ref(0)

let timer: ReturnType<typeof setInterval> | null = null


// ==================================================
// STOP TIMER
// ==================================================

const stopTimer = () => {

  if (timer) {

    clearInterval(timer)

    timer = null
  }
}


// ==================================================
// START TIMER
// ==================================================

const startTimer = () => {

  stopTimer()

  sisaWaktu.value = 300

  timer = setInterval(() => {

    if (sisaWaktu.value > 0) {

      sisaWaktu.value--

    } else {

      stopTimer()
    }

  }, 1000)
}


// ==================================================
// FORMAT WAKTU
// ==================================================

const formatWaktu = (detik: number) => {

  const menit = Math.floor(detik / 60)

  const detikSisa = detik % 60

  return `${String(menit).padStart(2, '0')}:${String(detikSisa).padStart(2, '0')}`
}


// ==================================================
// KIRIM OTP
// ==================================================

const kirimOtp = async () => {

  errorMessage.value = ''

  successMessage.value = ''


  // ==================================================
  // VALIDASI EMAIL
  // ==================================================

  if (!email.value.trim()) {

    errorMessage.value =
      'Email wajib diisi.'

    return
  }


  loading.value = true


  try {

    const response = await $api.post(
      '/forgot-password/check-email',
      {
        email: email.value.trim()
      }
    )


    // ==================================================
    // CEK RESPONSE
    // ==================================================

    if (!response?.data?.success) {

      errorMessage.value =
        response?.data?.message ||
        'OTP gagal dikirim.'

      return
    }


    // ==================================================
    // BERHASIL
    // ==================================================

    successMessage.value =
      response?.data?.message ||
      'OTP berhasil dikirim ke WhatsApp.'


    otp.value = ''

    password.value = ''

    passwordConfirmation.value = ''

    step.value = 2

    startTimer()


  } catch (error: any) {

    errorMessage.value =
      error?.response?.data?.message ||
      'Terjadi kesalahan saat mengirim OTP.'

  } finally {

    loading.value = false
  }
}


// ==================================================
// VERIFIKASI OTP
// ==================================================

const verifikasiOtp = async () => {

  errorMessage.value = ''

  successMessage.value = ''


  // ==================================================
  // VALIDASI OTP
  // ==================================================

  if (otp.value.length !== 6) {

    errorMessage.value =
      'Kode OTP harus 6 digit.'

    return
  }


  // ==================================================
  // CEK COUNTDOWN
  // ==================================================

  if (sisaWaktu.value <= 0) {

    errorMessage.value =
      'Kode OTP sudah kadaluarsa. Silakan minta OTP baru.'

    return
  }


  loading.value = true


  try {

    const response = await $api.post(
      '/forgot-password/verify-otp',
      {
        email: email.value.trim(),

        otp: otp.value
      }
    )


    // ==================================================
    // CEK RESPONSE
    // ==================================================

    if (!response?.data?.success) {

      errorMessage.value =
        response?.data?.message ||
        'OTP tidak valid.'

      return
    }


    // ==================================================
    // OTP BENAR
    // ==================================================

    stopTimer()


    // ==================================================
    // SIMPAN DATA RESET
    // ==================================================

    localStorage.setItem(
      'forgot_password_email',
      email.value.trim()
    )


    localStorage.setItem(
      'forgot_password_reset_token',
      response.data.reset_token
    )


    // ==================================================
    // PINDAH KE STEP 3
    // ==================================================

    successMessage.value =
      'OTP benar. Silakan buat password baru.'


    step.value = 3


  } catch (error: any) {

    errorMessage.value =
      error?.response?.data?.message ||
      'OTP salah atau sudah kadaluarsa.'

  } finally {

    loading.value = false
  }
}


// ==================================================
// RESET PASSWORD
// ==================================================

const resetPassword = async () => {

  errorMessage.value = ''

  successMessage.value = ''


  // ==================================================
  // VALIDASI PASSWORD
  // ==================================================

  if (!password.value) {

    errorMessage.value =
      'Password baru wajib diisi.'

    return
  }


  if (password.value.length < 8) {

    errorMessage.value =
      'Password minimal 8 karakter.'

    return
  }


  if (!passwordConfirmation.value) {

    errorMessage.value =
      'Konfirmasi password wajib diisi.'

    return
  }


  if (
    password.value !==
    passwordConfirmation.value
  ) {

    errorMessage.value =
      'Konfirmasi password tidak sama.'

    return
  }


  // ==================================================
  // AMBIL RESET TOKEN
  // ==================================================

  const resetToken =
    localStorage.getItem(
      'forgot_password_reset_token'
    )


  if (!resetToken) {

    errorMessage.value =
      'Token reset tidak ditemukan. Silakan ulangi proses lupa password.'

    return
  }


  loading.value = true


  try {

    const response = await $api.post(
      '/forgot-password/reset',
      {
        email: email.value.trim(),

        reset_token: resetToken,

        password: password.value,

        password_confirmation:
          passwordConfirmation.value
      }
    )


    // ==================================================
    // CEK RESPONSE
    // ==================================================

    if (!response?.data?.success) {

      errorMessage.value =
        response?.data?.message ||
        'Password gagal diubah.'

      return
    }


    // ==================================================
    // SIMPAN PASSWORD BARU
    // ==================================================
    //
    // Controller mengirim:
    //
    // password_key:
    // password_admin
    //
    // atau:
    //
    // password_petugas
    //
    // Sesuai email yang melakukan reset.
    //

    if (response?.data?.password_key) {

      localStorage.setItem(
        response.data.password_key,
        password.value
      )

    }


    // ==================================================
    // HAPUS DATA RESET
    // ==================================================

    localStorage.removeItem(
      'forgot_password_email'
    )

    localStorage.removeItem(
      'forgot_password_reset_token'
    )


    // ==================================================
    // BERHASIL
    // ==================================================

    successMessage.value =
      'Password berhasil diubah. Silakan login kembali.'


    // ==================================================
    // KEMBALI KE LOGIN
    // ==================================================

    setTimeout(() => {

      router.push('/')

    }, 1500)


  } catch (error: any) {

    errorMessage.value =
      error?.response?.data?.message ||
      'Terjadi kesalahan saat mengubah password.'

  } finally {

    loading.value = false
  }
}


// ==================================================
// KEMBALI KE EMAIL
// ==================================================

const kembaliKeEmail = () => {

  stopTimer()

  step.value = 1

  otp.value = ''

  password.value = ''

  passwordConfirmation.value = ''

  errorMessage.value = ''

  successMessage.value = ''

  sisaWaktu.value = 0
}


// ==================================================
// CLEANUP
// ==================================================

onBeforeUnmount(() => {

  stopTimer()

})

</script>