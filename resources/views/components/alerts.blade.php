<!-- resources/views/components/alert.blade.php -->
@props(['color' => 'info', 'text' => ''])

<div id="alert" class="w-full flex items-center justify-between px-4 py-4 bg-color-{{ $color }}-100 border-2 border-color-{{ $color }}-500 rounded-xl ">
    <div class="text-sm font-semibold text-color-{{ $color }}-500">
        <p>{{ $text }}</p>
    </div>
    <x-button_sm onclick="closeAlert()" color="{{ $color }}">
        <span><i class="fas fa-times"></i></span>
    </x-button_sm>
</div>

<script>
function closeAlert() {
    document.getElementById('alert').style.display = 'none';
}
</script>
