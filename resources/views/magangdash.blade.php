<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - WinnieCode</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-white">
    <!-- sidebar -->

    <!-- Main Section -->
    <div class="flex min-h-screen ">
      <!-- Left Section -->
      <div class=" text-[#1578AE] flex flex-col justify-center px-28">
        <h1 class="text-6xl font-bold mb-4">Hai, <br />{{ Auth::user()->name }} </h1>
        <p class="text-lg">Setiap task yang kamu selesaikan hari ini, adalah langkah lebih dekat ke masa depanmu.<br />Let's make today count!</p>
      </div>

            

    </div>
  </body>
</html>
