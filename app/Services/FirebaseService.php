<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Psr\Log\LoggerInterface;



class FirebaseService
{
    protected $messaging;
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        // Use the path from .env; base_path() ensures it's relative to project root
        // $serviceAccountPath = base_path(env('FIREBASE_CREDENTIALS'));

        $serviceAccountPath = storage_path('firebase/firebase_credentials.json');
         
        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath);
        
        $this->messaging = $factory->createMessaging();
    }

    /**
     * Send a notification to a single device token
     *
     * @param string $fcmToken
     * @param string $title
     * @param string $body
     * @param array $data
     * @return mixed
     */
    public function sendToToken(string $fcmToken, string $title, string $body, array $data = [])
    {
        try {
            $notification = Notification::create($title, $body);
            
            $message = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification($notification)
                ->withData($data);

            return $this->messaging->send($message);
        } catch (\Throwable $e) {
            $this->logger->error('FCM sendToToken error: ' . $e->getMessage(), [
                'token' => $fcmToken,
                'title' => $title,
            ]);
            throw $e;
        }
    }

    /**
     * Send notifications to multiple tokens (simple sequential approach)
     *
     * @param array $fcmTokens
     * @param string $title
     * @param string $body
     * @param array $data
     * @return array
     */
    public function sendToMany(array $fcmTokens, string $title, string $body, array $data = []): array
    {
        $results = [];
        foreach ($fcmTokens as $token) {
            try {
                $results[] = $this->sendToToken($token, $title, $body, $data);
            } catch (\Throwable $e) {
                // Continue on error but log
                $results[] = ['error' => $e->getMessage(), 'token' => $token];
            }
        }

        return $results;
    }
}