<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
          <a href="/magang/password" class="block py-2 px-4 rounded hover:bg-white/10">Pengaturan Akun</a>
        <a href="/magang/pengumuman" class="block py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
        <a href="/magang/task" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
        <a href="/magang/team/projek" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Projek</a>
        <a href="/logout" class="absolute bottom-0 size-16 block py-2 px-4 rounded hover:bg-white/10">
          Keluar
        </a>
      </nav>
    </div>

    <!-- Main Content -->
    

  <div class="flex-1 flex justify-center items-center p-10">
    <form method="POST" action="{{ route('magang.password.update') }}" class="bg-white w-full max-w-md rounded-2xl p-8 shadow-sm">
        @csrf
        @method('PATCH')

        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-[#1c7cab]">Ganti Password</h1>
            <p class="text-gray-400 text-sm">Pastikan password baru Anda kuat dan mudah diingat</p>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Alert Error --}}
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-pink-400 mb-1">Password Sekarang</label>
                <input type="password" name="current_password" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition">
            </div>

            <hr class="border-gray-100">

            <div>
                <label class="block text-sm font-medium text-pink-400 mb-1">Password Baru</label>
                <input type="password" name="new_password" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition">
                <p class="text-[10px] text-gray-400 mt-1">*Minimal 6 karakter</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-pink-400 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" required
                    class="w-full border border-gray-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-300 focus:border-pink-300 outline-none transition">
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3">
            <button type="submit" 
                class="w-full bg-pink-400 text-white font-semibold py-2 rounded-full hover:bg-pink-500 transition shadow-md shadow-pink-200">
                Simpan Password Baru
            </button>
            <a href="/magangdash" class="text-center text-gray-400 text-sm hover:text-[#1c7cab] transition font-medium">Batal</a>
        </div>
    </form>
</div>

  <script>
    // Jika ingin menambah script JS, pastikan tidak ada syntax error
  </script>
</body>
</html>
