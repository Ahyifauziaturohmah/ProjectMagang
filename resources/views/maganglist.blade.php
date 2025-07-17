<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Winnicode</title>
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
          <img x-show="!open" src="{{ asset('img/Sidebar(wht).png') }}" alt="Sidebar Close Icon" class="h-6 w-6 mx-auto" />
          <!-- Ikon saat sidebar BUKA -->
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
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-8 absolute top-4 left-6" />
        <a href="/mentordash" class="block py-2 px-4 rounded hover:bg-white/10">Dashboard</a>
        <a href="/maganglist" class="block py-2 px-4 rounded hover:bg-white/10">Daftar Anak Magang</a>
        <a href="/mentor/pengumuman" class="block py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
        <a href="/mentor/task" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
        <a href="/logout" class="absolute bottom-0 w-full block py-2 px-4 rounded hover:bg-white/10">
          Keluar
        </a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 overflow-auto">
      <h1 class="text-white text-3xl font-bold mb-6 leading-tight">Daftar<br>Anak Magang</h1>

      <div class="bg-white rounded-lg shadow-lg overflow-x-auto border-4 border-[#6DC6FF]">
        <table class="min-w-full text-left border-collapse">
          <thead class="bg-white">
            <tr>
              <th class="px-6 py-3 font-semibold border border-gray-200">Nama</th>
              <th class="px-6 py-3 font-semibold border border-gray-200">Email</th>
              <th class="px-6 py-3 font-semibold border border-gray-200">Kelas</th>
            </tr>
          </thead>
          <tbody>
            <!-- Ulangi baris ini sesuai jumlah data -->
            @foreach ($data as $item)
            <tr class="bg-white">
              <td class="px-6 py-3 border border-gray-200">{{ $item->name }}</td>
              <td class="px-6 py-3 border border-gray-200">{{ $item->email }}</td>
              <td class="px-6 py-3 border border-gray-200">{{  $item->divisi?->kelas?->nama_kelas ?? '-'}}</td>
            </tr>  
            @endforeach
            
            <!-- Tambahkan baris lain sesuai data -->
          </tbody>
        </table>
      </div>

      <div class="flex justify-end mt-6">
        <a href="/formmaganglist"
        class="bg-pink-400 hover:bg-pink-500 text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-200">
          Tambah Peserta</a>
        
      </div>
      <div class="flex justify-end mt-6">
        <a href="/form/divisi"
        class="bg-pink-400 hover:bg-pink-500 text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-200">
          Tambah Divisi</a>
        
      </div>
    </div>
  </div>

  

</body>
</html>
