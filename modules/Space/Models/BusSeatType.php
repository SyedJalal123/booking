<?php

namespace Modules\Space\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusSeatType extends BaseModel
{
    use SoftDeletes;

    protected $table = 'bravo_bus_seat_types';
    protected $fillable  = ['name','code'];

}
