<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticketsession extends Model
{
    protected $table = 'ticketsessions';
    protected $fillable = [
                'session_title',
                'realized_at',
                'start_at',
                'end_at',
                'events_id'
    ];
    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id');
    }
}

