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
      <h1 class="text-white text-3xl font-bold mb-6 leading-tight">{{ isset($item) ? 'Edit Tugas' : 'Tambahkan Tugas Baru' }}</h1>

    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-xl border-4 border-[#6DC6FF]">
                
                
                <form 
                    action="{{ isset($item) ? route('task.update', $item->id) : route('task.store') }}" 
                    method="POST" 
                    class="space-y-6"
                >
                    @csrf
                    
                   
                    @if (isset($item))
                        @method('PUT') 
                    @endif
                    

                    <div>
                        <label for="judul" class="block text-gray-700 font-semibold mb-2">Judul Tugas:</label>
                        <input type="text" id="judul" name="judul" 
                               value="{{ old('judul', $item->judul ?? '') }}"
                               required
                               class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi:</label>
                        <textarea id="deskripsi" name="deskripsi" rows="6" required
                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400 resize-y">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
                        @error('deskripsi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="tenggat" class="block text-gray-700 font-semibold mb-2">Tenggat Waktu:</label>
                        <input type="date" id="tenggat" name="tenggat" required
                            
                            value="{{ old('tenggat', isset($item) ? \Carbon\Carbon::parse($item->tenggat)->format('Y-m-d') : '') }}"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                        @error('tenggat') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="kelas" class="block text-gray-700 font-semibold mb-2">Pilih Divisi:</label>
                        <select id="kelas" name="kelas_id" required
                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-400">
                            
                           
                            @if (!isset($item) || !old('kelas_id'))
                                <option value="" disabled selected>Pilih Divisi</option>
                            @endif
                            
                            
                            @foreach ($kelas as $kls)
                                <option 
                                    value="{{ $kls->id }}" 
                                    {{ (isset($item) && $kls->id == $item->kelas_id) ? 'selected' : (old('kelas_id') == $kls->id ? 'selected' : '') }}>
                                    {{ $kls->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-pink-400 hover:bg-pink-500 text-white font-semibold py-2 px-8 rounded-full shadow-md transition duration-200">
                            {{ isset($item) ? 'Simpan Perubahan' : 'Simpan' }}
                        </button>
                    </div>
                </form>

            </div>

        


        
  </div>
</body>
</html>
