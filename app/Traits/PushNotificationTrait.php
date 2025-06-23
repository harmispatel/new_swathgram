<?php

namespace App\Traits;

use App\Models\FirebaseNotification;
use Illuminate\Support\Facades\Http;
use Google\Auth\ApplicationDefaultCredentials;

trait PushNotificationTrait
{
    /**
     * Send a push notification.
     *
     * @param string $token The recipient device token.
     * @param string $title The notification title.
     * @param string $body The notification body.
     * @param array $data Additional data payload (optional).
     * @return array Response from FCM or error information.
     */

    // public function sendNotification($token, $title, $body, $data = [])
    // {
    //     $fcmUrl = 'https://fcm.googleapis.com/v1/projects/swasthgram-23530/messages:send';
      
    //     $notification = [
    //         'token' => $token,
    //         'notification' => [
    //             'title' => $title,
    //             'body' => $body,
    //         ],
    //         'data' => $data
    //     ];

    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $this->getAccessToken(),
    //         'Content-Type' => 'application/json',
    //     ])->post($fcmUrl, ['message' => $notification]);
        

    //     if ($response->successful()) {
    //         return [
    //             'success' => true,
    //             'message' => 'Notification sent successfully.',
    //             'data' => $response->json(),
    //         ];
    //     }

    //     $firebase_notification = new FirebaseNotification();
    //     $firebase_notification->title = $data['title'];
    //     $firebase_notification->text = $data['text'];
    //     $firebase_notification->donation_type = $data['donation_type'];
    //     $firebase_notification->receiver_id = $data['receiver_id'];
    //     $firebase_notification->sender_id = $data['sender_id'];
    //     $firebase_notification->save();
        
    //     return [
    //         'success' => false,
    //         'error' => $response->json() ?? $response->body(),
    //     ];
    // }
    
    public function sendNotification($token, $title, $body, $data = [])
    {
        $fcmUrl = 'https://fcm.googleapis.com/v1/projects/swasthgram-23530/messages:send';
      
        $notification = [
            'token' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => array_map('strval', $data)
        ];
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ])->post($fcmUrl, ['message' => $notification]);
        
        if ($response->successful()) {
            return [
                'success' => true,
                'message' => 'Notification sent successfully.',
                'data' => $response->json(),
            ];
        }
    
        // Save the notification regardless of success
        $firebase_notification = new FirebaseNotification();
        $firebase_notification->title = $data['title'];
        $firebase_notification->text = $data['text'];
        $firebase_notification->donation_type = $data['donation_type'];
        $firebase_notification->receiver_id = $data['receiver_id'];
        $firebase_notification->sender_id = $data['sender_id'];
        $firebase_notification->save();
        
        return [
            'success' => false,
            'error' => $response->json() ?? $response->body(),
        ];
    }

    
    private function getAccessToken(){
        $keyPath = 'swasthgram-23530-firebase-adminsdk-fbsvc-8365b2b138.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $keyPath);

        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $cridentials = ApplicationDefaultCredentials::getCredentials($scopes);
        $token = $cridentials->fetchAuthToken();
        return $token['access_token'] ?? null;
    }
}