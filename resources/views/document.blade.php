<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
  <title>Document</title>
</head>

<body class="p-12">
  <header class="w-full flex flex-col gap-y-2">
    <div class="w-full items-center flex flex-col font-bold ">
      <p>FORMAT LOG BOOK HARIAN</p>
      <p>KEGIATAN MENGAJAR DI SEKOLAH</p>
    </div>
    <div class="font-semibold flex flex-col mt-4">
      <p>Nama Mahasiswa : Mohamad Rafiq Daud</p>
      <p>Jurusan : Teknik Informatika</p>
      <p>Nama Sekolah : Sekolah Tunjang Tunjing</p>
      <p>Jurusan : SDN 5 Kota Timur</p>
    </div>
  </header>
  <main class="flex items-start w-full mt-4">
    <table class="w-full border-collapse border" border="1">
      <thead>
        <tr>
          <th class="border p-4">No</th>
          <th  class="border p-4">Mulai aktivitas</th>
          <th  class="border p-4">Deskripsi aktivitas</th>
          <th  class="border p-4">Rencana kegiatan ke-</th>
          <th  class="border p-4">% Capaian dari rencana</th>
          <th  class="border p-4">Hambatan</th>
          <th  class="border p-4">Rencana solusi</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border p-4">1</td>
          <td  class="border p-4">07.15-0.15</td>
          <td  class="border p-4">Apel Pagi</td>
          <td  class="border p-4"></td>
          <td  class="border p-4"></td>
          <td  class="border p-4"></td>
          <td  class="border p-4"></td>
        </tr>
      </tbody>
    </table>
  </main>
  <footer class="w-full flex justify-between items-end mt-8 px-4">
    <div class="flex flex-col font-semibold max-w-lg items-center">
      <p class="">Mengetahui</p>
      <p>Guru Pamong</p>
      <div class="w-20 h-20"></div>
      <p>(Mohamad Rafiq Daud)</p>
    </div>
    <div class="flex flex-col font-semibold max-w-lg items-center">
      <p>Mahasiswa Peserta</p>
      <div class="w-20 h-20"></div>
      <p>(Mohamad Rafiq Daud, S.Pd, M.Pd)</p>
    </div>
  </footer>
</body>

</html>