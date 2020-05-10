<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'parent_id', 'color', 'start_date', 'end_date'];
}
