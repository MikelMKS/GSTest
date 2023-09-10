<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class NotificationsTest extends TestCase
{
    public function test_newNotification(){
        // Call New Notification Form
        $form = $this->get(route('newNotification'));
        $form->assertStatus(200);

        // New notification with error (sending text category)
        $newWithError = $this->post(route('saveNotification'),['categories_sel' => 'Sports','message_tex' => 'This is a notification about Sports from Feature with Error']);
        $responseError = array('sta' => 1,'msg' => "THE FIELD 'CATEGORY' MUST BE NUMERIC");
        $newWithError->assertStatus(200)->assertJson($responseError);

        // New notification successfully, This will write the record to the database
        $newWithError = $this->post(route('saveNotification'),['categories_sel' => '1','message_tex' => 'This is a notification about Sports from Feature Successfully']);
        $responseSuccess = array('sta' => 0,'msg' => "");
        $newWithError->assertStatus(200)->assertJson($responseSuccess);
    }

    // This function will call the sending methods (SMS, email, push notification) separately, this will resend notifications
    public function test_sendNotificationExist(){
        // Send the notification with id 5 via SMS to all users (if id 5 it doesn't exist, it will send the written message, this will only make history in logs)
        $smsError = $this->post(route('sendSMS').'/5/Unique meessage if id 5 does not exist from SMS function');
        $responseSMSError = array('sta' => 0,'msg' => 'All SMSs sent');
        $smsError->assertStatus(200)->assertJson($responseSMSError);

        // Send the notification with id 3 via Email to all users (if id 3 it doesn't exist, it will send the written message, this will only make history in logs)
        $emailError = $this->post(route('sendEMail').'/3/Unique meessage if id 3 does not exist from Email function');
        $responseEmailError = array('sta' => 0,'msg' => 'All EMails sent');
        $emailError->assertStatus(200)->assertJson($responseEmailError);

        // Send the notification with id 1 via Push Notification to all users (if id 1 it doesn't exist, it will send the written message, this will only make history in logs)
        $pushnError = $this->post(route('sendPushN').'/1/Unique meessage if id 1 does not exist from Email function');
        $responsePushNError = array('sta' => 0,'msg' => 'All Push Notifications sent');
        $pushnError->assertStatus(200)->assertJson($responsePushNError);
    }
}
