<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Anak Magang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-[#1B7BA6] min-h-screen flex flex-col">

  <div x-data="{ open: false }" class="flex flex-1">

    <!-- Sidebar -->
    <div :class="open ? 'bg-white w-64' : 'bg-[#1578AE] w-16'" class="text-pink-500 transition-all duration-300 flex flex-col items-center relative">
      <!-- Tombol Toggle -->
      <div class="w-full flex justify-end p-4">
        <button @click="open = !open" class="focus:outline-none">
          <img x-show="!open" src="img/Sidebar(wht).png" alt="Sidebar Close Icon" class="h-6 w-6 mx-auto" />
          <svg x-show="open" xmlns="http://www.w3.org/2000/svg"
               class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24"
               stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7" />
          </svg>
        </button>
      </div>

      <!-- Menu -->
      <nav x-show="open" x-transition class="flex flex-col w-full px-4 space-y-2">
        <img src="img/logo.png" alt="logo" class="h-8 w-8 absolute top-4 left-6" />
        <a href="/mentordash" class="block py-2 px-4 rounded hover:bg-white/10">Dashboard</a>
        <a href="/maganglist" class="block py-2 px-4 rounded hover:bg-white/10">Daftar Anak Magang</a>
        <a href="/mentor/pengumuman" class="block py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
        <a href="/mentor/task" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
        <a href="/logout" class="absolute bottom-0 w-full block py-2 px-4 rounded hover:bg-white/10">Keluar</a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 overflow-auto">
      <h1 class="text-white text-3xl font-bold mb-6 leading-tight">Pengumuman!</h1>

      <!-- Container Scroll -->
      <div class="h-[500px] overflow-y-auto space-y-10 pr-2">
        @foreach ($data as $item)
          <div class="p-4 rounded-lg shadow-md bg-grey">
            <h2 class="text-white text-xl font-semibold mb-2">{{ $item->judul }}</h2>
            <h4 class="text-white font-semibold mb-2">Kelas: {{ $item->kelas->nama_kelas }}</h4>
            <p class="text-white text-sm leading-relaxed">{{ $item->isi }}</p>
          </div>
        @endforeach
      </div>

      <!-- Tombol tambah -->
      <a href="/form/pengumuman" class="fixed bottom-6 right-6 bg-pink-500 text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-pink-600">
        Tambah Pengumuman
      </a>
    </div>

  </div>

  <script>
    // Jika ingin menambah script JS, pastikan tidak ada syntax error
  </script>
</body>
</html>
