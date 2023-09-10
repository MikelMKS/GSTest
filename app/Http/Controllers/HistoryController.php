<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationsHistory;
use App\Models\Notifications;

class HistoryController extends Controller
{
    public function __construct(){
        $this->windTit = "HISTORY DB";
    }

    public function db(){
        $history = NotificationsHistory::select('notifications_history.id AS id_h','notifications_history.created_at','notifications.id AS id_m','notifications.message','users.*','categories.name AS category','notifications_types.name AS type')
                                        ->leftJoin('notifications','notifications_history.id_notification','=','notifications.id')
                                        ->leftJoin('users','notifications_history.id_user','=','users.id')
                                        ->leftJoin('categories','notifications_history.id_category','=','categories.id')
                                        ->leftJoin('notifications_types','notifications_history.id_type','=','notifications_types.id')
                                        ->orderBy('notifications_history.id','desc')
                                        ->get();

        return view('History.db',compact('history'))->with(['windTit' => $this->windTit]);
    }
}
