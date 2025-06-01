<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - WinnieCode</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
    <body class="bg-white">
    <div x-data="{ open: false }" class="flex min-h-screen">

      <!-- Sidebar -->
      <div :class="open ? 'bg-[#1578AE] w-64 ' : 'bg-white w-16 '" class=" text-white transition-all duration-300 flex flex-col items-center"> 
        <!-- Tombol Toggle -->
        <div class="w-full flex justify-end p-4">
          <button @click="open = !open" class="focus:outline-none">
            <img 
                x-show="!open" 
                src="img/Sidebar.png" 
                alt="Sidebar Close Icon" 
                class="h-6 w-6 mx-auto"
              />

            <!-- Ikon saat sidebar BUKA -->
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" 
                class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
        </div>

        <!-- Menu -->
        <nav x-show="open" x-transition class="flex flex-col w-full px-4 space-y-2">
          <img src="img/logo.png" alt="logo" class="h-8 w-8 absolute top-4 left-6"/>
          <a href="/mentordash" class="block py-2 px-4 rounded hover:bg-white/10">Dashboard</a>
          <a href="/maganglist" class="block py-2 px-4 rounded hover:bg-white/10">Daftar Anak Magang</a>
          <a href="/mentor/pengumuman" class="block py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
          <a href="#" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
          <a href="/logout" class="absolute bottom-0 size-16 block py-2 px-4 rounded hover:bg-white/10">
            Keluar
          </a>
        </nav>

      </div>
      
      <!-- Main Content -->
      <div class="flex min-h-screen ">
        <div class=" text-[#1578AE] flex flex-col justify-center px-28">
          <h1 class="text-6xl font-bold mb-4">Mentor Area<br />Ruang Kontrolmu</h1>
          <p class="text-lg">Selalu update dengan kinerja anak magang.<br />Karena setiap langkah mereka, butuh arah yang jelas dari mentornya.</p>
        </div>
      </div>

    </div>
  </body>
</html>
