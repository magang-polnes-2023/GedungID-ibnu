<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Models\fasilitas;
use App\Models\gedung;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\View;
use Filament\Tables\Columns\Layout\View as LayoutView;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View as IlluminateViewView;

class BookingController extends Controller
{
    public function create(string $id)
    {
        $gedungs = gedung::findOrFail($id);
        $user = Auth::user();
        $fasilitas = fasilitas::all();

        $bookedDates = booking::whereNotNull('tanggal')
        ->where('gedung_id', $id)
        ->pluck('tanggal')
        ->toArray();
        
        // Ubah format tanggal menjadi "Y-m-d"
        $formattedDates = array_map(function ($date) {
            return date('Y-m-d', strtotime($date));
        }, $bookedDates);

        // Konversi array $formattedDates menjadi format JSON tanpa meng-escape tanda kutip
        $jsFormattedDates = json_encode($formattedDates, JSON_UNESCAPED_SLASHES);

        $tomorrow = Carbon::tomorrow();

        return view('Booking.booking', compact('gedungs', 'user', 'fasilitas', 'formattedDates', 'tomorrow'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'gedung_id'=> 'required',
            'fasilitas_id' => 'required|array',
            'jumlah_unit' => 'required|array',
            'no_telp' => 'required',
            'tanggal' => 'required',
            'harga_total' => 'required',
            'image',
        ]);

        if ($request->hasFile('image')) {

        $image = $request->file('image');
        $image->storeAs( 'public/', $image->hashName());

        $bookings = booking::create([
            'users_id'   => $request->user_id,
            'gedung_id'  => $request->gedung_id,
            'no_telp'    => $request->no_telp,
            'tanggal'    => $request->tanggal,
            'harga_total'=> $request->harga_total,
            'image'      => $image ->hashName()
        ]);

        $fasilitasIds = $request->input('fasilitas_id', []);
        $jumlahUnits = $request->input('jumlah_unit', []);

        $fasilitas = array_map(function ($fasilitasId, $jumlahUnit) {
            return ['fasilitas_id' => $fasilitasId, 'jumlah_unit' => $jumlahUnit];
        }, $fasilitasIds, $jumlahUnits);

        $bookings->fasilitas()->attach($fasilitas);

    } else {

        $bookings = booking::create([
            'users_id'   => $request->user_id,
            'gedung_id'  => $request->gedung_id,
            'no_telp'    => $request->no_telp,
            'tanggal'    => $request->tanggal,
            'harga_total'=> $request->harga_total,
        ]);

        $fasilitasIds = $request->input('fasilitas_id', []);
        $jumlahUnits = $request->input('jumlah_unit', []);

        $fasilitas = array_map(function ($fasilitasId, $jumlahUnit) {
            return ['fasilitas_id' => $fasilitasId, 'jumlah_unit' => $jumlahUnit];
        }, $fasilitasIds, $jumlahUnits);

        $bookings->fasilitas()->attach($fasilitas);
    }
        
        //redirect to index
        return redirect()->route('list')->with(['succes' => 'Data Berhasil Disimpan!']);
    }

    public function list()
    {
        $bookings = booking::where('users_id', auth()->user()->id)->get();
        $bookings = booking::orderByDesc('created_at')->get();


        return view('Booking.listorder', compact('bookings'));
    }

    public function bukti(Request $request, string $id)
    {
        $bookings = booking::findOrFail($id);

        $bukti = $request->file('bukti_pembayaran');
        $bukti->storeAs('public/', $bukti->hashName());

        Storage::delete('public/' . $bookings->bukti);
        
        $bookings->update([
            'image' => $bukti->hashName(),
            'status' => 'Menunggu',
        ]);

        return redirect()->route('list')->with(['succes' => 'Data Berhasil Disimpan!']);
    }

    public function cancel(string $id)
    {
        $bookings = booking::findOrFail($id);
        
        $bookings->update([
           'status' => 'Cancel',
        ]);

        return redirect()->route('list')->with(['succes' => 'Data Berhasil Dicancel!']);
    }

    public function hapus($id): RedirectResponse
        {
            //get booking by ID
            $bookings = booking::findOrFail($id);

            //delete image
            Storage::delete('public/'. $bookings->image);

            //delete booking
            $bookings->delete();

            //redirect to index
            return redirect()->route('list')->with(['success' => 'Data Berhasil Dihapus!']);
        }

    public function edit(string $id)
        {
            //get mahasiswa by ID
            $bookings = booking::findOrFail($id);
            $bookedDates = booking::whereNotNull('tanggal')->pluck('tanggal')->toArray();
        
        // Ubah format tanggal menjadi "Y-m-d"
        $formattedDates = array_map(function ($date) {
            return date('Y-m-d', strtotime($date));
        }, $bookedDates);

        // Konversi array $formattedDates menjadi format JSON tanpa meng-escape tanda kutip
        $jsFormattedDates = json_encode($formattedDates, JSON_UNESCAPED_SLASHES);

        $tomorrow = Carbon::tomorrow();

            //render view with post
            return view('Booking.edit', compact('bookings', 'bookedDates', 'formattedDates', 'tomorrow'));
        }
}
