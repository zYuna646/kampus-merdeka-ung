@extends('layout.auth')

@section('main')
<section class="h-screen flex flex-col relative">
  <div class="w-full h-full bg-color-primary-500 flex-[3] flex justify-end ">
    <div class="xl:inline-flex items-center justify-center px-12 gap-x-2 hidden max-w-screen-xl mx-auto">
      <div class="flex-[1] text-white  w-full flex flex-col gap-y-4">
        <div class="flex flex-col gap-y-2">
          <h1 class="font-bold text-4xl">Kampus Merdeka</h1>
          <span class="font-light">Universitas Negeri Gorontalo</span>
        </div>
        <p class="text-xs ">
          Pantau aktivitas mahasiswa MBKM di UNG dengan mudah! Dapatkan solusi terpadu untuk transparansi dan
          kesuksesan program MBKM dalam satu platform resmi UNG. Pastikan kemajuan dan evaluasi kegiatan dengan
          aplikasi monitoring inovatif kami.
        </p>
      </div>
      <div class=" flex-[3]">
        <img src="/images/hero-image/Saly-1.png" alt="" class="w-96">
      </div>
    </div>
  </div>
  <div class="w-full flex-[1] hidden lg:block">

  </div>
  <div class="w-full h-screen absolute">
    <div class="max-w-screen-xl w-full h-full mx-auto flex items-center justify-center xl:justify-end px-8">
      <div class="xl:p-8 p-6 bg-white rounded-3xl max-w-md w-full flex flex-col gap-y-4 shadow-md">
        <h2 class="xl:text-3xl text-2xl font-bold text-gray-800">Akademik</h2>
        <form class="xl:mt-2" action="{{ route('register.form', ['step' => 2]) }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="fakultas" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Masukan
              Fakultas</label>
            <select name="fakultas" id="fakultas"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Fakultas</option>
              @foreach($fakultas as $id => $nama)
              <option value="{{ $id }}">{{ $nama }}</option>
              @endforeach
            </select>
            @error('fakultas')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="jurusan" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Jurusan</label>
            <select name="jurusan" id="jurusan"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Jurusan</option>
            </select>
            @error('jurusan')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="prodi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih Prodi</label>
            <select name="prodi" id="prodi"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Prodi</option>
            </select>
            @error('prodi')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
          </div>
          <div class="">
            <label for="angkatan" class="block text-sm font-medium text-gray-700 mb-2">Angkatan</label>
            <input type="number" min="2000" max="3000" name="angkatan" id="angkatan" placeholder="2000"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs">
            @error('angkatan')
            <div class="invalid-feedback text-red-400">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class=" mt-4">
            <button type="submit"
              class="xl:px-5 xl:py-3 py-3 px-4 xl:text-base text-sm w-full font-medium text-center text-white bg-color-primary-500 rounded-md hover:bg-color-primary-600 focus:ring-4 focus:outline-none focus:ring-color-primary-300">Selanjutnya</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
        $('#fakultas').change(function() {
            var fakultasID = $(this).val();
            if (fakultasID) {
                $.ajax({
                    url: '/get-data',
                    type: "GET",
                    data: { type: 'jurusan', parent_id: fakultasID },
                    dataType: "json",
                    success: function(data) {
                        $('#jurusan').empty();
                        $('#jurusan').append('<option value="">Pilih Jurusan</option>');
                        $.each(data, function(key, value) {
                            $('#jurusan').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $('#prodi').empty();
                        $('#prodi').append('<option value="">Pilih Prodi</option>');
                    }
                });
            } else {
                $('#jurusan').empty();
                $('#jurusan').append('<option value="">Pilih Jurusan</option>');
                $('#prodi').empty();
                $('#prodi').append('<option value="">Pilih Prodi</option>');
            }
        });

        $('#jurusan').change(function() {
            var jurusanID = $(this).val();
            if (jurusanID) {
                $.ajax({
                    url: '/get-data',
                    type: "GET",
                    data: { type: 'prodi', parent_id: jurusanID },
                    dataType: "json",
                    success: function(data) {
                        $('#prodi').empty();
                        $('#prodi').append('<option value="">Pilih Prodi</option>');
                        $.each(data, function(key, value) {
                            $('#prodi').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#prodi').empty();
                $('#prodi').append('<option value="">Pilih Prodi</option>');
            }
        });
    });
  </script>
</section>
@endsection