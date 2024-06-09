<div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
    <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="col-span-2">
            <img src="/images/avatar/ung.png" alt="" class="w-16">
        </div>
        <div class="col-span-12 flex gap-x-2 items-center text-color-primary-500 mt-2">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">{{$data->program->name}}</p>
        </div>
        <div class="col-span-12 mt-2 flex flex-col gap-y-2">
            <div class="flex flex-col">
                <span class="text-xs text-slate-500">Kode Kegiatan: </span>
                <p class="text-sm">{{$data->code}}</p>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-slate-500">Priode Kegiatan: </span>
                <p class="text-sm">
                    {{ \Carbon\Carbon::parse($data->tanggal_mulai)->format('d M Y') . ' - ' . \Carbon\Carbon::parse($data->tanggal_selesai)->format('d M Y') }}
                    <span class="text-slate-500"></span>
                </p>
            </div>
            
        </div>
        <div class="flex items-center col-span-12 mt-2 mb-2">
            <span
                class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full">
                <i class="fas fa-check"></i>
            </span>
            <p class="text-sm font-semibold">{{$data->programTransaction->count()}} Mahasiswa Terdaftar</p>
            
        </div>
        <div class="flex items-center col-span-12 mt-2 mb-2">
            <span
                class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full">
                <i class="fas fa-check"></i>
            </span>
            <p class="text-sm font-semibold">{{$data->dpl->count()}} DPL Terdaftar</p>
            
        </div>
        <div class="flex items-center col-span-12 mt-2 mb-2">
            <span
                class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full">
                <i class="fas fa-check"></i>
            </span>
            <p class="text-sm font-semibold">{{$data->pamong->count()}} Pamong Terdaftar</p>
            
        </div>
        <hr class="col-span-12 mt-4">
        <div class="col-span-12 mt-4 flex gap-x-1">
            <x-button_md color="primary" onclick="window.location.href='{{ route('operator.lowongan_detail', $data->id) }}'">
                Detail Lowongan
            </x-button_md>
        </div>
    </div>
</div>