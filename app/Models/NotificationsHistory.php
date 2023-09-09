<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsHistory extends Model
{
    use HasFactory;

    protected $table = 'notifications_history';
    protected $primaryKey = 'id';
    public $timestamps = ['created_at'];

    protected $fillable = [
        'id_notification',
        'id_user',
        'id_category',
        'id_type'
    ];
}
