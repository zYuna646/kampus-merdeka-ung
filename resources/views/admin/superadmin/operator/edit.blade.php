@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Edit Operator</h2>
    <form action="{{ route('admin.operator.update', $operator->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukan Username"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ old('username', $operator->username) }}">
        @error('username')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="old_password" class="block text-sm font-medium text-gray-700 mb-2">Password Lama</label>
        <input type="password" name="old_password" id="old_password"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @error('old_password')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
        <input type="password" name="password" id="password"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @error('password')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password
          Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @error('password_confirmation')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mt-4 inline-flex gap-x-2">
        <input type="checkbox" name="password" id="password"
          class="block xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Lihat Password</label>
      </div>
      <x-button_md color="primary" class="w-full" type="submit">
        Update
      </x-button_md>
    </form>
  </div>
</section>
@endsection