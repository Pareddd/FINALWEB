<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    protected $fillable = ['user_id', 'name', 'deskripsi', 'tanggal', 'lokasi', 'image'];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}