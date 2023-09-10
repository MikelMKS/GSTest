<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Notifications;
use App\Models\NotificationsHistory;
use App\Models\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class SendsController extends Controller
{
    // This will send same notification/message to all available types
    // Can recieve notification id => id and his meessage or only a message without id that means is not from a notification, and an specific user or null to be sent to all users
    public function all($id = null,$message = null,$user = null){
        $response = array('sta' => 0,'msg' => 'All sent');

        $check = $this->checkMessage($id,$message);

        if($check['sta'] == 1){
            $response['sta'] = 1;
            $response['msg'] = 'No message found, sending cannot be performed';
        }else{
            $this->sendSMS($check['id'],$check['message'],$user);
            $this->sendEMail($check['id'],$check['message'],$user);
            $this->sendPushN($check['id'],$check['message'],$user);
        }

        return $response;
    }

    // Validate that there is a message to send
    public function checkMessage($id = null,$message = null){
        $response = array('id' => null,'message' => null,'id_category' => null,'sta' => 0);

        try{
            $notification = Notifications::findOrFail($id);

            $response['id'] = $id;
            $response['message'] = $notification->message;
            $response['id_category'] = $notification->id_category;
        }catch (ModelNotFoundException $exception) {
            if(!empty($message)){
                $response['message'] = $message;
            }else{
                $response['sta'] = 1;
            }
        }

        return $response;
    }

    // This will send same notification/message to SMS users
    // Can recieve notification id => id and his meessage or only a message without id that means is not from a notification, and an specific user or null to be sent to all users
    public function sendSMS($id = null,$message = null,$user = null){
        $response = array('sta' => 0,'msg' => 'All SMSs sent');
        $sms = array('response' => 'success');

        $check = $this->checkMessage($id,$message);
        if($check['sta'] == 1){
            $response['sta'] = 1;
            $response['msg'] = 'No message found, sending cannot be performed';
        }else{
            //
            if(empty($user) && !empty($check['id'])){
                $usersTo = Users::whereNotNull('phone_number')->whereRaw('FIND_IN_SET("1",channels) != 0 AND FIND_IN_SET("'.$check['id_category'].'",subscribed) != 0')->get();
            }elseif(!empty($user) && !empty($check['id'])){
                $usersTo = Users::whereNotNull('phone_number')->whereRaw('FIND_IN_SET("1",channels) != 0 AND FIND_IN_SET("'.$check['id_category'].'",subscribed) != 0')->where('id','=',$user)->get();
            }elseif(empty($user) && !empty($check['message'])){
                $usersTo = Users::whereNotNull('phone_number')->whereRaw('FIND_IN_SET("1",channels) != 0')->get();
            }elseif(!empty($user) && !empty($check['message'])){
                $usersTo = Users::whereNotNull('phone_number')->whereRaw('FIND_IN_SET("1",channels) != 0')->where('id','=',$user)->get();
            }

            if(!$usersTo->isEmpty()){
            // Here is code for an SMS sending function
                foreach($usersTo as $u){
                //     .......
                //     .......
                //     $sms->phone_number = $u->phone_number;
                //     $sms->message = $check['message'];
                //     .......
                //     .......
                // After sending the SMS recive response, i simulate that is always success
                    if($sms['response'] == 'success'){
                        // If the SMS is from notification will create DataBase History
                        if(!empty($check['id'])){
                            $notification_history = new NotificationsHistory();

                            $notification_history->id_notification = $check['id'];
                            $notification_history->id_user = $u->id;
                            $notification_history->id_category = $check['id_category'];
                            $notification_history->id_type = 1;

                            $notification_history->save();
                        }

                        // Every SMS register a log even if is not from a notification
                        $logData = [
                            "Type" => "SMS",
                            "Message Category" => !empty($check['id']) ? (Categories::where('id', '=', $check['id_category'])->first())->name : 'N/A',
                            "User" => $u->id.' | '.$u->name,
                            "Phone Number" => $u->phone_number,
                            "Date" => Date('d-M-Y G:i:s'),
                            "Message" => $check['message']
                        ];
                        \Log::channel('sms')->info('Notification sent '.json_encode($logData));
                    }
                }
            }
        }

        return $response;
    }

    // This will send same notification/message to EMail users
    // Can recieve notification id => id and his meessage or only a message without id that means is not from a notification, and an specific user or null to be sent to all users
    public function sendEmail($id = null,$message = null,$user = null){
        $response = array('sta' => 0,'msg' => 'All EMails sent');
        $email = array('response' => 'success');

        $check = $this->checkMessage($id,$message);
        if($check['sta'] == 1){
            $response['sta'] = 1;
            $response['msg'] = 'No message found, sending cannot be performed';
        }else{
            //
            if(empty($user) && !empty($check['id'])){
                $usersTo = Users::whereNotNull('email')->whereRaw('FIND_IN_SET("2",channels) != 0 AND FIND_IN_SET("'.$check['id_category'].'",subscribed) != 0')->get();
            }elseif(!empty($user) && !empty($check['id'])){
                $usersTo = Users::whereNotNull('email')->whereRaw('FIND_IN_SET("2",channels) != 0 AND FIND_IN_SET("'.$check['id_category'].'",subscribed) != 0')->where('id','=',$user)->get();
            }elseif(empty($user) && !empty($check['message'])){
                $usersTo = Users::whereNotNull('email')->whereRaw('FIND_IN_SET("2",channels) != 0')->get();
            }elseif(!empty($user) && !empty($check['message'])){
                $usersTo = Users::whereNotNull('email')->whereRaw('FIND_IN_SET("2",channels) != 0')->where('id','=',$user)->get();
            }

            if(!$usersTo->isEmpty()){
            // Here is code for an EMail sending function
                foreach($usersTo as $u){
                //     .......
                //     .......
                //     $email->address = $u->email;
                //     $email->body = $check['message'];
                //     .......
                //     .......
                // After sending the EMail recive response, i simulate that is always success
                    if($email['response'] == 'success'){
                        // If the EMail is from notification will create DataBase History
                        if(!empty($check['id'])){
                            $notification_history = new NotificationsHistory();

                            $notification_history->id_notification = $check['id'];
                            $notification_history->id_user = $u->id;
                            $notification_history->id_category = $check['id_category'];
                            $notification_history->id_type = 2;

                            $notification_history->save();
                        }

                        // Every Email register a log even if is not from a notification
                        $logData = [
                            "Type" => "EMail",
                            "Message Category" => !empty($check['id']) ? (Categories::where('id', '=', $check['id_category'])->first())->name : 'N/A',
                            "User" => $u->id.' | '.$u->name,
                            "Email" => $u->email,
                            "Date" => Date('d-M-Y G:i:s'),
                            "Message" => $check['message']
                        ];
                        \Log::channel('email')->info('Notification sent '.json_encode($logData));
                    }
                }
            }
        }

        return $response;
    }

    // This will send same notification/message to Push Notifications users
    // Can recieve notification id => id and his meessage or only a message without id that means is not from a notification, and an specific user or null to be sent to all users
    public function sendPushN($id = null,$message = null,$user = null){
        $response = array('sta' => 0,'msg' => 'All Push Notifications sent');
        $pushn = array('response' => 'success');

        $check = $this->checkMessage($id,$message);
        if($check['sta'] == 1){
            $response['sta'] = 1;
            $response['msg'] = 'No message found, sending cannot be performed';
        }else{
            //
            if(empty($user) && !empty($check['id'])){
                $usersTo = Users::whereNotNull('token')->whereRaw('FIND_IN_SET("3",channels) != 0 AND FIND_IN_SET("'.$check['id_category'].'",subscribed) != 0')->get();
            }elseif(!empty($user) && !empty($check['id'])){
                $usersTo = Users::whereNotNull('token')->whereRaw('FIND_IN_SET("3",channels) != 0 AND FIND_IN_SET("'.$check['id_category'].'",subscribed) != 0')->where('id','=',$user)->get();
            }elseif(empty($user) && !empty($check['message'])){
                $usersTo = Users::whereNotNull('token')->whereRaw('FIND_IN_SET("3",channels) != 0')->get();
            }elseif(!empty($user) && !empty($check['message'])){
                $usersTo = Users::whereNotNull('token')->whereRaw('FIND_IN_SET("3",channels) != 0')->where('id','=',$user)->get();
            }

            if(!$usersTo->isEmpty()){
            // Here is code for an Push Notification sending function
                foreach($usersTo as $u){
                //     .......
                //     .......
                //     $pushn->token = $u->token;
                //     $pushn->message = $check['message'];
                //     .......
                //     .......
                // After sending the Push Notifications recive response, i simulate that is always success
                    if($pushn['response'] == 'success'){
                        // If the Push Notification is from notification will create DataBase History
                        if(!empty($check['id'])){
                            $notification_history = new NotificationsHistory();

                            $notification_history->id_notification = $check['id'];
                            $notification_history->id_user = $u->id;
                            $notification_history->id_category = $check['id_category'];
                            $notification_history->id_type = 3;

                            $notification_history->save();
                        }

                        // Every Push Notification register a log even if is not from a notification
                        $logData = [
                            "Type" => "Push Notification",
                            "Message Category" => !empty($check['id']) ? (Categories::where('id', '=', $check['id_category'])->first())->name : 'N/A',
                            "User" => $u->id.' | '.$u->name,
                            "Token" => $u->token,
                            "Date" => Date('d-M-Y G:i:s'),
                            "Message" => $check['message']
                        ];
                        \Log::channel('pushn')->info('Notification sent '.json_encode($logData));
                    }
                }
            }
        }

        return $response;
    }
}
