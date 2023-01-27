<?php

namespace Modules\Space\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Space\Factories\BusCompaniesFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class BusCompanies extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table ='bravo_bus_companies';
    protected $fillable = ['name','image_id'];

    protected static function newFactory()
    {
        return BusCompaniesFactory::new();
    }
}
