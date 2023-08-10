@extends('layouts.app')

@section('body')
    <section class="relative h-screen py-16 bg-blueGray-50 bg-fixed bg-center bg-cover -mt-[74px]"
        style="background-image: url({{ asset('storage/outdor.jpg') }})">
        <div class="w-full mb-12 px-4">
            <div
                class="relative flex flex-col min-w-0 break-words w-full my-6 shadow-lg rounded 
      bg-sky-950 text-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1 ">
                            <h3 class="font-semibold text-lg text-white">List Order</h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto ">
                    <table class="items-center text-center w-full bg-transparent border-collapse">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Customer</th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Nama Gedung</th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    No Handphone</th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Fasilitas</th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Tanggal Dipesan</th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Total Harga</th>
                                <th
                                    class="w-auto px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Bukti Pembayaran</th>
                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Status</th>

                                <th
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold bg-cyan-400 text-white border-white">
                                    Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        {{ auth()->user()->name }}
                                    </td>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        {{ $booking->gedung->nama }}</td>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        {{ $booking->no_telp }}
                                    </td>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        @foreach ($booking->fasilitas as $fasilitas)
                                            <span>{{ $fasilitas->pivot->jumlah_unit }}{{ $fasilitas->fasilitas }} </span>
                                        @endforeach
                                    </td>

                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        {{ $booking->tanggal }}
                                    </td>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        Rp.{{ number_format($booking->harga_total, 0, ',', '.') }}
                                    </td>
                                    <td
                                        class="w-auto border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap text-left p-4 h-8">
                                        @if ($booking->status !== 'Cancel' && !$booking->image)
                                            <form action="{{ route('bukti', ['id' => $booking->id]) }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="w-56">
                                                    <div>
                                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                                            class="rounded-md w-full" required>
                                                        @error('bukti')
                                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                                        @enderror

                                                    </div>
                                                    <div class="inline-flex">
                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-8 rounded mt-4">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else
                                            <!-- Tampilkan gambar payment jika ada -->
                                            <img src="{{ asset('storage/' . $booking->image) }}" width="50"
                                                height="50" class="mx-auto">
                                        @endif
                                    </td>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        {{ $booking->status }}

                                    </td>
                                    <td
                                        class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-base whitespace-nowrap p-4">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                            action="{{ route('cancel', $booking->id) }}" method="POST">
                                            @csrf
                                            @if ($booking->status === 'Belum Dibayar')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-6 rounded mb-4">CANCEL</button>
                                            @endif
                                        </form>

                                        @if ($booking->status === 'Belum Dibayar')
                                            <a href="{{ route('edit', $booking->id) }}"
                                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-1 px-6 rounded mb-4">EDIT</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <footer class="relative pt-8 pb-6 mt-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap items-center md:justify-between justify-center">
                    <div class="w-full md:w-6/12 px-4 mx-auto text-center">
                        <div class="text-sm text-blueGray-500 font-semibold py-1">
                            Made with <a href="https://www.creative-tim.com/product/notus-js"
                                class="text-blueGray-500 hover:text-gray-800" target="_blank">Notus JS</a> by <a
                                href="https://www.creative-tim.com" class="text-blueGray-500 hover:text-blueGray-800"
                                target="_blank"> Creative Tim</a>.
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </section>
@endsection
