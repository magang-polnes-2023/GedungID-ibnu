@extends('layouts.app')

@section('body')
    <div class="slider-container p-0 h-full -mt-[74px]">
        @foreach ($gedungs as $gedung)
            <div class="sliderAx h-full m-0 p-0">
                <div id="slider-{{ $gedung->id }}" class="container mx-auto slider hidden">
                    <!-- Konten slider -->
                    <div class="bg-cover bg-center h-screen text-white py-24 px-10 object-fill"
                        style="background-image: url({{ asset('storage/' . $gedung->foto) }})">
                        <div class="inline-block ml-8 px-4 py-4 rounded-md bg-black bg-opacity-70">
                            <div>
                                <ul class="">
                                    <li class="text-white text-6xl font-bold"><strong
                                            class="text-sky-700 block">Gedung</strong>
                                        {{ $gedung->nama }}</li>
                                    <li class="font-bold text-sm uppercase mb-8">
                                        {{ $gedung->lokasi }}</li>
                                    <div>
                                        <strong>Fasilitas </strong>
                                        @foreach ($gedung->fasilitas as $fasilitas)
                                            <li class="inline-flex text-2xl leading-none ">|
                                                {{ $fasilitas->fasilitas }}
                                            </li>
                                        @endforeach
                                    </div>
                                    <li><strong>Deskripsi:</strong> {{ $gedung->deskripsi }}</li>
                                    <li class="text-2xl font-bold">
                                        {{ $gedung->harga == 0 ? 'Gratis' : 'Rp ' . number_format($gedung->harga, 0, ',', '.') }}
                                    </li>
                                    <li><strong>Ketersediaan:</strong> {{ $gedung->ketersediaan }}</li>
                                </ul>
                            </div>
                            <div class="my-6 ml-8">
                                <a href="{{ route('booking', ['id' => $gedung->id]) }}"
                                    class="py-4 px-10 bg-gray-200 text-gray-800 font-bold uppercase text-xs rounded-full hover:bg-sky-950 hover:text-white">Booking</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Konten slider -->
                </div>
            </div>
        @endforeach
        {{-- <button @click="previous()"
            class="absolute left-5 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-md">
            <i class="fas fa-chevron-left text-2xl font-bold text-gray-500"></i>
        </button>

        <button @click="forward()"
            class="absolute right-5 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-md">
            <i class="fas fa-chevron-right text-2xl font-bold text-gray-500"></i>
        </button> --}}

        <div>
            <button onclick="changeSlider(-1)"
                class="absolute left-5 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-md"><img
                    src="{{ asset('storage/left-chevron.png') }}" alt="My Icon"></button>
        </div>
        <button onclick="changeSlider(1)"
            class="absolute right-5 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-md"><img
                src="{{ asset('storage/left-chevron.png') }}" alt="My Icon" class="transform scale-x-[-1]"></button>

    </div>



    <script>
        var sliderContainers = document.querySelectorAll('.slider-container .slider');
        var currentSliderIndex = 0;

        function showSlider(sliderIndex) {
            for (var i = 0; i < sliderContainers.length; i++) {
                sliderContainers[i].classList.add('hidden');
            }
            sliderContainers[sliderIndex].classList.remove('hidden');
        }

        function changeSlider(delta) {
            currentSliderIndex = (currentSliderIndex + delta + sliderContainers.length) % sliderContainers.length;
            showSlider(currentSliderIndex);
        }

        function startSlider() {
            setInterval(function() {
                changeSlider(1);
            }, 8000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            showSlider(currentSliderIndex);
            startSlider();
        });
    </script>
@endsection
