<?php

namespace Modules\Space\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Space\Factories\BusSeatFactory;

class BusSeat extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'bravo_bus_seats';
    protected $fillable=['seat_type','flight_id','price','max_passengers','person','baggage_check_in','baggage_cabin'];

    public function flight()
    {
        return $this->belongsTo(Bus::class,'flight_id')->withDefault();
    }
    public function seatType(){
        return $this->belongsTo(BusSeatType::class,'seat_type','code')->withDefault();
    }

    protected static function newFactory()
    {
        return BusSeatFactory::new();
    }
    public function save(array $options = [])
    {
        $save =  parent::save($options); // TODO: Change the autogenerated stub
        if($save){
            $min_price = self::where('flight_id',$this->flight_id)->get()->min('price');
            $flight= $this->flight;
            if($min_price < $flight->min_price or empty($flight->min_price)){
                $flight->min_price = $min_price;
                $flight->save();
            }
        }
        return $save;
    }
}
