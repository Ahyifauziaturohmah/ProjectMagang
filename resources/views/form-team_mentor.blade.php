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
    <div class="w-full max-w-2xl bg-white rounded-2xl p-8 shadow-lg">
        <h1 class="text-2xl font-semibold mb-8 text-[#1c7cab]">
            {{ isset($projek) ? 'Edit Projek' : 'Tambahkan Projek Baru' }}
        </h1>

        <form method="POST" 
              action="{{ isset($projek) ? url('/mentor/update/team/projek/'.$projek->id) : route('projek.store') }}" 
              class="space-y-6">
            
            @csrf
            @if(isset($projek))
                @method('PUT')
            @endif

            <div>
                <label class="block text-sm font-medium mb-2">Nama Projek:</label>
                <input name="nama"
                    type="text"
                    value="{{ old('nama', $projek->nama ?? '') }}"
                    placeholder="Masukkan judul tugas"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required />
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Deskripsi:</label>
                <textarea name="deskripsi"
                    rows="4"
                    placeholder="Deskripsi tugas"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>{{ old('deskripsi', $projek->deskripsi ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pilih Divisi:</label>
                <select name="kelas_id"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400"
                    required>
                    <option value="">Pilih Divisi</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" 
                            {{ (old('kelas_id', $projek->kelas_id ?? '') == $k->id) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="bg-pink-400 text-white px-8 py-2 rounded-full hover:opacity-90">
                    {{ isset($projek) ? 'Update Projek' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>

    
</body>
</html>
