<?php

namespace Modules\Space\Models;

use App\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusTerm extends BaseModel
{
    use HasFactory;
    protected $table = 'bravo_bus_terms';
    protected $fillable = [
        'term_id',
        'target_id'
    ];
}
