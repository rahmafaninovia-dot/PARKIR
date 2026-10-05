<template>

  <div
    class="
      min-h-screen
      flex
      items-center
      justify-center
      relative
      overflow-hidden
      px-4
      py-6
      bg-[#F8FAFC]
    "
  >

    <!-- BACKGROUND -->

    <div
      class="
        absolute
        inset-0
        bg-linear-to-br
        from-[#172033]
        via-[#1E3A5C]
        to-[#38BDF8]
      "
    ></div>

    <div
      class="
        absolute
        -top-24
        -right-24
        w-80
        h-80
        rounded-full
        bg-[#38BDF8]/20
        blur-3xl
      "
    ></div>

    <div
      class="
        absolute
        -bottom-24
        -left-24
        w-80
        h-80
        rounded-full
        bg-white/10
        blur-3xl
      "
    ></div>


    <!-- CARD -->

    <div
      class="
        relative
        z-10
        w-full
        max-w-md
        bg-[#F8FAFC]
        rounded-4xl
        overflow-hidden
        shadow-[0_30px_80px_rgba(0,0,0,0.40)]
      "
    >

      <!-- HEADER -->

      <div
        class="
          relative
          bg-[#172033]
          px-6
          pt-9
          pb-11
          overflow-hidden
        "
      >

        <div
          class="
            absolute
            -top-12
            -right-12
            w-40
            h-40
            rounded-full
            bg-[#38BDF8]/10
          "
        ></div>

        <div
          class="
            absolute
            -bottom-16
            -left-16
            w-44
            h-44
            rounded-full
            border
            border-[#38BDF8]/20
          "
        ></div>

        <div
          class="
            relative
            z-10
            text-center
          "
        >

          <div
            class="
              mx-auto
              w-16
              h-16
              rounded-2xl
              bg-[#38BDF8]
              text-white
              flex
              items-center
              justify-center
              text-3xl
              shadow-xl
              shadow-black/20
            "
          >
            🚗
          </div>

          <h1
            class="
              mt-4
              text-3xl
              font-black
              text-white
              leading-tight
              tracking-tight
            "
          >
            PARKIR<br>

            <span class="text-[#E0F2FE]">
              PLAZA ANDALAS
            </span>
          </h1>

          <p
            class="
              mt-2
              text-xs
              text-slate-400
            "
          >
            Sistem Informasi Parkir
          </p>

        </div>

      </div>


      <!-- CONTENT -->

      <div
        class="
          relative
          -mt-5
          bg-[#F8FAFC]
          rounded-t-4xl
          px-5
          pt-6
          pb-7
        "
      >

        <!-- NON MEMBER -->

        <div
          class="
            w-full
            rounded-2xl
            border
            border-[#38BDF8]/15
            bg-white
            p-5
            shadow-sm
          "
        >

          <div class="flex items-center gap-3">

            <div
              class="
                w-12
                h-12
                rounded-xl
                bg-[#38BDF8]
                text-white
                flex
                items-center
                justify-center
                text-xl
                shadow-md
                shadow-[#38BDF8]/20
                shrink-0
              "
            >
              🎫
            </div>

            <div>

              <p
                class="
                  text-[10px]
                  font-bold
                  text-[#0284C7]
                  uppercase
                  tracking-[0.15em]
                "
              >
                Pengunjung
              </p>

              <h2
                class="
                  text-lg
                  font-extrabold
                  text-[#172033]
                "
              >
                Ambil Tiket Parkir
              </h2>

            </div>

          </div>


          <p
            class="
              mt-4
              text-sm
              text-slate-500
              text-center
              leading-relaxed
            "
          >
            Belum mempunyai member?
            <br>
            Tekan tombol
            <span class="font-bold text-[#0284C7]">
              PRINT
            </span>
            untuk mengambil tiket.
          </p>


          <button
            type="button"
            @click="printTicket"
            :disabled="printLoading"
            class="
              mt-5
              w-full
              h-12
              rounded-xl
              bg-[#38BDF8]
              text-white
              font-extrabold
              tracking-wide
              shadow-lg
              shadow-[#38BDF8]/20
              hover:bg-[#0EA5E9]
              hover:-translate-y-0.5
              disabled:bg-slate-300
              disabled:text-slate-500
              disabled:shadow-none
              transition-all
              duration-200
              active:scale-[0.98]
            "
          >

            <span v-if="!printLoading">
              🖨 PRINT
            </span>

            <span v-else>
              ⏳ MEMPROSES...
            </span>

          </button>

        </div>


        <!-- PEMISAH -->

        <div
          class="
            flex
            items-center
            gap-3
            my-6
          "
        >

          <div class="flex-1 h-px bg-[#CBD5E1]"></div>

          <span
            class="
              text-[10px]
              font-bold
              text-slate-400
              uppercase
              tracking-widest
            "
          >
            Member
          </span>

          <div class="flex-1 h-px bg-[#CBD5E1]"></div>

        </div>


        <!-- MEMBER -->

        <div
          class="
            w-full
            rounded-2xl
            border
            border-[#38BDF8]/15
            bg-white
            p-5
            shadow-sm
          "
        >

          <div
            class="
              flex
              items-center
              justify-center
              gap-2
            "
          >

            <div
              class="
                w-10
                h-10
                rounded-xl
                bg-[#E0F2FE]
                text-[#0284C7]
                flex
                items-center
                justify-center
                text-lg
              "
            >
              💳
            </div>

            <p
              class="
                text-[#172033]
                text-sm
                font-extrabold
              "
            >
              Member
            </p>

          </div>


          <p
            class="
              mt-2
              text-slate-400
              text-xs
              text-center
            "
          >
            Scan barcode member atau masukkan kode member
          </p>


          <input
            ref="inputMember"
            v-model="scanCard"
            autofocus
            type="text"
            autocomplete="off"
            placeholder="Scan barcode / kode member"
            :disabled="memberLoading"
            class="
              mt-4
              w-full
              h-14
              rounded-xl
              bg-[#F8FAFC]
              border-2
              border-[#38BDF8]/15
              text-[#172033]
              text-center
              text-base
              font-semibold
              px-4
              outline-none
              placeholder:text-slate-400
              focus:bg-white
              focus:border-[#38BDF8]
              focus:ring-4
              focus:ring-[#38BDF8]/10
              disabled:bg-slate-100
              transition-all
            "
            @keyup.enter="openGate"
          />


          <button
            type="button"
            @click="openGate"
            :disabled="memberLoading"
            class="
              mt-4
              w-full
              h-12
              rounded-xl
              bg-[#172033]
              text-white
              font-extrabold
              tracking-wide
              shadow-md
              hover:bg-[#1E293B]
              hover:-translate-y-0.5
              disabled:bg-slate-300
              disabled:text-slate-500
              transition-all
              duration-200
              active:scale-[0.98]
            "
          >

            <span v-if="!memberLoading">
              🚪 BUKA PINTU
            </span>

            <span v-else>
              ⏳ MEMERIKSA...
            </span>

          </button>

        </div>


        <!-- NOTIFIKASI -->

        <transition name="fade">

          <div
            v-if="showNotification"
            class="
              w-full
              mt-5
              rounded-2xl
              p-4
              border
              shadow-sm
            "
            :class="
              notificationSuccess
                ? 'bg-[#F0F9FF] border-[#BAE6FD]'
                : 'bg-red-50 border-red-200'
            "
          >

            <div class="flex items-start gap-3">

              <div
                class="
                  w-10
                  h-10
                  rounded-xl
                  flex
                  items-center
                  justify-center
                  text-xl
                  shrink-0
                "
                :class="
                  notificationSuccess
                    ? 'bg-[#E0F2FE]'
                    : 'bg-red-100'
                "
              >
                {{ notificationSuccess ? '✅' : '❌' }}
              </div>

              <div class="flex-1">

                <p
                  class="
                    text-sm
                    font-extrabold
                    text-[#172033]
                  "
                >
                  {{ notificationTitle }}
                </p>

                <p
                  class="
                    mt-1
                    text-xs
                    text-slate-500
                    leading-relaxed
                  "
                >
                  {{ notificationMessage }}
                </p>

                <div
                  v-if="notificationSuccess"
                  class="
                    mt-3
                    pt-3
                    border-t
                    border-[#BAE6FD]
                    space-y-1
                    text-xs
                    text-slate-600
                  "
                >

                  <p>
                    <span class="font-semibold">
                      Nama:
                    </span>
                    {{ memberName }}
                  </p>

                  <p>
                    <span class="font-semibold">
                      Kode:
                    </span>
                    {{ memberCode }}
                  </p>

                  <p
                    class="
                      mt-2
                      font-bold
                      text-[#0284C7]
                    "
                  >
                    🚪 Pintu masuk terbuka
                  </p>

                </div>

              </div>

            </div>

          </div>

        </transition>


        <!-- KEMBALI -->

        <button
          type="button"
          @click="router.push('/')"
          class="
            mt-5
            w-full
            h-11
            rounded-xl
            bg-white
            border
            border-[#CBD5E1]
            text-slate-600
            font-bold
            hover:bg-[#F0F9FF]
            hover:text-[#172033]
            transition-all
            active:scale-[0.98]
          "
        >
          ← Kembali
        </button>

      </div>

    </div>

  </div>

</template>


<script setup lang="ts">

import {
  ref,
  nextTick
} from "vue";

import jsPDF from "jspdf";

import QRCode from "qrcode";


const router =
  useRouter();


const { $api } =
  useNuxtApp() as any;


const scanCard =
  ref("");


const inputMember =
  ref<HTMLInputElement | null>(null);


const tiket =
  ref<any>(null);


const printLoading =
  ref(false);

const memberLoading =
  ref(false);


const showNotification =
  ref(false);

const notificationSuccess =
  ref(false);

const notificationTitle =
  ref("");

const notificationMessage =
  ref("");

const memberName =
  ref("");

const memberCode =
  ref("");


const formatTanggal = (
  tanggal: any
) => {

  if (!tanggal) {

    return "-";

  }

  const date =
    new Date(tanggal);

  if (
    isNaN(
      date.getTime()
    )
  ) {

    return String(tanggal);

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
  );

};


const resetNotification = () => {

  showNotification.value =
    false;

  notificationSuccess.value =
    false;

  notificationTitle.value =
    "";

  notificationMessage.value =
    "";

  memberName.value =
    "";

  memberCode.value =
    "";

};


const buatTiket = async () => {

  try {

    const response =
      await $api.post(
        "/tiket"
      );

    tiket.value =
      response.data?.data;

    return tiket.value;

  } catch (error: any) {

    console.error(
      "Gagal membuat tiket:",
      error
    );

    throw error;

  }

};


const printTicket = async () => {

  if (
    printLoading.value
  ) {

    return;

  }

  printLoading.value =
    true;

  try {

    const data =
      await buatTiket();

    if (!data) {

      return;

    }

    const nomorTiket =
      data.kode_tiket;

    // ================================================
    // QR CODE ASLI DARI DATABASE
    // ================================================
    //
    // QR harus berisi data.qr_code dari Laravel,
    // bukan teks struk.
    //

    if (!data.qr_code) {

      throw new Error(
        "QR Code tiket tidak ditemukan dari server."
      );

    }

    const qrImage =
      await QRCode.toDataURL(
        String(data.qr_code).trim(),
        {
          margin: 1,
          width: 300
        }
      );

    const pdf =
      new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [80, 145]
      });

    pdf.setFont(
      "helvetica",
      "bold"
    );

    pdf.setFontSize(
      12
    );

    pdf.text(
      "PARKIR PLAZA ANDALAS",
      40,
      10,
      {
        align: "center"
      }
    );

    pdf.setFontSize(
      9
    );

    pdf.text(
      "TIKET PARKIR",
      40,
      16,
      {
        align: "center"
      }
    );

    pdf.setFontSize(
      10
    );

    pdf.text(
      "NON-MEMBER",
      40,
      24,
      {
        align: "center"
      }
    );

    pdf.addImage(
      qrImage,
      "PNG",
      25,
      29,
      30,
      30
    );

    pdf.setFontSize(
      16
    );

    pdf.text(
      nomorTiket,
      40,
      68,
      {
        align: "center"
      }
    );

    pdf.setFont(
      "helvetica",
      "normal"
    );

    pdf.setFontSize(
      8
    );

    pdf.text(
      "Jenis Pengguna : Non-Member",
      7,
      78
    );

    pdf.text(
      `Waktu Masuk : ${formatTanggal(data.waktu_masuk)}`,
      7,
      85
    );

    pdf.text(
      "Status : MASUK",
      7,
      92
    );

    pdf.text(
      "Kendaraan ditentukan saat keluar.",
      7,
      99
    );

    pdf.setFont(
      "helvetica",
      "bold"
    );

    pdf.text(
      "TARIF PARKIR",
      40,
      107,
      {
        align: "center"
      }
    );

    pdf.setFont(
      "helvetica",
      "normal"
    );

    pdf.text(
      "Motor : Rp2.000 / jam",
      7,
      115
    );

    pdf.text(
      "Mobil : Rp5.000 / jam",
      7,
      122
    );

    pdf.setFontSize(
      7
    );

    pdf.text(
      "Simpan tiket ini dengan baik.",
      40,
      130,
      {
        align: "center"
      }
    );

    pdf.text(
      "Tiket digunakan saat kendaraan keluar.",
      40,
      135,
      {
        align: "center"
      }
    );

    pdf.text(
      "Terima kasih.",
      40,
      140,
      {
        align: "center"
      }
    );

    pdf.save(
      `Tiket-Parkir-${nomorTiket}.pdf`
    );

  } catch (error: any) {

    console.error(
      "Error print tiket:",
      error
    );

    alert(
      error?.response?.data?.message ||
      error?.message ||
      "Gagal membuat tiket."
    );

  } finally {

    printLoading.value =
      false;

  }

};


const openGate = async () => {

  const token =
    scanCard.value.trim();

  if (!token) {

    showNotification.value =
      true;

    notificationSuccess.value =
      false;

    notificationTitle.value =
      "Data Member Kosong";

    notificationMessage.value =
      "Silakan scan barcode member atau masukkan kode member.";

    await nextTick();

    inputMember.value?.focus();

    return;

  }

  if (
    memberLoading.value
  ) {

    return;

  }

  resetNotification();

  memberLoading.value =
    true;

  try {

    const response =
      await $api.post(
        "/member-gate/masuk",
        {
          token: token
        }
      );

    console.log(
      "RESPON MEMBER MASUK:",
      response.data
    );

    if (
      response.data?.success === true
    ) {

      const member =
        response.data?.member ||
        {};

      const tiketMember =
        response.data?.data ||
        null;

      memberName.value =
        member.nama_member ||
        "Member";

      memberCode.value =
        member.kode_member ||
        token;

      tiket.value =
        tiketMember;

      console.log(
        "TIKET MEMBER:",
        tiketMember
      );

      notificationTitle.value =
        "Member Valid";

      notificationMessage.value =
        "Member berhasil masuk ke area parkir.";

      notificationSuccess.value =
        true;

      showNotification.value =
        true;

      scanCard.value =
        "";

      await nextTick();

      inputMember.value?.focus();

    } else {

      notificationTitle.value =
        "Member Tidak Dapat Masuk";

      notificationMessage.value =
        response.data?.message ||
        "Member tidak dapat diproses.";

      notificationSuccess.value =
        false;

      showNotification.value =
        true;

    }

  } catch (error: any) {

    console.error(
      "Error member masuk:",
      error
    );

    notificationTitle.value =
      "Member Tidak Dapat Masuk";

    notificationMessage.value =
      error?.response?.data?.message ||
      error?.message ||
      "QR atau kode member tidak ditemukan.";

    notificationSuccess.value =
      false;

    showNotification.value =
      true;

    scanCard.value =
      "";

    await nextTick();

    inputMember.value?.focus();

  } finally {

    memberLoading.value =
      false;

  }

};

</script>


<style scoped>

.fade-enter-active,
.fade-leave-active {

  transition:
    opacity 0.25s ease,
    transform 0.25s ease;

}

.fade-enter-from,
.fade-leave-to {

  opacity: 0;

  transform:
    translateY(-8px);

}

</style>