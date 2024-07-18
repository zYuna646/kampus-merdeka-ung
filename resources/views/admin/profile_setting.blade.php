@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
    <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('student.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-color-primary-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Beranda
                </a>
            </li>
        </ol>
    </div>

    <div class="lg:col-span-4 col-span-12 w-full">
        <div class="p-6 bg-white grid grid-cols-12 gap-4 items-center rounded-xl shadow-sm border border-slate-200">
            <div class="relative col-span-3">
                <img src="/images/avatar/placeholder.jpg" alt="" class="w-20 rounded-full object-cover">
            </div>
            <div class="flex flex-col col-span-9">
                @auth
                <p class="font-semibold text-base uppercase">{{ Auth::user()->username }}</p>
                <span class="text-xs text-slate-500">{{ Auth::user()->role->name }}</span>
                @endauth
                {{-- <span class="text-slate-500 text-sm">Universitas Negeri Gorontalo</span> --}}
            </div>
        </div>
        <div class="w-full bg-white border border-gray-200 rounded-lg shadow mt-4">
            <div class="p-6">
                <div class="grid grid-flow-row divide-y-[1px]">
                    {{-- <button class="flex items-center gap-4 font-semibold pb-4 section-button"
                        data-section="profile">
                        <span><i class="fas fa-cog text-base"></i></span>
                        <p class="text-sm">Pengaturan Profil</p>
                    </button> --}}
                    <button class="flex items-center gap-4 font-semibold py-4 section-button" data-section="account">
                        <span><i class="fas fa-user text-base"></i></span>
                        <p class="text-sm">Pengaturan Akun</p>
                    </button>
                    <button class="flex items-center gap-4 font-semibold py-4 section-button" data-section="password">
                        <span><i class="fas fa-lock text-base"></i></span>
                        <p class="text-sm">Ganti Sandi</p>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
        <div id="account"
            class="section-content bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2 hidden">
            <h3 class="py-4 text-lg font-semibold">Pengaturan Akun</h3>
            <hr>
            <div class="flex flex-col py-2">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="username"
                            class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">username</label>
                        <input type="text" name="username" id="username" placeholder="username"
                            value="{{ Auth::user()->username }}"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
                    </div>

                    @auth
                    @if (Auth::user()->role->slug === 'mahasiswa')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Mahasiswa</label>
                        <input type="text" value="{{ Auth::user()->mahasiswa->name }}" name="name" id="name"
                            placeholder="Masukan Nama Mahasiswa"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                    </div>
                    {{-- new field nomor telp --}}
                    <hr class="mb-4 mt-4">
                    <div class="mb-4">
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No Telp</label>
                        <input type="number" name="no_hp" id="no_hp" value="{{ Auth::user()->mahasiswa->no_hp }}"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                    </div>

                    <div class="mb-4">
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">Domisili</label>
                        <select name="provinsi" id="provinsi"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            <option value="">Pilih Provinsi</option>
                            @foreach($data['provinsi'] as $id => $nama)
                            <option value="{{ $id }}" {{ optional(optional(optional(optional(Auth::user()->
                                mahasiswa)->desa)->district)->regency)->province_id == $id ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kabupaten" class="block text-sm font-medium text-gray-700 mb-2"></label>
                        <select name="kabupaten" id="kabupaten" value=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            <option value="">Pilih Kabupaten</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2"></label>
                        <select name="kecamatan" id="kecamatan" value=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2"></label>
                        <select name="kelurahan" id="kelurahan" value=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Asal</label>
                        <textarea name="alamat" id="alamat" value=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">{{ Auth::user()->mahasiswa->alamat ?? '' }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="penyakit" class="block text-sm font-medium text-gray-700 mb-2">Riwayat Penyakit
                            Kronis</label>
                        <textarea name="penyakit" id="penyakit" value=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">NIM Mahasiswa</label>
                        <input type="text" value="{{ Auth::user()->mahasiswa->nim }}" name="nim" id="nim"
                            placeholder="Masukan Nama Mahasiswa"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                    </div>
                    <div class="mb-4">
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">Nama Fakultas</label>
                        <select name="fakultas" id="fakultas"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            @foreach ($data['fakultas'] as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->mahasiswa->studi->jurusan->fakultas->id ==
                                $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-2">Nama Jurusan</label>
                        <select name="jurusan" id="jurusan"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            @foreach ($data['jurusan'] as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->mahasiswa->studi->jurusan->id == $item->id
                                ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-2">Nama Program
                            Studi</label>
                        <select name="studi_id" id="prodi"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            @foreach ($data['prodi'] as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->mahasiswa->studi->id == $item->id ?
                                'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    @elseif (Auth::user()->role->slug === 'dosen')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Dosen</label>
                        <input type="text" value="{{ Auth::user()->dosen->name }}" name="name" id="name"
                            placeholder="Masukan Nama Dosen"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                    </div>
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">NIP Dosen</label>
                        <input value="{{ Auth::user()->dosen->nip }}" type="text" name="nip" id="nip"
                            placeholder="Masukan NIP Dosen"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                    </div>
                    <div class="mb-4">
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-2">Nama Fakultas</label>
                        <select name="fakultas" id="fakultas"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            @foreach ($data['fakultas'] as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->dosen->studi->jurusan->fakultas->id ==
                                $item->id ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-2">Nama Jurusan</label>
                        <select name="jurusan" id="jurusan"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            @foreach ($data['jurusan'] as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->dosen->studi->jurusan->id == $item->id
                                ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-2">Nama Program
                            Studi</label>
                        <select name="studi_id" id="prodi"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            @foreach ($data['prodi'] as $item)
                            <option value="{{ $item->id }}" {{ Auth::user()->dosen->studi->id == $item->id ?
                                'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    @elseif (Auth::user()->role->slug === 'guru')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Mitra</label>
                        <input value={{Auth::user()->guru->name}} type="text" name="name" id="name" placeholder="Masukan
                        Nama Dosen"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50
                        xl:text-sm
                        text-xs"
                        value="">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">NIK Mitra</label>
                        <input value={{Auth::user()->guru->nik}} type="text" name="name" id="name" placeholder="Masukan
                        Nama
                        Dosen"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50
                        xl:text-sm
                        text-xs"
                        value="">
                    </div>
                    @endif
                    @endauth
                    <div class="py-2">
                        <x-button_md class="" color="primary" type="submit">
                            Simpan Perubahan
                        </x-button_md>
                    </div>
                </form>
            </div>
        </div>
        <div id="password"
            class="section-content bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2 hidden">
            <h3 class="py-4 text-lg font-semibold">Pengaturan Sandi</h3>
            <hr>
            <form action="{{ route('password') }}" method="POST" class="flex flex-col gap-y-4 py-4">
                @csrf
                <div>
                    <label for="current_password"
                        class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Sandi
                        Saat Ini</label>
                    <input type="password" name="current_password" id="current_password" placeholder="Sandi Saat Ini"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
                </div>
                <div>
                    <label for="new_password" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Sandi
                        Baru</label>
                    <input type="password" name="new_password" id="new_password" placeholder="Sandi Baru"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
                </div>

                <div class="py-2">
                    <x-button_md class="" color="primary" type="submit">
                        Simpan Perubahan
                    </x-button_md>
                </div>
            </form>
        </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {


            $('.section-button').on('click', function() {
                const section = $(this).data('section');
                $('.section-content').hide();
                $('#' + section).show();
            });

            $('#vehicle1').on('change', function() {
                const type = this.checked ? 'text' : 'password';
                $('input[type="password"]').attr('type', type);
            });

            const buttons = document.querySelectorAll('.section-button');
            const sections = document.querySelectorAll('.section-content');

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const sectionToShow = this.getAttribute('data-section');

                    sections.forEach(section => {
                        if (section.id === sectionToShow) {
                            section.classList.remove('hidden');
                        } else {
                            section.classList.add('hidden');
                        }
                    });
                });
            });

            const passwordFields = document.querySelectorAll('input[type="password"]');
            const checkbox = document.getElementById('vehicle1');

            checkbox.addEventListener('change', function() {
                passwordFields.forEach(field => {
                    field.type = checkbox.checked ? 'text' : 'password';
                });
            });

        });
</script>
<script>
    $(document).ready(function() {
        // Function to set selected value for a dropdown
        function setSelectedValue(selector, value) {
            if (value) {
                $(selector).val(value);
            }
        }

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
                            $('#kabupaten').append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Set selected option for Kabupaten
                        var kabupatenID = '{{ Auth::user()->mahasiswa->desa->district->regency->id ?? null }}';
                        setSelectedValue('#kabupaten', kabupatenID);

                        $('#kabupaten').trigger('change');
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
                            $('#kecamatan').append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Set selected option for Kecamatan
                        var kecamatanID = '{{ Auth::user()->mahasiswa->desa->district->id ?? null }}';
                        setSelectedValue('#kecamatan', kecamatanID);

                        $('#kecamatan').trigger('change');
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
                            $('#kelurahan').append('<option value="' + key + '">' + value + '</option>');
                        });

                        // Set selected option for Kelurahan
                        var kelurahanID = '{{ Auth::user()->mahasiswa->desa->id ?? null }}';
                        setSelectedValue('#kelurahan', kelurahanID);
                    }
                });
            } else {
                $('#kelurahan').empty();
                $('#kelurahan').append('<option value="">Pilih Kelurahan</option>');
            }
        });

        // Trigger initial change event to populate Kabupaten if Provinsi is pre-selected
        $('#provinsi').trigger('change');
    });
</script>


@endsection