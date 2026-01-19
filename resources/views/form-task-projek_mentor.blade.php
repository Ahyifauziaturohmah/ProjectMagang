<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Winnicode - {{ isset($task) ? 'Edit Task' : 'Tambah Task' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-[#1B7BA6] min-h-screen flex flex-col">

  <div x-data="{ open: false }" class="flex flex-1">

    <div :class="open ? 'bg-white w-64' : 'bg-[#1578AE] w-16'" class="text-pink-500 transition-all duration-300 flex flex-col items-center relative">
      <div class="w-full flex justify-end p-4">
        <button @click="open = !open" class="focus:outline-none">
          <img x-show="!open" src="{{ asset('img/Sidebar(wht).png') }}" alt="Sidebar Close Icon" class="h-6 w-6 mx-auto" />
          <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
      </div>
      <nav x-show="open" x-transition class="flex flex-col w-full px-4 space-y-2">
        <img src="{{ asset('img/logo.png') }}" alt="logo" class="h-8 w-8 absolute top-4 left-6" />
        <a href="/mentordash" class="block py-2 px-4 rounded hover:bg-white/10 text-pink-500">Dashboard</a>
        <a href="/maganglist" class="block py-2 px-4 rounded hover:bg-white/10 text-pink-500">Daftar Anak Magang</a>
        <a href="/logout" class="absolute bottom-0 w-full block py-2 px-4 rounded hover:bg-white/10 text-pink-500">Keluar</a>
      </nav>
    </div>

    <div class="flex-1 p-20 overflow-auto ">
      
      @php
        $isEdit = isset($task);
        $actionUrl = $isEdit ? route('mentor.task.update', $task->id) : route('mentor.projek.task.store', $projek->id);
      @endphp

      <form method="POST" action="{{ $actionUrl }}" class="bg-white w-full max-w-4xl rounded-2xl p-8 space-y-8 h-fit">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <h1 class="text-2xl font-semibold text-[#1c7cab]">
          {{ $isEdit ? 'Edit Task' : 'Tambah Task Projek' }} <br> {{ $projek->nama }}
        </h1>
        
        <div id="task-list" class="space-y-6">

          @if($isEdit)
            <div class="border rounded-xl p-5 space-y-4 border-pink-200">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-pink-400">Edit Task Aktif</h2>
                </div>

                <label class="block text-xs font-bold text-gray-400 uppercase">Judul Task</label>
                <input
                    type="text"
                    name="nama"
                    value="{{ $task->nama }}"
                    required
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-400"
                />

                <label class="block text-xs font-bold text-gray-400 uppercase">Assign Ke Anggota</label>
                <select name="member_id" required class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-50">
                    @foreach($projek->anggota as $member)
                        <option value="{{ $member->id }}" {{ $task->member_id == $member->id ? 'selected' : '' }}>
                            {{ $member->user->name }} ({{ $member->role }})
                        </option>
                    @endforeach
                </select>
            </div>
          @else
            <div class="border rounded-xl p-5 space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="font-semibold text-pink-400">Task #1</h2>
                </div>

                <input
                    type="text"
                    name="tasks[0][nama]"
                    placeholder="Judul Task"
                    required
                    class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-pink-400"
                />

                <select name="tasks[0][member_id]" required class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-50">
                    <option value="">Pilih Anggota</option>
                    @foreach($projek->anggota as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->user->name }} ({{ $member->role }})
                        </option>
                    @endforeach
                </select>
            </div>
          @endif

        </div>

        <div class="flex justify-between items-center">
          @if(!$isEdit)
          <button
            type="button"
            onclick="addTask()"
            class="text-pink-500 text-sm font-bold hover:underline">
            + Tambah Input Task Lagi
          </button>
          @else
          <a href="{{ url()->previous() }}" class="text-gray-400 text-sm hover:underline">Batal</a>
          @endif

          <button
            type="submit"
            class="bg-pink-400 text-white px-8 py-2 rounded-full font-bold hover:bg-pink-500 transition-all">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Semua Task' }}
          </button>
        </div>

      </form>
    </div>
  </div>

  @if(!$isEdit)
  <script>
    let taskIndex = 1;
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

        taskItem.innerHTML = `
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-pink-400">Task #` + (taskIndex + 1) + `</h2>
                <button type="button" onclick="this.closest('div.border').remove()" class="text-red-400 text-sm font-bold">Hapus</button>
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
  @endif
    
</body>
</html>