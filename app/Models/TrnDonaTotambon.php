<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnDonaTotambon extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'doc_datetime',
        'doc_no',
        'event',
        'doc_refer',
        'flag',
        'cancel_date',
        'cancel_user',
        'member_id',
        'do_befor',
        'do_reedem',
        'do_balance',
        'donation_use',
        'tb_id',
        'school_id',
        'remark',
        'type_member',
        'reg_user',
        'reg_time',
        'upd_user',
        'upd_time',
        'time_up'
    ];
}
