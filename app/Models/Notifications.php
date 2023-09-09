<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_category',
        'message'
    ];
}
