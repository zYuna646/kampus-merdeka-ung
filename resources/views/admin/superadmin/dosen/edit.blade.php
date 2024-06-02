@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Tambah Dosen</h2>
    <form action="{{ route('admin.dosen.store') }}" method="POST">
      <div class="mb-4">
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">NIDN</label>
        <input type="number" name="nidn" id="nidn" placeholder="Masukan NIDN"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ $dosen->nidn }}">
        @error('nidn')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Dosen</label>
        <input type="text" name="name" id="nama" placeholder="Masukan Nama Dosen"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ $dosen->name }}">
        @error('name')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        @csrf
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Program Studi</label>
        <select type="text" name="studi_id" id="nama" placeholder="Masukan Nama Program Studi"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required>
          @foreach ($data['studi'] as $studi)
          <option value="{{ $studi['id'] }}" {{ $studi['id']===$dosen->studi_id ? 'selected' : '' }}>{{ $studi['name']}}
          </option>
          @endforeach
        </select>
        @error('studi_id')
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