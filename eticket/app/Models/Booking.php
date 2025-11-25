<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = ['user_id', 'ticket_id', 'quantity', 'status'];
}