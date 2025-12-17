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
      <form method="POST" action={{route('mentor.team.role.store', ['id'=> $projek->id ])}} class="bg-white w-full max-w-3xl rounded-2xl p-8 space-y-8">
        @csrf
        <h1 class="text-2xl font-semibold text-[#1c7cab]">
          Atur Role Anggota
        </h1>

    <!-- ROLE LIST -->
    <div id="role-list" class="space-y-4">

      <!-- ITEM -->
      <div class="grid grid-cols-5 gap-4 items-center border rounded-xl p-4">
        <span class="col-span-1 text-pink-400 font-semibold">
          Anggota
        </span>

        <select
          name="user_id"
          class="col-span-2 border rounded-lg px-3 py-2 text-sm bg-gray-50">
          <option value="">Pilih Anggota</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
<input type="hidden" name="projek_id" value="{{ $projek->id }}">

        <select
          name="role"
          class="col-span-2 border rounded-lg px-3 py-2 text-sm bg-gray-50">
          <option value="">-- Pilih Role --</option>
        <option value="leader">Leader</option>
        <option value="UI/UX">UI/UX Designer</option>
        <option value="front-end">Front-End Developer</option>
        <option value="back-end">Back-End Developer</option>
        <option value="fullstack">Fullstack Developer</option>
        </select>
      </div>

    </div>
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <!-- ACTION -->
    <div class="flex justify-between items-center pt-4">
      <button
        type="button"
        onclick="addRole()"
        class="text-pink-500 text-sm hover:underline">
        + Tambah Anggota
      </button>

      <button
        type="submit"
        class="bg-pink-400 text-white px-8 py-2 rounded-full hover:opacity-90">
        Simpan Role
      </button>
    </div>

  </form>
 </div>
  <!-- SCRIPT -->
  <script>
    // Ambil data users dari Laravel
    const dbUsers = @json($users);
    let roleIndex = 1;

    function addRole() {
        const roleList = document.getElementById('role-list');

        const item = document.createElement('div');
        item.className = 'grid grid-cols-5 gap-4 items-center border rounded-xl p-4';

        // Buat daftar option user secara dinamis dari database
        let userOptions = '<option value="">Pilih Anggota</option>';
        dbUsers.forEach(user => {
            userOptions += `<option value="${user.id}">${user.name}</option>`;
        });

        item.innerHTML = `
            <span class="col-span-1 text-pink-400 font-semibold">
                Anggota
            </span>

            <select
                name="members[${roleIndex}][user_id]"
                class="col-span-2 border rounded-lg px-3 py-2 text-sm bg-gray-50">
                ${userOptions}
            </select>

            <select
                name="members[${roleIndex}][role]"
                class="col-span-2 border rounded-lg px-3 py-2 text-sm bg-gray-50">
                <option value="">-- Pilih Role --</option>
                <option value="leader">Leader</option>
                <option value="UI/UX">UI/UX Designer</option>
                <option value="front-end">Front-End Developer</option>
                <option value="back-end">Back-End Developer</option>
                <option value="fullstack">Fullstack Developer</option>
            </select>
            
            <button type="button" onclick="this.parentElement.remove()" class="text-red-400 text-xs text-right col-span-5 hover:underline">
                - Hapus Anggota
            </button>
        `;

        roleList.appendChild(item);
        roleIndex++;
    }
</script>
   

    
</body>
</html>
