@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
  <div class=" w-full flex items-end justify-center gap-x-4">
    <h1 class="font-semibold">Beranda</h1>
    <hr class="w-full">
  </div>
  <div class="grid grid-cols-12 gap-4">
    <div
      class="col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
      <div class="flex flex-col gap-y-1">
        <p class="text-sm font-semibold uppercase">Pengelola</p>
        <span class="text-4xl font-semibold ">{{$data['pengelola']}}</span>
      </div>
      <i class="fas fa-window-restore text-4xl"></i>
    </div>
    <div
      class="col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
      <div class="flex flex-col gap-y-1">
        <p class="text-sm font-semibold uppercase">Mahasiswa</p>
        <span class="text-4xl font-semibold ">{{$data['mahasiswa']}}</span>
      </div>
      <i class="fas fa-users text-4xl"></i>
    </div>
    <div
      class="col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
      <div class="flex flex-col gap-y-1">
        <p class="text-sm font-semibold uppercase">Mitra</p>
        <span class="text-4xl font-semibold ">{{$data['mitra']}}</span>
      </div>
      <i class="fas fa-users text-4xl"></i>
    </div>
    <div
      class="col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
      <div class="flex flex-col gap-y-1">
        <p class="text-sm font-semibold uppercase">Dosen</p>
        <span class="text-4xl font-semibold ">{{$data['dosen']}}</span>
      </div>
      <i class="fas fa-book text-4xl"></i>
    </div>
  </div>
</section>
@endsection