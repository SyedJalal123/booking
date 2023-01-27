<?php

namespace Modules\Space\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Space\Factories\BusStopsFactory;
use Modules\Location\Models\Location;

class BusStops extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bravo_bus_stops';

    protected $fillable=[
        'name',
        'code',
        'location_id',
        'description',
        'address',
        'map_lat',
        'map_lng',
        'map_zoom',
    ];

    protected static function newFactory()
    {
        return BusStopsFactory::new();
    }
    public function location(){
        return $this->belongsTo(Location::class,'location_id');
    }
}
