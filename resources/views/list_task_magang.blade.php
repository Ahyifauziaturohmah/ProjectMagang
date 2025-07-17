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
          <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-8 absolute top-4 left-6"/>
          <a href="/magangdash" class="block py-2 px-4 rounded hover:bg-white/10">Dashboard</a>
          <a href="/magang/pengumuman" class="block py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
          <a href="/magang/task" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
          <a href="/logout" class="absolute bottom-0 size-16 block py-2 px-4 rounded hover:bg-white/10">
            Keluar
          </a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-10 overflow-auto">
      <h1 class="text-white text-3xl font-bold mb-6 leading-tight">Daftar<br>Laporan Magang </h1>
      
 
      <div class="bg-white rounded-lg shadow-lg overflow-x-auto border-4 border-[#6DC6FF]">
        <table class="min-w-full text-left border-collapse">
          <thead class="bg-white">
            <tr>
              <th class="px-6 py-3 font-semibold border border-gray-200">Judul</th>
              <th class="px-6 py-3 font-semibold border border-gray-200">Deskripsi</th>
              <th class="px-6 py-3 font-semibold border border-gray-200">Tenggat</th>
              <th class="px-6 py-3 font-semibold border border-gray-200">Divisi</th>
              <th class="px-6 py-3 font-semibold border border-gray-200">Detail</th>
            </tr>
          </thead>
          <tbody>
            <!-- Ulangi baris ini sesuai jumlah data -->
            @foreach ($data as $item)
            <tr class="bg-white">
              <td class="px-6 py-3 border border-gray-200">{{$item->judul}}</td>
              <td class="px-6 py-3 border border-gray-200">{{$item->deskripsi}}</td>
              <td class="px-6 py-3 border border-gray-200">{{$item->tenggat}}</td>
              <td class="px-6 py-3 border border-gray-200">{{$item->kelas->nama_kelas}}</td>
              <td class="px-6 py-3 border border-gray-200">
                <a href="{{ route('task.submit', $item->id) }} " class="bg-pink-400 text-white px-4 py-1 rounded-full font-semibold text-sm hover:bg-pink-500">
                    Detail
                </a>
              </td>
            </tr>  
            @endforeach
            
          </tbody>
        </table>
      </div>

      
    </div>
  </div>
</body>
</html>
