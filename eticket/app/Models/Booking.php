<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'ticket_id', 'quantity', 'status'];
    public function ticket() {
        return $this->belongsTo(Ticket::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}