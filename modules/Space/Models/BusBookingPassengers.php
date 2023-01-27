<?php

namespace Modules\Space\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Booking\Models\Bookable;
use Modules\Booking\Models\Booking;

class BusBookingPassengers extends Bookable
{
    use HasFactory;
    use SoftDeletes;

    protected $slugField = false;
        protected $slugFromField = false;
        protected $table ='bus_booking_passengers';
        protected $fillable = [
            'flight_id',
            'flight_seat_id',
            'booking_id',
            'seat_type',
            'email',
            'first_name',
            'last_name',
            'phone',
            'dob',
            'price',
            'id_card'
        ];
        public function booking(){
            return $this->belongsTo(Booking::class,'booking_id');
        }
}
