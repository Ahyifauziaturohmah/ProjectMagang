<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambahkan Anak Magang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-[#1B7BA6] min-h-screen flex">

  <div x-data="{ open: false }" class="flex w-full">

    <!-- Sidebar -->
    <aside :class="open ? 'w-64' : 'w-16'" class="bg-[#1578AE] transition-all duration-300 flex flex-col items-center relative text-white py-4">
      <!-- Toggle Button -->
      <button @click="open = !open" class="focus:outline-none">
        <img x-show="!open" x-cloak src="{{ asset('img/Sidebar(wht).png') }}" alt="Open Sidebar" class="h-6 w-6" />
        <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg"
             class="h-6 w-6" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      <!-- Logo -->
      {{-- <img src="img/logo.png" alt="Logo" class="h-8 w-8 mb-6" x-show="open" x-cloak /> --}}

      <!-- Menu -->
      <nav x-show="open" x-cloak class="flex flex-col space-y-2 w-full px-4 text-sm">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-8 absolute top-4 left-6"/>
        <a href="/mentordash" class="py-2 px-4 rounded hover:bg-white/10">Dashboard</a>
        <a href="/maganglist" class="py-2 px-4 rounded hover:bg-white/10">Daftar Anak Magang</a>
        <a href="/mentor/pengumuman" class="py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
        <a href="/mentor/task" class="py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
        <a href="/logout" class="mt-auto py-2 px-4 rounded hover:bg-white/10">Keluar</a>
      </nav>
    </aside>

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
