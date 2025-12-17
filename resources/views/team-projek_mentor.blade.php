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
        <a href="/mentor/team/projek" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Projek</a>
        <a href="/logout" class="absolute bottom-0 w-full block py-2 px-4 rounded hover:bg-white/10">
          Keluar
        </a>
      </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-20 overflow-auto">
      <div class="p-10">
        <!-- Title -->
        <h1 class="text-white text-3xl font-semibold mb-10 leading-snug">
        Daftar<br>Team Projek
        </h1>

        <!-- Grid Card -->
        <div class="grid grid-cols-2 gap-6 max-w-4xl">
        
        <!-- Card -->
        @forelse ($projek as $item)
        <div class="bg-white rounded-2xl p-6 relative h-36">
            <h2 class="text-pink-400 text-2xl font-semibold">
             {{ $item->nama }}
            </h2>
            @if($item->deskripsi)
                <p class="text-gray-500 text-sm mt-1 line-clamp-2">
                    {{ $item->deskripsi }}
                </p>
            @endif
            <button class="absolute bottom-5 right-5 bg-pink-400 text-white px-5 py-1.5 rounded-full text-sm hover:opacity-90">
                <a href="/mentor/detail/team/projek/{{ $item->id }}">
                    Detail
                </a>
            </button>
        </div>
         @empty
        <p class="text-white col-span-2">
            Belum ada projek
        </p>
        @endforelse
                </div>

        <!-- Button Tambah -->
        <button class="mt-10 bg-pink-400 text-white px-8 py-2.5 rounded-full hover:opacity-90">
        <a href="/mentor/form/team/projek">
            Tambah</a>
        </button>
    </div>

    
</body>
</html>
