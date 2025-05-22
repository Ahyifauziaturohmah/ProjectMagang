<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - WinnieCode</title>
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white overflow-hidden"> <!-- Ini kunci no-scroll -->

    <!-- Navbar -->
    <nav class="bg-white shadow px-6 py-3 fixed top-0 left-0 w-full z-10">
      <div class="max-w-7xl mx-auto flex items-center">
        <a href="https://winnicode.com/" target="_blank" class="block">
          <img src="img/WinniCode.png" alt="logo" class="h-7" />
        </a>
      </div>
    </nav>

    <!-- Main Content (full height minus navbar) -->
    <div class="flex h-screen pt-[20px] bg-[#1578AE]"> <!-- Navbar tinggi 60px -->
      
      <!-- Left Section -->
      <div class="w-1/2 text-white flex flex-col justify-center px-28">
        <h1 class="text-5xl font-bold mb-4 leading-tight">Waktunya Berkarya<br />Bersama WinnieCode!</h1>
        <p class="text-lg">Selesaikan task-mu, tunjukkan kemampuanmu.<br />Setiap langkah kecil, mendekatkanmu ke impian besar!</p>
      </div>

      <!-- Right Section -->
      <div class="w-1/2 flex items-center justify-center">
        <div class="w-full max-w-md px-10 py-10 bg-white rounded-3xl shadow-2xl">
          <h2 class="text-pink-500 text-3xl font-bold text-center mb-8">Masuk</h2>

          @if ($errors->any())
          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul class="list-disc list-inside text-sm">
              @foreach ($errors->all() as $item)
              <li>{{ $item }}</li>
              @endforeach
            </ul>
          </div>
          @endif

          <form class="space-y-6" method="POST">
            @csrf
            <div>
              <label class="block text-pink-500 text-sm mb-1">Masuk menggunakan email magang</label>
              <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-2 border border-pink-300 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-400" />
            </div>
            <div>
              <label class="block text-pink-500 text-sm mb-1">Kata Sandi</label>
              <input type="password" name="password"
                class="w-full px-4 py-2 border border-pink-300 rounded-full focus:outline-none focus:ring-2 focus:ring-pink-400" />
            </div>
            <div class="text-center">
              <button type="submit" name="submit"
                class="bg-pink-500 text-white font-semibold py-2 px-8 rounded-full hover:bg-pink-600 transition">
                Masuk
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
    <footer class="bg-white w-full py-4 text-center text-gray-600 fixed bottom-0 left-0 border-t border-gray-200">
      © 2025 WinnieCode. All rights reserved.
    </footer>
  </body>
</html>
