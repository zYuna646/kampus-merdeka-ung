@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Lokasi</h2>
        <form action="{{ route('admin.location.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Program</label>
                <select name="program_id" id="lokasi" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach ($data['program'] as $program)
                        <option value="{{ $program['id'] }}">{{ $program['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="nama" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <input type="text" name="lokasi" id="nama" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                <select name="provinsi_id" id="provinsi" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="kabupaten" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                <select name="kabupaten_id" id="kabupaten" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required disabled>
                    <option value="">Pilih Kabupaten/Kota</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required disabled>
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required disabled>
                    <option value="">Pilih Kelurahan</option>
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Function to fetch provinces and populate the province dropdown
    function fetchProvinces() {
        fetch("{{ route('getProvinsi') }}")
            .then(response => response.json())
            .then(data => {
                const provinceSelect = document.getElementById('provinsi');

                // Clear existing options
                provinceSelect.innerHTML = '';

                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Pilih Provinsi';
                provinceSelect.add(defaultOption);

                // Add options for each province
                data.forEach(province => {
                    const option = document.createElement('option');
                    option.value = province.id;
                    option.text = province.name;
                    provinceSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Call fetchProvinces function when the page is loaded
    document.addEventListener('DOMContentLoaded', function() {
        fetchProvinces();
    });
</script>

<script>
    // Function to fetch cities based on selected province and populate the city dropdown
    function fetchCities(provinsiId) {
        console.log(provinsiId);

        fetch(`/get-kabupaten/${provinsiId}`)
            .then(response => response.json())
            .then(data => {
                const citySelect = document.getElementById('kabupaten');
                citySelect.disabled = false; // Enable the city dropdown

                // Clear existing options
                citySelect.innerHTML = '';

                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Pilih Kabupaten/Kota';
                citySelect.add(defaultOption);

                // Add options for each city
                data.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.id;
                    option.text = city.name;
                    citySelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Call fetchCities function when the province dropdown value changes
    document.getElementById('provinsi').addEventListener('change', function() {
        const selectedProvinsiId = this.value;
        fetchCities(selectedProvinsiId);
    });
</script>

<script>
    // Function to fetch districts based on selected city and populate the district dropdown
    function fetchDistricts(kabupatenId) {
        fetch(`/get-kecamatan/${kabupatenId}`)
            .then(response => response.json())
            .then(data => {
                const districtSelect = document.getElementById('kecamatan');
                districtSelect.disabled = false; // Enable the district dropdown

                // Clear existing options
                districtSelect.innerHTML = '';

                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Pilih Kecamatan';
                districtSelect.add(defaultOption);

                // Add options for each district
                data.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.text = district.name;
                    districtSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Call fetchDistricts function when the city dropdown value changes
    document.getElementById('kabupaten').addEventListener('change', function() {
        const selectedKabupatenId = this.value;
        fetchDistricts(selectedKabupatenId);
    });
</script>

<script>
    // Function to fetch villages based on selected district and populate the village dropdown
    function fetchVillages(kecamatanId) {
        fetch(`/get-kelurahan/${kecamatanId}`)
            .then(response => response.json())
            .then(data => {
                const villageSelect = document.getElementById('kelurahan');
                villageSelect.disabled = false; // Enable the village dropdown

                // Clear existing options
                villageSelect.innerHTML = '';

                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.text = 'Pilih Kelurahan';
                villageSelect.add(defaultOption);

                // Add options for each village
                data.forEach(village => {
                    const option = document.createElement('option');
                    option.value = village.id;
                    option.text = village.name;
                    villageSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Call fetchVillages function when the district dropdown value changes
    document.getElementById('kecamatan').addEventListener('change', function() {
        const selectedKecamatanId = this.value;
        fetchVillages(selectedKecamatanId);
    });
</script>
@endsection
