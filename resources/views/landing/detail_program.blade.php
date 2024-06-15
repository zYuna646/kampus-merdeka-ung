@extends('layout.landing')

@section('main')
    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-32 lg:py-36">
      
        <div class="col-span-12 lg:col-span-8 px-2">
          
            <div class="flex flex-col col-span-12 rounded-lg shadow  min-h-96 w-full">
                <div class="w-full h-32 bg-color-primary-500 rounded-t-lg">
                </div>
                <div class="px-8 pb-8 bg-white w-full h-full rounded-b-lg relative">
                    <div class="col-span-2 absolute top-0 -translate-y-8">
                        <img src="/images/avatar/ung.png" alt="" class="w-16">
                    </div> 
                    
                    <div class="flex gap-x-2 items-center text-color-primary-500 mt-12 ">
                        <span class=""><i class="fas fa-book text-sm"></i></span>
                        <p class="text-sm font-semibold">{{ $data->program->name }}</p>
                    </div>
                    <div class="flex flex-col gap-y-1 mt-4">
                        <div class="inline-flex gap-x-2">
                            <span class="text-sm text-slate-500">Kode Program: </span>
                            <p class="text-sm">{{ $data->code }}</p>
                        </div>
                        <div class="inline-flex gap-x-2">
                            <span class="text-sm text-slate-500">Tahun Akademik: </span>
                            <p class="text-sm">{{ $data->tahun_akademik }}</p>
                        </div>
                        <div class="inline-flex gap-x-2">
                            <span class="text-sm text-slate-500">Semester: </span>
                            <p class="text-sm">{{ $data->semester }}</p>
                        </div>
                    </div>
                    <hr class="w-full mt-4 mb-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500">Program Dimulai: </span>
                        @php
                            $tanggalMulai = \Carbon\Carbon::parse($data->pendaftaran_mulai);
                            $tanggalSelesai = \Carbon\Carbon::parse($data->pendaftaran_selesai);
                            $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai);
                        @endphp

                        <p class="text-sm">
                            {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                            {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}
                            <span class="text-slate-500">({{ $selisihBulan }} bulan)</span>
                        </p>
                    </div>
                    <hr class="w-full mt-4 mb-4">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500">Pendaftaran Dimulai: </span>
                        @php
                            $tanggalMulai = \Carbon\Carbon::parse($data->tanggal_mulai);
                            $tanggalSelesai = \Carbon\Carbon::parse($data->tanggal_selesai);
                            $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai);
                        @endphp

                        <p class="text-sm">
                            {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                            {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}
                            <span class="text-slate-500">({{ $selisihBulan }} bulan)</span>
                        </p>
                    </div>
                    <hr class="mt-4 mb-4">
                    <div class="flex flex-col gap-y-2">
                        <p class="font-semibold">Informasi</p>
                        <p class="text-sm">
                            {!! $data->program->content !!}
                        </p>
                    </div>
                    <hr class="mt-4 mb-4">
                    <div>
                        <form action="{{ route('student.register', $data->id) }}" method="POST" class="inline-block">
                            @csrf
                            <x-button_md color="primary" class="w-fit" type="submit">
                                Daftar
                            </x-button_md>
                        </form>

                    </div>
                    <div class=" mt-10">
                      @if (session('success'))
                          <x-alerts color="info" :text="session('success')" />
                      @endif

                      @if (session('error'))
                          <x-alerts color="danger" :text="session('error')" />
                      @endif
                  </div>
                    

                </div>
                
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 flex flex-col gap-y-4 px-2">
            <div>
                <h2 class="font-semibold text-lg px-4">
                    Program Terbaru
                </h2>
                <div class="grid grid-flow-row divide-y-[1px]">
                    @foreach ($latestPrograms as $program)
                        <div class="bg-white divide-y-2 grid grid-cols-12 gap-4 p-4">
                            <div class="col-span-12 flex flex-col gap-y-2">
                                <div class="flex gap-x-2 items-center text-color-primary-500">
                                    <span class=""><i class="fas fa-book text-sm"></i></span>
                                    <p class="text-sm font-semibold">
                                        {{ $program->program->name }}
                                    </p>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-slate-500">Priode Kegiatan: </span>
                                    @php
                                        $tanggalMulai = \Carbon\Carbon::parse($program->tanggal_mulai);
                                        $tanggalSelesai = \Carbon\Carbon::parse($program->tanggal_selesai);
                                        $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai);
                                    @endphp

                                    <p class="text-sm">
                                        {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                                        {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}
                                        <span class="text-slate-500">({{ $selisihBulan }} bulan)</span>
                                    </p>
                                </div>
                                <x-button_md color="primary" class="mt-4 w-fit"
                                    onclick="window.location.href='{{ route('detail_program', $program->id) }}'">
                                    Detail Program
                                </x-button_md>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <script></script>
@endsection
