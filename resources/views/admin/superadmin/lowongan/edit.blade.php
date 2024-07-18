@extends('layout.admin')

@section('main')
    <section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
        <div class="bg-white p-6 rounded-xl mt-32">
            <h2 class="text-xl font-semibold mb-4">Edit Lowongan</h2>
            <form action="{{ route('admin.lowongan.update', $data['lowongan']->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                    <select name="program_id" id="program"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required>
                        @foreach ($data['program'] as $program)
                            <option value="{{ $program->id }}" {{$data['lowongan']->program_id == $program->id ? 'selected' : ''}}>{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="tahun_akademik" class="block text-sm font-medium text-gray-700 mb-2">Tahun Akademik</label>
                    <select name="tahun_akademik" id="tahun_akademik" class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" required>
                      @php
                          $startYear = 2020;
                          $endYear = 2050;
                      @endphp
                      @for ($year = $startYear; $year <= $endYear; $year++)
                          <option value="{{ $year }}-{{ $year + 1 }}" {{ $data['lowongan']->tahun_akademik == $year . '-' . ($year + 1) ? 'selected' : '' }}>
                              {{ $year }} - {{ $year + 1 }}
                          </option>
                      @endfor
                  </select>
                  
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Log Book?</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center" >
                            <input type="radio" name="isLogBook" value="1"
                                class="form-radio text-indigo-600 focus:ring-indigo-500 h-4 w-4" required {{$data['lowongan']->isLogBook? 'checked' : ''}} disabled>
                            <span class="ml-2 text-sm text-gray-900">Ya</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="isLogBook" value="0"
                                class="form-radio text-red-600 focus:ring-red-500 h-4 w-4" required disabled {{!$data['lowongan']->isLogBook? 'checked' : ''}}>
                            <span class="ml-2 text-sm text-gray-900">Tidak</span>
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="semester" class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                    <select name="semester" id="semester"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required>
                        <option {{$data['lowongan']->semester == 'Genap' ? 'selected' : ''}} value="Genap">Genap</option>
                        <option {{$data['lowongan']->semester == 'Ganjil' ? 'selected' : ''}} value="Ganjil">Ganjil</option>
                    </select>
                </div>
                
                <div class="mb-4">
                  <label for="pendaftaran_mulai" class="block text-sm font-medium text-gray-700 mb-2">Pendaftaran Mulai</label>
                  <input type="datetime-local" name="pendaftaran_mulai" id="pendaftaran_mulai"
                      class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                      required value="{{$data['lowongan']->pendaftaran_mulai}}">
              </div>
              <div class="mb-4">
                  <label for="pendaftaran_selesai" class="block text-sm font-medium text-gray-700 mb-2">Pendaftaran Selesai</label>
                  <input type="datetime-local" name="pendaftaran_selesai" id="pendaftaran_selesai"
                      class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                      required value="{{$data['lowongan']->pendaftaran_selesai}}">
              </div>              
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required value="{{$data['lowongan']->tanggal_mulai}}"  disabled>
                </div>
                <div class="mb-4">
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal
                        Selesai</label>
                    <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required value="{{$data['lowongan']->tanggal_selesai}}"  disabled
                        >
                </div>
                <div class="mb-4">
                    <label for="sk_rektor" class="block text-sm font-medium text-gray-700 mb-2">SK Rektor</label>
                    <input type="file" name="sk_rektor" id="sk_rektor"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required>
                </div>
                <x-button_md class="w-full" type="submit" color="primary">
                    Kirim
                </x-button_md>
            </form>
        </div>
    </section>
@endsection
