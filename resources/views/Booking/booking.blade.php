@extends('layouts.app')

@section('body')
    <!-- This is an example component -->
    <div class="container -mt-[74px] top-0 bg-fixed mx-auto bg-cover bg-center p-6 h-full"
        style="background-image: url({{ asset('storage/arsitektur.jpg') }})">

        <form method="POST" action="{{ route('booking.store') }}"
            class="bg-black bg-opacity-50 shadow-shadowbold p-6 backdrop-blur-sm max-w-2xl mx-auto mt-14">
            {{-- method="POST" action="{{ route('booking.store') }}" --}}
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger mt-3" role="alert" id="danger-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    setTimeout(function() {
                        var successAlert = document.getElementById('danger-alert');
                        successAlert.style.display = 'none';
                    }, 8000);
                </script>
            @endif
            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
            {{-- <input type="hidden" name="gedung_id" id="gedung_id" value="{{ $gedungs->id }}"> --}}
            <div>
                <label for="user_id" class="block mb-2 text-sm font-medium text-white">Nama</label>
                <input type="text" id="user_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Masukkan nama" value="{{ auth()->user()->name }}" readonly>
            </div>
            <div class="grid gap-6 mb-6 lg:grid-cols-2">
                <div>
                    <label for="gedung_nama" class="block my-2 text-sm font-medium text-white">Nama
                        Gedung</label>
                    <input type="text" id="gedung_nama" value="{{ $gedungs->nama }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        readonly>
                    <input name="gedung_id" value="{{ $gedungs->id }}" type="hidden"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>
                <div>
                    <label for="no_telp" class="block my-2 text-sm font-medium text-white">No
                        Handphone</label>
                    <input type="tel" id="no_telp" name="no_telp"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Masukkan No Handphone" pattern="[0-9]{3,15}">
                </div>
            </div>
            <div>
                <label for="fasilitas" class="flex text-sm font-medium text-white">Pilih
                    fasilitas
                </label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($fasilitas as $fass)
                        @if ($fass->fasilitas == 'WC')
                            <div class="block">
                                <div class="inline-flex">
                                    <input class="flex items-center space-x-5 mx-2" type="checkbox" id="fasilitas"
                                        name="fasilitas_id[]" value="{{ $fass->id }}" checked onclick="return false;">
                                    <span class="text-white">{{ $fass->fasilitas }} :
                                        Gratis</span>
                                </div>
                                <div><input
                                        class="p-2 mb-5 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-32 rounded-lg"
                                        type="number" placeholder="Tersedia: {{ $fass->unit }}"
                                        max="{{ $fass->unit }}" name="jumlah_unit[]" value="{{ $fass->unit }}"
                                        readonly></div>
                            </div>
                        @else
                            <div class="block">
                                <div class="inline-flex">
                                    <input class="fasilitas-checkbox flex items-center space-x-5 mx-2"
                                        id="fasilitas_{{ $fass->id }}" data-batas="{{ $fass->unit }}"
                                        data-harga="{{ $fass->harga }}" type="checkbox" name="fasilitas_id[]"
                                        value="{{ $fass->id }}">
                                    <span class="text-white">{{ $fass->fasilitas }} :
                                        Rp.{{ $fass->harga, 0, ',', '.' }}/unit</span>
                                </div>
                                <div><input style="display: none"
                                        class="jumlah-unit-input p-2 mb-5 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 block w-32 rounded-lg"
                                        id="jumlah_unit_{{ $fass->id }}" type="number" name="jumlah_unit[]"
                                        placeholder="Tersedia: {{ $fass->unit }}" max="{{ $fass->unit }}"
                                        min="0" disabled></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @once
                <script>
                    // Dapatkan semua checkbox dengan nama fasilitas_id[]
                    const checkboxes = document.querySelectorAll('input[name="fasilitas_id[]"]');

                    // Tambahkan event listener untuk setiap checkbox
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', function() {
                            // Dapatkan nilai batas dari atribut data-batas
                            const batas = parseInt(this.getAttribute('data-batas'));

                            // Dapatkan input number terkait berdasarkan ID checkbox
                            const inputNumber = document.getElementById(`jumlah_unit_${this.value}`);

                            // Jika checkbox di-checked, aktifkan input number dan atur nilai maksimum sesuai dengan batas
                            if (this.checked) {
                                inputNumber.removeAttribute('disabled');
                                inputNumber.setAttribute('max', batas);
                                inputNumber.style.display = "block";
                            } else {
                                // Jika checkbox tidak di-checked, nonaktifkan input number dan reset nilainya menjadi 0
                                inputNumber.setAttribute('disabled', 'disabled');
                                inputNumber.removeAttribute('max');
                                inputNumber.value = "";
                                inputNumber.style.display = "none";
                            }
                        });
                    });

                    // Dapatkan semua input number dengan name jumlah_unit[]
                    const inputNumbers = document.querySelectorAll('input[name="jumlah_unit[]"]');

                    // Tambahkan event listener untuk setiap input number
                    inputNumbers.forEach(inputNumber => {
                        inputNumber.addEventListener('input', function() {
                            // Dapatkan nilai batas dari atribut max
                            const batas = parseInt(this.getAttribute('max'));
                            const batas1 = parseInt(this.getAttribute('min'));

                            // Dapatkan nilai yang dimasukkan pengguna
                            let nilai = parseInt(this.value);

                            // Jika nilai yang dimasukkan lebih besar dari batas, atur nilainya menjadi batas
                            if (nilai > batas) {
                                nilai = batas;
                                this.value = nilai;
                            }

                            if (nilai < batas1) {
                                this.value = batas1;
                            }
                        });
                    });
                </script>
            @endonce
            <div>
                <label for="tanggal" class="block my-2 text-sm font-medium text-white">Tanggal
                    Pemesanan</label>
                <input type="text" name="tanggal" id="tanggal" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    class="date bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Pilih tanggal" required>
            </div>
            <div>
                <label for="harga_total" class="block mb-2 text-sm font-medium text-white">Total
                    Harga</label>
                <input type="number" id="harga_total" name="harga_total"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Total harga" value="{{ $gedungs->harga }}" readonly>
            </div>
            <div class="mt-8">
                <button type="submit"
                    class="text-grey-700 bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 hover:dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 hover:dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">Submit</button>
            </div>
        </form>

    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formattedDates = @json($formattedDates, JSON_UNESCAPED_SLASHES);
            // console.log(formattedDates);
            const tomorrow = @json($tomorrow);

            //ambil elemen input tanggal
            const tanggalInput = document.getElementById('tanggal');
            const namaGedungInput = document.getElementById('gedung_nama');

            //buat fungsi untuk memeriksa apakah tanggal harus di-disable berdasarkan nama gedung
            function checkDisabledDates() {
                const selectedGedung = namaGedungInput.value;
                const disableDates = selectedGedung === '{{ $gedungs->nama }}' ? formattedDates : [];

                flatpickr('#tanggal', {
                    minDate: tomorrow,
                    dateFormat: "Y-m-d",
                    disable: disableDates,
                });
            }

            checkDisabledDates();

            namaGedungInput.addEventListener('change', checkDisabledDates);
        });

        const fasilitasCheckboxes = document.querySelectorAll('.fasilitas-checkbox');
        const jumlahUnitInputs = document.querySelectorAll('.jumlah-unit-input');
        const totalHargaInput = document.getElementById('harga_total');

        // Fungsi untuk menghitung total harga berdasarkan fasilitas yang dipilih
        function hitungTotalHarga() {
            let totalHarga = {{ $gedungs->harga }}; // Nilai gedungs->harga

            fasilitasCheckboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    const hargaPerUnit = parseInt(checkbox.getAttribute('data-harga'));
                    const jumlahUnit = parseInt(jumlahUnitInputs[index].value);
                    totalHarga += hargaPerUnit * jumlahUnit;
                }
            });

            totalHargaInput.value = totalHarga;
        }

        // Tambahkan event listener untuk checkbox dan input number
        fasilitasCheckboxes.forEach((checkbox, index) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    jumlahUnitInputs[index].removeAttribute('disabled');
                } else {
                    jumlahUnitInputs[index].setAttribute('disabled', 'disabled');
                    jumlahUnitInputs[index].value = '';
                }
                hitungTotalHarga();
            });

            jumlahUnitInputs[index].addEventListener('input', function() {
                hitungTotalHarga();
            });
        });
    </script>
@endsection
