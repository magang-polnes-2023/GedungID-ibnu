<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable = [
        'users_id',
        'gedung_id',
        'fasilitas_id',
        'no_telp',
        'tanggal',
        'harga_total',
        'image',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function gedung()
    {
        return $this->belongsTo(gedung::class, 'gedung_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(fasilitas::class, 'fasilitas_bookings', 'bookings_id', 'fasilitas_id')->withPivot(['jumlah_unit']);
    }


}
