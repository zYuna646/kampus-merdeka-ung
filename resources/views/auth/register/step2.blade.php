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
    <div class="max-w-screen-xl w-full h-full mx-auto flex items-center justify-center xl:justify-end px-8 pt-8">
      <div class="xl:p-8 p-6 bg-white rounded-3xl max-w-md w-full flex flex-col gap-y-4 shadow-md">
        <h2 class="xl:text-3xl text-2xl font-bold text-gray-800">Domisili</h2>
        <form class="xl:mt-2" action="{{ route('register.form', ['step' => 2]) }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="provinsi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Provinsi</label>
            <select name="provinsi" id="provinsi"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Provinsi</option>
              @foreach($provinsi as $id => $nama)
              <option value="{{ $id }}">{{ $nama }}</option>
              @endforeach
            </select>
            @error('provinsi')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="kabupaten" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Kabupaten</label>
            <select name="kabupaten" id="kabupaten"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Kabupaten</option>
            </select>
            @error('kabupaten')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="kecamatan" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Kecamatan</label>
            <select name="kecamatan" id="kecamatan"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Kecamatan</option>
            </select>
            @error('kecamatan')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
            @enderror
          </div>
          <div class="">
            <label for="kelurahan" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Kelurahan</label>
            <select name="kelurahan" id="kelurahan"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs ">
              <option value="">Pilih Kelurahan</option>
            </select>
            @error('kelurahan')
            <div class="invalid-feedback text-red-400">{{ $message }}</div>
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
        $('#provinsi').change(function() {
            var provinsiID = $(this).val();
            if (provinsiID) {
                $.ajax({
                    url: '/get-data',
                    type: "GET",
                    data: { type: 'kabupaten', parent_id: provinsiID },
                    dataType: "json",
                    success: function(data) {
                        $('#kabupaten').empty();
                        $('#kabupaten').append('<option value="">Pilih Kabupaten</option>');
                        $.each(data, function(key, value) {
                            $('#kabupaten').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $('#kecamatan').empty();
                        $('#kecamatan').append('<option value="">Pilih Kecamatan</option>');
                        $('#kelurahan').empty();
                        $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
                    }
                });
            } else {
                $('#kabupaten').empty();
                $('#kabupaten').append('<option value="">Pilih Kabupaten</option>');
                $('#kecamatan').empty();
                $('#kecamatan').append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty();
                $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
            }
        });

        $('#kabupaten').change(function() {
            var kabupatenID = $(this).val();
            if (kabupatenID) {
                $.ajax({
                    url: '/get-data',
                    type: "GET",
                    data: { type: 'kecamatan', parent_id: kabupatenID },
                    dataType: "json",
                    success: function(data) {
                        $('#kecamatan').empty();
                        $('#kecamatan').append('<option value="">Pilih Kecamatan</option>');
                        $.each(data, function(key, value) {
                            $('#kecamatan').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                        $('#kelurahan').empty();
                        $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
                    }
                });
            } else {
                $('#kecamatan').empty();
                $('#kecamatan').append('<option value="">Pilih Kecamatan</option>');
                $('#kelurahan').empty();
                $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
            }
        });

        $('#kecamatan').change(function() {
            var kecamatanID = $(this).val();
            if (kecamatanID) {
                $.ajax({
                    url: '/get-data',
                    type: "GET",
                    data: { type: 'kelurahan', parent_id: kecamatanID },
                    dataType: "json",
                    success: function(data) {
                        $('#kelurahan').empty();
                        $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
                        $.each(data, function(key, value) {
                            $('#kelurahan').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#kelurahan').empty();
                $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
            }
        });
    });
  </script>
</section>
@endsection