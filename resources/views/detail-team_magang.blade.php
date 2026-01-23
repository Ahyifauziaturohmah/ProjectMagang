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

    @if (session('success'))
        <div x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)" 
            x-transition:leave.duration.500ms
            class="fixed top-5 right-5 z-50 p-4 rounded-lg shadow-xl text-white font-semibold flex items-center space-x-2 bg-pink-500 border border-pink-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

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

      <!-- Menu ini di perbaiki-->
      <nav x-show="open" x-transition class="flex flex-col w-full px-4 space-y-2">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-8 absolute top-4 left-6" />
        <a href="/magangdash" class="block py-2 px-4 rounded hover:bg-white/10">Dashboard</a>
          <a href="/magang/password" class="block py-2 px-4 rounded hover:bg-white/10">Pengaturan Akun</a>
        <a href="/magang/pengumuman" class="block py-2 px-4 rounded hover:bg-white/10">Pengumuman</a>
        <a href="/magang/task" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Tugas</a>
        <a href="/magang/team/projek" class="block py-2 px-4 rounded hover:bg-white/10">Lihat Daftar Projek</a>
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
   <div class="grid grid-cols-2 gap-8 max-w-6xl">
    @forelse ($projek->anggota as $member)
        <div class="bg-white rounded-2xl p-6">
            <h2 class="text-pink-400 text-2xl font-semibold">
                {{ $member->user->name ?? 'User Tidak Ditemukan' }} 
            </h2>
            <p class="text-pink-400 text-sm mb-6">{{ $member->role }}</p>

            <div class="grid grid-cols-4 text-sm text-pink-400 font-semibold mb-3 text-center">
                <span class="text-left">Task</span>
                <span>Done?</span>
                <span>Status</span>
                <span>URL</span>
            </div>

            <div class="space-y-4">
                @php
                    $memberTasks = $projek->tasks->where('member_id', $member->id);
                @endphp

                @forelse ($memberTasks as $task)
                    <div class="grid grid-cols-4 items-center text-center">
                        <span class="text-pink-400 text-left truncate">{{ $task->nama }}</span>
                    <div class="flex justify-center">
                @php
                    $currentUserId = auth()->id();
                    $isMyTask = isset($task->member->user_id) && $task->member->user_id == $currentUserId;
                @endphp

                @if($isMyTask)
                    <form action="{{ route('task.quickUpdate', $task->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="revisi">
                        
                        <input type="checkbox" 
                            name="status"
                            value="approved"
                            onchange="this.form.submit()"
                            {{ in_array($task->submission->status ?? '', ['submitted', 'approved']) ? 'checked' : '' }} 
                            class="w-5 h-5 text-green-500 rounded cursor-not-allowed transition-all duration-300">
                    </form>
                @else
                    <input type="checkbox" 
                        {{ in_array($task->submission->status ?? '', ['submitted', 'approved']) ? 'checked' : '' }} 
                        disabled
                        class="w-5 h-5 text-green-500 rounded opacity-50 cursor-not-allowed">
                @endif
            </div>

                        <div>
                            @php
                                $status = $task->submission->status ?? 'pending';
                                $bgClass = match($status) {
                                    'approved' => 'bg-green-100 text-green-600',
                                    'revisi'   => 'bg-red-100 text-red-600',
                                    default    => 'bg-yellow-100 text-yellow-600',
                                };
                            @endphp
                            <span class="text-[10px] font-bold px-2 py-1 rounded-md {{ $bgClass }} uppercase">
                                {{ $status == 'submitted' ? 'pending' : $status }}
                            </span>
                        </div>

                        <div class="col-span-1">
                        @php
                            $currentUserId = auth()->id();
                            
                            $isMyTask = isset($task->member->user_id) && $task->member->user_id == $currentUserId;
                        @endphp

                        @if($isMyTask)
                            <form action="{{ route('magang.projek-task.updateUrl', $task->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="url" 
                                    name="url" 
                                    value="{{ $task->submission->url ?? '' }}" 
                                    placeholder="Input link..."
                                    {{ ($task->submission->status ?? '') == 'approved' ? 'disabled' : '' }}
                                    class="w-full text-xs border-gray-200 rounded-md focus:ring-pink-300 focus:border-pink-300 p-1 {{ ($task->submission->status ?? '') == 'approved' ? 'bg-gray-100' : '' }}"
                                    onchange="this.form.submit()">
                            </form>
                        @else
                            @if($task->submission->url ?? false)
                                <a href="{{ $task->submission->url }}" target="_blank" class="text-blue-500 text-[10px] underline truncate block">
                                    Buka Link
                                </a>
                            @else
                                <span class="text-gray-400 text-[10px] italic">No link</span>
                            @endif
                        @endif
                    </div>
                                        </div>
                                    @empty
                                        <div class="text-gray-400 text-sm">Belum ada task ditugaskan.</div>
                                    @endforelse
                                </div>
                            </div>
                        @empty
                            <p class="text-white">Belum ada anggota. Silakan klik "Atur Role".</p>
                        @endforelse       
    </div>

    
</body>
</html>
