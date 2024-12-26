<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Participant;

class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';
    protected $fillable = [
        'category_title',
        'title',
        'event_type',
        'location',
        'description',
        'payment_info',
        'banner_image',
        'category_id'
    ];

    public function participants()
{
    return $this->hasMany(Participant::class);
}
}
