<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use App\Jobs\SendFirebaseNotificationJob;
use App\Models\Notifications;

class FirebaseNotificationHelper
{
    private static $projectId = 'rtech-connect'; // Update with your Firebase project ID

    /**
     * Public entry point: queues notification sending.
     */
    public static function sendNotification(Notifications $notification): void
    {
        Log::info("📬 Sending notification immediately: {$notification->title} for users: {$notification->user_ids}");
        self::processNotification($notification); // No queueing, immediate send
    }


    /**
     * Called by the job to actually send the notification.
     */
    public static function processNotification(Notifications $notification): void
    {
        $accessToken = self::getAccessToken();
        Log::info("📬 Processing notification: {$notification->title} for users: {$notification->user_ids}");
        if (!$accessToken) {
            Log::error("❌ Unable to retrieve Firebase access token.");
            return;
        }
        Log::info("📬 Access token retrieved successfully.");
        Log::info('Type of notification: ' . $notification->type);

        match ($notification->type) {
            'all' => self::sendToAll($notification, $accessToken),
            'user', 'partner' => self::sendToTopic($notification->type, $notification, $accessToken),
            default => self::sendToSpecificUsers($notification, $accessToken),
        };
    }

    private static function getAccessToken(): ?string
    {
        $serviceAccountFile = public_path('key.json');
        if (!file_exists($serviceAccountFile)) {
            Log::error("❌ Service account file not found.");
            return null;
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountFile), true);
        if (!$serviceAccount) {
            Log::error("❌ Invalid service account JSON.");
            return null;
        }

        try {
            $jwt = self::generateJwt($serviceAccount, 'https://www.googleapis.com/auth/firebase.messaging');
            $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);
            return $response->json()['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error("❌ Failed to get Firebase access token: {$e->getMessage()}");
            return null;
        }
    }

    private static function generateJwt(array $serviceAccount, string $scope): string
    {
        $now = time();
        return JWT::encode([
            'iss' => $serviceAccount['client_email'],
            'sub' => $serviceAccount['client_email'],
            'aud' => $serviceAccount['token_uri'],
            'iat' => $now,
            'exp' => $now + 3600,
            'scope' => $scope,
        ], $serviceAccount['private_key'], 'RS256');
    }

    private static function sendToSpecificUsers(Notifications $notification, string $accessToken): void
    {
        $userIds = json_decode($notification->user_ids, true);
        if (empty($userIds)) {
            Log::warning("⚠️ No user IDs provided for notification.");
            return;
        }

        $tokens = User::whereIn('id', $userIds)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        if (empty($tokens)) {
            Log::warning("⚠️ No FCM tokens found for specified user IDs.");
            return;
        }

        foreach ($tokens as $token) {
            self::sendMessage($notification, $token, $accessToken);
        }
    }

    private static function sendToAll(Notifications $notification, string $accessToken): void
    {
        $tokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        foreach ($tokens as $token) {
            self::sendMessage($notification, $token, $accessToken);
        }

        self::sendToTopic('user', $notification, $accessToken);
        self::sendToTopic('partner', $notification, $accessToken);
    }

    private static function sendToTopic(string $topic, Notifications $notification, string $accessToken): void
    {
        $url = 'https://fcm.googleapis.com/v1/projects/' . self::$projectId . '/messages:send';
        $payload = [
            'message' => [
                'notification' => [
                    'title' => $notification->title,
                    'body'  => $notification->body,
                    'image' => $notification->image ? asset("storage/{$notification->image}") : null,
                ],
                'data' => [
                    'extra_data' => 'Additional data here',
                ],
                'topic' => $topic,
            ],
        ];

        try {
            $response = Http::withToken($accessToken)
                ->post($url, $payload);
            Log::info("✅ FCM topic '{$topic}' response: " . $response->body());
        } catch (\Exception $e) {
            Log::error("❌ Failed to send to topic '{$topic}': " . $e->getMessage());
        }
    }

    private static function sendMessage(Notifications $notification, string $token, string $accessToken): void
    {
        $url = 'https://fcm.googleapis.com/v1/projects/' . self::$projectId . '/messages:send';
        $payload = [
            'message' => [
                'notification' => [
                    'title' => $notification->title,
                    'body'  => $notification->body,
                    'image' => $notification->image ? asset("storage/{$notification->image}") : null,

                ],
                'data' => [
                    'extra_data' => 'Additional data here',
                    'route' => $notification->route ?? 'customer_list_screen',
                ],
                'token' => $token,
            ],
        ];

        try {
            $response = Http::withToken($accessToken)
                ->post($url, $payload);
            Log::info("✅ FCM token response: " . $response->body());
        } catch (\Exception $e) {
            Log::error("❌ Failed to send to token '{$token}': " . $e->getMessage());
        }
    }
}
