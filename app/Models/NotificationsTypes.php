<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsTypes extends Model
{
    use HasFactory;

    protected $table = 'notifications_types';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];
}
