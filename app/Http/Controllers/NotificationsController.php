<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\Categories;
use App\Http\Controllers\SendsController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class NotificationsController extends Controller
{
    public function __construct(){
        $this->windTit = "NOTIFICATIONS";
    }

    public function index(){
        $notifications = Notifications::select('notifications.*','categories.name AS category')
                                        ->leftJoin('categories', 'notifications.id_category','=','categories.id')
                                        ->orderBY('id','desc')
                                        ->get();

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
        $response = noEmptyNumeric($category,'CATEGORY',$response);
        $response = noEmpty($message,'MESSAGE',$response);

        // If all data needed is not empty, continue
        if($response['sta'] == 0){
            // Insert data
            $notification = new Notifications();
            $notification->id_category = $category;
            $notification->message = $message;
            $notification->save();

            // After create the notification, call send function with curreent notification created id
            $this->send($notification->id);
        }

        return json_encode($response);
    }

    // Send notification need the notification id
    public function send($id){
        // Verify if notification to send exist
        try{
            $notification = Notifications::findOrFail($id);
        }catch (ModelNotFoundException $exception) {
            $notification = null;
        }

        // Call all types of notification to send
        if(!empty($notification)){
            // We call the method that sends an existing notification to all users and all notification types
            (new SendsController)->all($id,null,null);
        }

        return $notification;
    }
}
