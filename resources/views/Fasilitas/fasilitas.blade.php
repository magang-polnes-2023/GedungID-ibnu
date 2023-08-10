@extends('layouts.app')

@section('body')
    <div class="container p-4 bg-fixed bg-center bg-cover text-white -mt-[74px]"
        style="background-image: url({{ asset('storage/building.png') }})">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="text-center mt-20">
                            <h5>Fasilitas Yang Tersedia:</h5>
                            <div class="flex flex-wrap justify-center gap-10">
                                @foreach ($fasilitas as $fass)
                                    <ul>
                                        <!-- component -->
                                        <div
                                            class="p-5 mx-auto my-10 max-w-lg overflow-hidden rounded-lg shadow-shadowbold justify-between backdrop-blur-sm">
                                            <li><img class="rounded-[50%] hover:rounded-none transition-all h-80 w-80"
                                                    src="{{ asset('storage/' . $fass->foto) }}" alt=""></li>
                                            <div class="p-4 bg-opacity-0 bg-white ">
                                                <li><strong>Fasilitas :</strong> {{ $fass->fasilitas }}</li>
                                                <li><strong>Total Unit :</strong> {{ $fass->unit }}</li>
                                                <li><strong>Harga/unit :</strong> {{ $fass->harga }}</li>
                                            </div>
                                        </div>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
