<template>
  <div class="min-h-screen bg-slate-100 flex items-center justify-center p-5">

    <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">

      <!-- JUDUL -->
      <h1 class="text-xl font-bold mb-6 text-center text-gray-800">
        Pembayaran Member
      </h1>


      <!-- INFORMASI MEMBER -->
      <div class="bg-slate-50 rounded-xl p-4 mb-6 space-y-3">

        <div>
          <p class="text-xs text-gray-500">
            Kode Member
          </p>

          <p class="font-bold text-gray-800">
            {{ form.kode_member || '-' }}
          </p>
        </div>


        <div>
          <p class="text-xs text-gray-500">
            Nama Member
          </p>

          <p class="font-bold text-gray-800">
            {{ form.nama_member || '-' }}
          </p>
        </div>


        <div>
          <p class="text-xs text-gray-500">
            Perusahaan
          </p>

          <p class="font-bold text-gray-800">
            {{ form.nama_perusahaan || '-' }}
          </p>
        </div>


        <div>
          <p class="text-xs text-gray-500">
            Tagihan Bulanan
          </p>

          <p class="font-bold text-blue-600 text-base">
            Rp {{ formatRupiah(form.total_harga) }}
          </p>
        </div>


        <div>
          <p class="text-xs text-gray-500">
            Pembayaran Saat Ini
          </p>

          <p class="font-bold text-base text-gray-800">
            Rp {{ formatRupiah(form.jumlah_bayar) }}
          </p>
        </div>


        <div>
          <p class="text-xs text-gray-500 mb-1">
            Status
          </p>

          <span
            class="inline-block px-3 py-1 rounded-full text-xs font-bold"
            :class="
              form.status === 'lunas'
                ? 'bg-green-100 text-green-700'
                : 'bg-red-100 text-red-700'
            "
          >
            {{ form.status || 'belum lunas' }}
          </span>
        </div>

      </div>


      <!-- INPUT PEMBAYARAN -->
      <div class="mb-4">

        <label
          class="block text-xs font-semibold text-gray-700 mb-2"
        >
          Masukkan Pembayaran
        </label>


        <input
          v-model.number="form.jumlah_bayar"
          type="number"
          min="0"
          :max="form.total_harga"
          class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm"
          placeholder="0"
        />


        <p class="text-xs text-gray-400 mt-1">
          Maksimal pembayaran:
          Rp {{ formatRupiah(form.total_harga) }}
        </p>

      </div>


      <!-- BUTTON -->
      <div class="space-y-2 pt-2">

        <button
          @click="updatePembayaran"
          :disabled="loading"
          class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white w-full py-3 rounded-xl font-bold transition text-sm"
        >
          {{ loading ? 'Menyimpan...' : 'Simpan Pembayaran' }}
        </button>


        <button
          @click="router.push('/petugas/member/select')"
          class="bg-gray-500 hover:bg-gray-600 text-white w-full py-3 rounded-xl font-bold transition text-sm"
        >
          Kembali
        </button>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

// =========================================================
// API
// =========================================================

const { $api } = useNuxtApp();

const router = useRouter();

const route = useRoute();


// =========================================================
// LOADING
// =========================================================

const loading = ref(false);


// =========================================================
// FORM
// =========================================================

const form = reactive<any>({

  id: null,

  kode_member: "",

  nama_member: "",

  nama_perusahaan: "",

  total_harga: 0,

  jumlah_bayar: 0,

  kembalian: 0,

  status: "",

  tanggal_bayar: null,

  tanggal_mulai: null,

  tanggal_expired: null,

  tanggal_reset: null

});


// =========================================================
// AMBIL DATA MEMBER
// =========================================================

const getData = async () => {

  if (!route.params.id) {

    alert("ID Member tidak ditemukan di URL!");

    return;
  }


  try {

    const res = await $api.get(
      `/member/${route.params.id}`
    );


    if (!res.data.status) {

      alert(
        res.data.message ||
        "Data member tidak ditemukan"
      );

      router.push(
        "/petugas/member/select"
      );

      return;
    }


    Object.assign(
      form,
      res.data.data
    );

  } catch (error: any) {

    console.error(
      "Gagal mengambil data member:",
      error
    );


    alert(
      error?.response?.data?.message ||
      "Gagal mengambil data member"
    );
  }
};


// =========================================================
// UPDATE PEMBAYARAN
// =========================================================

const updatePembayaran = async () => {

  const jumlahBayar =
    Number(form.jumlah_bayar || 0);


  const harga =
    Number(form.total_harga || 0);


  // Cek pembayaran kurang dari 0
  if (jumlahBayar < 0) {

    alert(
      "Pembayaran tidak boleh kurang dari 0"
    );

    return;
  }


  // Cek pembayaran lebih dari harga
  if (jumlahBayar > harga) {

    alert(
      "Pembayaran tidak boleh lebih dari Rp " +
      formatRupiah(harga)
    );

    return;
  }


  try {

    loading.value = true;


    // =====================================================
    // INI YANG DIPERBAIKI
    // Route backend:
    // PUT /api/member/{id}
    // =====================================================

    const res = await $api.put(

      `/member/${route.params.id}`,

      {

        nama_member:
          form.nama_member,

        nama_perusahaan:
          form.nama_perusahaan,

        uang_bayar:
          jumlahBayar

      }

    );


    // Cek response
    if (!res.data.status) {

      alert(
        res.data.message ||
        "Pembayaran gagal"
      );

      return;
    }


    // Berhasil
    alert(
      res.data.message ||
      "Pembayaran berhasil diperbarui"
    );


    // Kembali ke halaman select
    router.push(
      "/petugas/member/select"
    );


  } catch (error: any) {

    console.error(
      "Gagal update pembayaran:",
      error
    );


    alert(
      error?.response?.data?.message ||
      "Gagal memperbarui pembayaran"
    );


  } finally {

    loading.value = false;

  }

};


// =========================================================
// FORMAT RUPIAH
// =========================================================

const formatRupiah = (angka: any) => {

  return new Intl.NumberFormat(
    "id-ID"
  ).format(
    Number(angka || 0)
  );

};


// =========================================================
// JALANKAN SAAT HALAMAN DIBUKA
// =========================================================

onMounted(() => {

  getData();

});

</script>