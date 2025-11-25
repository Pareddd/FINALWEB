<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {
    protected $fillable = ['event_id', 'name', 'harga', 'kuota'];
}