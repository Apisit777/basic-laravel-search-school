<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountScheduleTask extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['task_name', 'is_completed', 'scheduled_date', 'completed_at'];
}
