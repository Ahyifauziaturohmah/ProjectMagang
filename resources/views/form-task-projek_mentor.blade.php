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
      <form method="POST" action="{{ route('mentor.projek.task.store', $projek->id) }}" class="bg-white w-full max-w-4xl rounded-2xl p-8 space-y-8">
        @csrf
    <h1 class="text-2xl font-semibold text-[#1c7cab]">
      Tambah Task Projek <br> {{ $projek->nama }}
    </h1>
    
    <!-- TASK LIST -->
    <div id="task-list" class="space-y-6">

      <!-- TASK ITEM -->
      <div class="border rounded-xl p-5 space-y-4">
        <div class="flex justify-between items-center">
          <h2 class="font-semibold text-pink-400">Task #1</h2>
        </div>

        <!-- Judul -->
        <input
          type="text"
          name="tasks[0][nama]"
          placeholder="Judul Task"
          class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-400"
        />

        

        <!-- Assign Anggota -->
        <select name="tasks[0][member_id]" required class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-50">
          <option value="">Pilih Anggota</option>
          @foreach($projek->anggota as $member)
            <option value="{{ $member->id }}">
                {{ $member->user->name  }} ({{ $member->role }})
            </option>
          @endforeach
        </select>
      </div>

    </div>

    <!-- ACTION -->
    <div class="flex justify-between items-center">
      <button
        type="button"
        onclick="addTask()"
        class="text-pink-500 text-sm hover:underline">
        + Tambah Task
      </button>

      <button
        type="submit"
        class="bg-pink-400 text-white px-8 py-2 rounded-full hover:opacity-90">
        Simpan Semua Task
      </button>
    </div>

  </form>

  <!-- SCRIPT -->
 <script>
    let taskIndex = 1;

    // Kita render opsinya di sini supaya bersih
    const memberOptions = `
        <option value="">Pilih Anggota</option>
        @foreach($projek->anggota as $member)
            <option value="{{ $member->id }}">{{ $member->user->name ?? 'User' }} ({{ $member->role }})</option>
        @endforeach
    `;

    function addTask() {
        const taskList = document.getElementById('task-list');
        const taskItem = document.createElement('div');
        taskItem.className = 'border rounded-xl p-5 space-y-4';

        // Pakai backtick (`) dan pastikan index-nya benar
        taskItem.innerHTML = `
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-pink-400">Task #` + (taskIndex + 1) + `</h2>
                <button type="button" onclick="this.closest('div.border').remove()" class="text-red-400 text-sm">Hapus</button>
            </div>
            <input type="text" name="tasks[` + taskIndex + `][nama]" placeholder="Judul Task" required
                class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-400" />
            <select name="tasks[` + taskIndex + `][member_id]" required class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-50">
                ` + memberOptions + `
            </select>
        `;
        
        taskList.appendChild(taskItem);
        taskIndex++;
    }
</script>
    
    
    </div>

    
</body>
</html>
