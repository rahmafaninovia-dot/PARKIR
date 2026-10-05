```vue
<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="text-center">
      <div
        class="w-12 h-12 border-4 border-green-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"
      ></div>

      <h1 class="text-xl font-bold text-gray-700">
        Membuka Transaksi Masuk...
      </h1>

      <p class="text-sm text-gray-500 mt-2">
        Silakan tunggu sebentar.
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">

const router = useRouter()

onMounted(() => {
  router.replace("/user")
})

</script>
```
