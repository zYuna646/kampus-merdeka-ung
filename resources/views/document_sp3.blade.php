<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Surat Pernyataan Persetujuan Pembayaran UNG Mengajar</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    * {
      margin: 0;
      padding: 0;
    }

    body {
      padding: 4rem
    }

    header {
      width: 100%;
      margin-block: 12px;
    }

    header p {
      margin-block: 8px;
    }

    h1 {
      width: 100%;
      text-align: center;
      font-size: larger;
      margin-bottom: 24px;
    }
  </style>
</head>

<body>
  <div class="container">
    <header>
      <h1>SURAT PERNYATAAN</h1>
      <p style="margin-top: 4rem">Yang bertanda tangan di bawah ini:</p>
      <p style="margin-top: 1rem; font-size: small"><strong>Nama: {{ $mahasiswa->name }}</strong>
      <p style="font-size: small"><strong>NIM: {{ $mahasiswa->nim }}</strong>
      <p style="font-size: small"><strong>Program Studi: {{ $mahasiswa->studi->name }}</strong>
      <p style="font-size: small"><strong>Fakultas: {{ $mahasiswa->studi->jurusan->fakultas->name }}</strong>
      <p style="font-size: small"><strong>Nomor HP: {{ $mahasiswa->no_hp }}</strong>
    </header>

    <p style="margin-top: 1rem">Menyatakan dengan sebenar-benarnya bahwa:</p>
    <ol style="padding: 2rem">
      <li>Saya telah membaca dan memahami rincian anggaran biaya pelaksanaan Program {{ $program->name }} tahun {{
        $lowongan->tahun_akademik }} di
        website <a href="https://kampusmerdeka.ung.ac.id">https://kampusmerdeka.ung.ac.id</a>.</li>
      <li>Saya SETUJU dan siap mengikuti Program {{ $program->name }} yang dilaksanakan oleh LPMPP UNG dengan membayar
        biaya
        pelaksanaan sebesar Rp. 945.000,- (Sembilan Ratus Empat Puluh Lima Ribu Rupiah).</li>
      <li>Apabila di kemudian hari ditemukan bukti ketidakbenaran pernyataan ini maka saya siap menerima sanksi
        dibatalkan sebagai peserta Program {{ $program->name }} dan nilainya serta tidak akan menarik kembali uang yang
        telah disetorkan ke rekening Rektor UNG.</li>
    </ol>
    <p style="margin-bottom: 2rem">Demikian pernyataan ini saya buat dengan sadar tanpa ada paksaan dari pihak manapun.
    </p>
    <table style="width: 100%">
      <tr>
        <td style="width: 100%;"></td>
        <td style="width: 100%;"></td>
        <td style="width: 160%;">
          <div style="text-align: center;">
            <p style="">Gorontalo, {{ $date }}</p>
            <p>Yang Membuat Pernyataan</p>
            <br><br><br>
            <p style="font-size: small; width: 100%">({{ $mahasiswa->name }})</p>
          </div>
        </td>
      </tr>
    </table>


  </div>
</body>

</html>