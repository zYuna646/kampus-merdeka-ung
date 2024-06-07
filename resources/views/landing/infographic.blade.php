@extends('layout.landing')

@section('main')
    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-32 lg:py-36">
        <div class="col-span-12 lg:col-span-8 px-2">

        </div>

        <div class="col-span-12 lg:col-span-4 flex flex-col gap-y-4 px-2">
            <div>
                <h2 class="font-semibold text-lg px-4">
                    Infografis
                </h2>
                <div class="grid grid-flow-row p-4 gap-y-2 font-semibold text-xs">
                    @foreach ($data['program'] as $item)
                        <a href="" class="p-4 bg-white rounded-md text-color-primary-500">{{ $item->name }}</a>
                    @endforeach
                   
                </div>
            </div>
        </div>
    </section>
@endsection
