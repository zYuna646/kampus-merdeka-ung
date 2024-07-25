@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Edit Guru</h2>
    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
        <input type="text" name="nik" id="nik" value="{{ old('nik', $guru->nik) }}" placeholder="Masukan NIK"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @error('nik')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
        <input type="text" name="name" id="nama" value="{{ old('name', $guru->name) }}" placeholder="Masukan Nama"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required>
        @error('name')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
        <select name="lokasi_id[]" multiple class="js-example-basic-multiple w-full text-sm" required>
          @foreach ($lokasis as $lokasi)
          <option value="{{ $lokasi->id }}" {{ in_array($lokasi->id, $guru->lokasis->pluck('id')->toArray()) ?
            'selected' : '' }}>
            {{ $lokasi->name }}
          </option>
          @endforeach
        </select>
        @error('lokasi_id')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="new_pass" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
        <input type="password" name="new_pass" id="new_pass"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @error('new_pass')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="confirm_new_pass" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
          Baru</label>
        <input type="password" name="confirm_new_pass" id="confirm_new_pass"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @error('confirm_new_pass')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <x-button_md color="primary" class="w-full" type="submit">
        Kirim
      </x-button_md>
    </form>
  </div>
</section>
<script>
  $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection