<?php

namespace Modules\RestApi\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;
use Modules\RestApi\Entities\FcmSetting;

class FcmPushService
{
    /**
     * @throws \RuntimeException 
     */
    protected function messagingFor(string $appType)
    {
        $setting = FcmSetting::current();

        if (!$setting->isEnabledFor($appType)) {
            throw new \RuntimeException(__('applicationintegration::messages.fcmNotEnabled'));
        }

        $path = $setting->credentialsPathFor($appType);

        if (!$path || !file_exists($path)) {
            throw new \RuntimeException(__('applicationintegration::messages.fcmCredentialsMissing'));
        }

        $factory = (new Factory())->withServiceAccount($path);

        return $factory->createMessaging();
    }

    /**
     *
     * @return array{success: bool, message: string}
     */
    public function sendToToken(string $appType, string $token, string $title, string $body, array $data = []): array
    {
        try {
            $messaging = $this->messagingFor($appType);
            
            // Updated syntax using CloudMessage::new()->withToken()
            $message = CloudMessage::new()
                ->withToken($token)
                ->withNotification(FcmNotification::create($title, $body))
                ->withData(array_map('strval', $data));

            $messaging->send($message);
            return ['success' => true, 'message' => __('applicationintegration::messages.pushSentSuccessfully')];
        } catch (\Throwable $e) {
            logger()->error('FCM push failed', ['app_type' => $appType, 'error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     *
     * @return array{success: bool, message: string}
     */
    public function sendTestToLatestToken(string $appType, string $platform, string $title, string $body): array
    {
        $token = \Modules\RestApi\Entities\DeviceToken::where('app_type', $appType)
            ->where('platform', $platform)
            ->latest('updated_at')
            ->value('token');

        if (!$token) {
            return ['success' => false, 'message' => __('applicationintegration::messages.noDeviceTokenFound')];
        }

        return $this->sendToToken($appType, $token, $title, $body, ['type' => 'test']);
    }
}