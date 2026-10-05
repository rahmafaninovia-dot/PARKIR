<template>
  <div class="page">

    <div class="header">

      <div>
        <p class="label">
          INFORMASI TIKET
        </p>

        <h1>
          Tiket Parkir
        </h1>

        <p class="subtitle">
          Lihat informasi tiket parkir kendaraan.
        </p>
      </div>

      <button @click="$router.back()">
        ← Kembali
      </button>

    </div>


    <!-- ========================= -->
    <!-- TIKET DITEMUKAN -->
    <!-- ========================= -->

    <div
      v-if="tiket"
      class="ticket-card"
    >

      <div class="ticket-top">

        <div>

          <span>
            TIKET PARKIR
          </span>

          <h2>
            #{{ tiket.id }}
          </h2>

        </div>


        <div class="status">
          {{ tiket.status }}
        </div>

      </div>


      <div class="divider"></div>


      <div class="info">

        <div>

          <span>
            Nomor Kendaraan
          </span>

          <strong>
            {{ tiket.no_kendaraan }}
          </strong>

        </div>


        <div>

          <span>
            Jenis Kendaraan
          </span>

          <strong>
            {{ tiket.jenis_kendaraan }}
          </strong>

        </div>


        <div>

          <span>
            Jenis Pengguna
          </span>

          <strong>
            {{ tiket.jenis_pengguna }}
          </strong>

        </div>


        <div>

          <span>
            Waktu Masuk
          </span>

          <strong>
            {{ formatDate(tiket.waktu_masuk) }}
          </strong>

        </div>

      </div>


      <!-- ========================= -->
      <!-- QR CODE -->
      <!-- ========================= -->

      <div class="qr">

        <div class="qr-placeholder">
          QR
        </div>

        <p>
          Scan tiket ini saat keluar
        </p>

      </div>


      <!-- ========================= -->
      <!-- CETAK -->
      <!-- ========================= -->

      <button
        class="print"
        @click="cetakTiket"
      >
        🖨 Cetak Tiket
      </button>

    </div>


    <!-- ========================= -->
    <!-- TIKET TIDAK DITEMUKAN -->
    <!-- ========================= -->

    <div
      v-else
      class="empty"
    >

      <h2>
        Tiket Tidak Ditemukan
      </h2>

      <p>
        Belum ada tiket parkir aktif.
      </p>

      <button
        @click="$router.push('/petugas/member/masuk')"
      >
        Kendaraan Masuk
      </button>

    </div>

  </div>
</template>


<script setup>

import {
  ref,
  onMounted
} from 'vue'


// ========================================
// DATA TIKET
// ========================================

const tiket = ref(null)


// ========================================
// AMBIL DATA LOCAL STORAGE
// ========================================

onMounted(() => {

  const data =
    localStorage.getItem('tiket_aktif')


  if (!data) {

    tiket.value = null

    return

  }


  try {

    tiket.value =
      JSON.parse(data)

  } catch (error) {

    console.error(
      'Gagal membaca tiket:',
      error
    )

    tiket.value = null

  }

})


// ========================================
// FORMAT TANGGAL
// ========================================

const formatDate = (date) => {

  if (!date) {
    return '-'
  }


  return new Date(date).toLocaleString(
    'id-ID',
    {
      day: '2-digit',
      month: 'long',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    }
  )

}


// ========================================
// CETAK TIKET
// ========================================

const cetakTiket = () => {

  window.print()

}

</script>


<style scoped>

.page {

  min-height: 100vh;

  background: #f6f8fb;

  padding: 40px;

  font-family: Arial, sans-serif;

}


.header {

  max-width: 800px;

  margin: auto;

  display: flex;

  justify-content: space-between;

  align-items: center;

}


.label {

  color: #f59e0b;

  font-size: 13px;

  font-weight: bold;

}


h1 {

  margin: 5px 0;

  color: #172033;

}


.subtitle {

  color: #64748b;

}


.header button,
.empty button {

  border: none;

  padding: 12px 18px;

  border-radius: 10px;

  background: #e5e7eb;

  cursor: pointer;

}


.ticket-card {

  max-width: 800px;

  margin: 35px auto;

  padding: 35px;

  background: white;

  border-radius: 20px;

  box-shadow:
    0 10px 35px rgba(0, 0, 0, .07);

}


.ticket-top {

  display: flex;

  justify-content: space-between;

  align-items: center;

}


.ticket-top span {

  color: #64748b;

  font-size: 13px;

}


.ticket-top h2 {

  margin: 8px 0 0;

  font-size: 30px;

  color: #172033;

}


.status {

  padding: 8px 16px;

  border-radius: 20px;

  background: #dcfce7;

  color: #15803d;

  font-size: 12px;

  font-weight: bold;

}


.divider {

  height: 1px;

  background: #e5e7eb;

  margin: 30px 0;

}


.info {

  display: grid;

  grid-template-columns: 1fr 1fr;

  gap: 25px;

}


.info div {

  display: flex;

  flex-direction: column;

  gap: 7px;

}


.info span {

  color: #64748b;

  font-size: 13px;

}


.info strong {

  color: #172033;

  font-size: 17px;

}


.qr {

  text-align: center;

  margin: 35px 0;

  padding-top: 30px;

  border-top:
    1px dashed #cbd5e1;

}


.qr-placeholder {

  width: 150px;

  height: 150px;

  margin: auto;

  display: flex;

  align-items: center;

  justify-content: center;

  border: 5px solid #172033;

  font-size: 35px;

  font-weight: bold;

}


.qr p {

  color: #64748b;

}


.print {

  width: 100%;

  padding: 15px;

  border: none;

  border-radius: 10px;

  background: #f59e0b;

  color: white;

  font-weight: bold;

  cursor: pointer;

}


.empty {

  max-width: 800px;

  margin: 35px auto;

  padding: 50px;

  background: white;

  border-radius: 20px;

  text-align: center;

}


@media print {

  .header,
  .print {

    display: none;

  }


  .page {

    padding: 0;

    background: white;

  }


  .ticket-card {

    box-shadow: none;

  }

}

</style>