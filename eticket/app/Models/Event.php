<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    protected $fillable = ['user_id', 'name', 'description', 'date_time', 'location', 'image'];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}