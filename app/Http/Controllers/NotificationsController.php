<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\Categories;

class NotificationsController extends Controller
{
    public function __construct(){
        $this->windTit = "NOTIFICATIONS";
    }

    public function index(){
        $notifications = Notifications::all();

        return view('Notifications.index',compact('notifications'))->with(['windTit' => $this->windTit]);
    }

    public function new(){
        $categories = Categories::all();

        return view('Notifications.new',compact('categories'));
    }

    public function save(Request $request){
        $response = array('sta' => 0,'msg' => '');

        // Request data
        $category = $request->categories_sel;
        $message = $request->message_tex;

        // Validate data is not empty
        $response = noEmpty($category,'CATEGORY',$response);
        $response = noEmpty($message,'MESSAGE',$response);

        // If all data needed is not empty, continue
        if($response['sta'] == 0){
            // Insert data
            $notification = new Notifications();
            $notification->id_category = $category;
            $notification->message = $message;
            $notification->save();
        }

        echo json_encode($response);
    }
}
