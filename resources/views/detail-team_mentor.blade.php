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
            <!-- Judul Projek -->
        <h1 class="text-white text-3xl font-semibold mb-10">
            {{ $projek->nama }}
        </h1>

        <!-- Card Wrapper -->
        <div class="grid grid-cols-2 gap-8 max-w-6xl">
            
        @forelse ($projek->anggota as $member)
        <div class="bg-white rounded-2xl p-6">
            <h2 class="text-pink-400 text-2xl font-semibold">
                {{ $member->user->name ?? 'User Tidak Ditemukan' }} </h2>
            <p class="text-pink-400 text-sm mb-6">{{ $member->role }}</p>

            <div class="grid grid-cols-4 text-sm text-pink-400 font-semibold mb-3">
                <span>Task</span>
                <span class="text-center">✔</span>
                <span>Status</span>
                <span>URL</span>
            </div>

            <div class="space-y-4">
                @php
                    $memberTasks = $projek->tasks->where('member_id', $member->id);
                @endphp

                @forelse ($memberTasks as $task)
                    <div class="grid grid-cols-4 items-center">
                        <span class="text-pink-400">{{ $task->nama }}</span>
                        <div class="flex justify-center">
                <input type="checkbox" 
                    {{ in_array($task->submission->status ?? '', ['submitted', 'approved']) ? 'checked' : '' }} 
                    class="w-5 h-5 text-green-500 rounded cursor-not-allowed transition-all duration-300" 
                    disabled>
            </div>
            <div>
             <form action="{{ route('mentor.task.updateStatus', $task->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" onchange="this.form.submit()" 
                    class="text-[10px] font-bold px-2 py-1 rounded-md border-none focus:ring-2 focus:ring-pink-300 cursor-pointer
                    @php
                        $status = $task->submission->status ?? 'submitted';
                        if($status == 'approved') echo 'bg-green-100 text-green-600';
                        elseif($status == 'revisi') echo 'bg-red-100 text-red-600';
                        else echo 'bg-yellow-100 text-yellow-600';
                    @endphp">
                    
                    <option value="submitted" {{ ($task->submission->status ?? '') == 'submitted' ? 'selected' : '' }}>PENDING</option>
                    <option value="approved" {{ ($task->submission->status ?? '') == 'approved' ? 'selected' : '' }}>APPROVE</option>
                    <option value="revisi" {{ ($task->submission->status ?? '') == 'revisi' ? 'selected' : '' }}>REVISI</option>
                </select>
            </form>
            </div>
            <a href="{{ $task->url }}" class="text-blue-500 text-xs truncate">Link</a>
            </div>
            @empty
                <div class="text-gray-400 text-sm">Belum ada task ditugaskan.</div>
            @endforelse
            </div>
        </div>
    @empty
        <p class="text-white">Belum ada anggota. Silakan klik "Atur Role".</p>
    @endforelse

            

        <!-- BUTTON -->
        <div class="flex gap-4 mt-10">
            <button class="bg-pink-400 text-white px-6 py-2 rounded-full hover:opacity-90">
                <a href="{{ route('mentor.projek.task.create', $projek->id) }}">
                    Tambah Task
                </a>
            </button>
            <button class="bg-pink-400 text-white px-6 py-2 rounded-full hover:opacity-90">
                <a href="{{ route('mentor.team.role.create', $projek->id) }}">
                    Atur Role
                </a>
            </button>
        </div>
    </div>

    
</body>
</html>
