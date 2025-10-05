<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'date', 
        'start_time', 
        'end_time'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function getFormattedDateAttribute()
    {
        return $this->date->format('d/m/Y');
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return date('H:i', strtotime($this->start_time)) . ' - ' . date('H:i', strtotime($this->end_time));
        }
        return $this->start_time ? date('H:i', strtotime($this->start_time)) : '';
    }
}
