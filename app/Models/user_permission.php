<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_permission extends Model
{
    protected $table = 'user_permission';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'tent_id',
        'position_id',
    ];

    public $timestamps = true;

    public function position()
    {
        return $this->belongsTo(position::class, 'position_id', 'id');
    }
}
