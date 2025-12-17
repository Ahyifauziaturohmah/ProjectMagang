<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Monitoring Winnicode</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-[#1B7BA6] min-h-screen flex">

  <div x-data="{ open: false }" class="flex w-full">

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
    <main class="flex-1 p-6 md:p-12 lg:p-20 text-white">
      <h1 class="text-3xl font-bold mb-8 leading-tight">Atur<br>Divisi Anak Magang</h1>

      <!-- Card Form -->
      <div class="bg-white rounded-xl shadow-lg p-8 max-w-xl w-full text-gray-800">
        <form action="{{ url('/form/divisi') }}" method="POST" class="space-y-6">
          @csrf

          <!-- Pilih Anak Magang -->
          <div>
            <label for="user_id" class="block font-medium mb-1">Pilih Anak Magang:</label>
            <select name="user_id" id="user_id" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Pilih Divisi / Kelas -->
          <div>
            <label for="kelas_id" class="block font-medium mb-1">Pilih Divisi:</label>
            <select name="kelas_id" id="kelas_id" required
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
              @foreach($kelas as $kls)
                <option value="{{ $kls->id }}">{{ $kls->nama_kelas }}</option>
              @endforeach
            </select>
          </div>

          <!-- Tombol Simpan -->
          <div class="flex justify-end">
            <button type="submit"
              class="bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-6 rounded-full shadow-lg transition duration-300">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </main>

  </div>
</body>
</html>
