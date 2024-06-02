@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Edit Lokasi</h2>
    <form action="{{ route('admin.location.update', $lokasi->id) }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
        <select name="program_id" id="program"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required>
          @foreach ($data['program'] as $program)
          <option value="{{ $program['id'] }}" {{ $program['id']==$lokasi->program_id ? 'selected' : '' }}>{{
            $program['name'] }}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
        <input type="text" name="name" id="name"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ $lokasi->name }}">
      </div>
      <div class="mb-4">
        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
        <input type="text" name="lokasi" id="lokasi"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ $lokasi->lokasi }}">
      </div>

      <div class="mb-4">
        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
        <select name="provinsi_id" id="provinsi"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required>
          <option value="">Pilih Provinsi</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="kabupaten" class="block text-sm font-medium text-gray-700 mb-2">Kabupaten/Kota</label>
        <select name="kabupaten_id" id="kabupaten"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required disabled>
          <option value="">Pilih Kabupaten/Kota</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
        <select name="kecamatan_id" id="kecamatan"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required disabled>
          <option value="">Pilih Kecamatan</option>
        </select>
      </div>

      <div class="mb-4">
        <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">Kelurahan</label>
        <select name="kelurahan_id" id="kelurahan"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required disabled>
          <option value="">Pilih Kelurahan</option>
        </select>
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
  const selectedProvinsiId = "{{ $lokasi->provinsi_id }}";
  const selectedKabupatenId = "{{ $lokasi->kabupaten_id }}";
  const selectedKecamatanId = "{{ $lokasi->kecamatan_id }}";
  const selectedKelurahanId = "{{ $lokasi->kelurahan_id }}";

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

          // Set the selected option if it matches the selectedProvinsiId
          if (province.id == selectedProvinsiId) {
            option.selected = true;
          }
        });

        if (selectedProvinsiId) {
          fetchCities(selectedProvinsiId);
        }
      })
      .catch(error => console.error('Error:', error));
  }

  // Function to fetch cities based on selected province and populate the city dropdown
  function fetchCities(provinsiId) {
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

          // Set the selected option if it matches the selectedKabupatenId
          if (city.id == selectedKabupatenId) {
            option.selected = true;
          }
        });

        if (selectedKabupatenId) {
          fetchDistricts(selectedKabupatenId);
        }
      })
      .catch(error => console.error('Error:', error));
  }

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

          // Set the selected option if it matches the selectedKecamatanId
          if (district.id == selectedKecamatanId) {
            option.selected = true;
          }
        });

        if (selectedKecamatanId) {
          fetchVillages(selectedKecamatanId);
        }
      })
      .catch(error => console.error('Error:', error));
  }

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

          // Set the selected option if it matches the selectedKelurahanId
          if (village.id == selectedKelurahanId) {
            option.selected = true;
          }
        });
      })
      .catch(error => console.error('Error:', error));
  }

  // Call fetchProvinces function when the page is loaded
  document.addEventListener('DOMContentLoaded', function () {
    fetchProvinces();
  });

  // Call fetchCities function when the province dropdown value changes
  document.getElementById('provinsi').addEventListener('change', function () {
    const selectedProvinsiId = this.value;
    fetchCities(selectedProvinsiId);
  });

  // Call fetchDistricts function when the city dropdown value changes
  document.getElementById('kabupaten').addEventListener('change', function () {
    const selectedKabupatenId = this.value;
    fetchDistricts(selectedKabupatenId);
  });

  // Call fetchVillages function when the district dropdown value changes
  document.getElementById('kecamatan').addEventListener('change', function () {
    const selectedKecamatanId = this.value;
    fetchVillages(selectedKecamatanId);
  });
</script>
@endsection