<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Support\Facades\Session;

class GoogleDriveService
{
    private const TOKEN_SESSION_KEY = 'google_drive_token';

    public function authorizationUrl(): string
    {
        return $this->client()->createAuthUrl();
    }

    public function exchangeAuthorizationCode(string $code): bool
    {
        $token = $this->client(withStoredToken: false)
            ->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            return false;
        }

        Session::put(self::TOKEN_SESSION_KEY, $token);

        return true;
    }

    public function isConnected(): bool
    {
        if (! Session::has(self::TOKEN_SESSION_KEY)) {
            return false;
        }

        return ! $this->client()->isAccessTokenExpired();
    }

    /**
     * @return array{type: string, file_id: string, file_name: string, web_view_link: ?string, mime_type: ?string}
     */
    public function fileMetadata(string $fileId, string $fallbackName): array
    {
        $file = (new GoogleDrive($this->client()))->files->get($fileId, [
            'fields' => 'id, name, mimeType, webViewLink',
        ]);

        return [
            'type' => 'drive',
            'file_id' => $file->id,
            'file_name' => $file->name ?: $fallbackName,
            'web_view_link' => $file->webViewLink,
            'mime_type' => $file->mimeType,
        ];
    }

    private function client(bool $withStoredToken = true): GoogleClient
    {
        $client = new GoogleClient;
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setScopes([
            GoogleDrive::DRIVE_READONLY,
            GoogleDrive::DRIVE_METADATA_READONLY,
        ]);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        if (! $withStoredToken || ! Session::has(self::TOKEN_SESSION_KEY)) {
            return $client;
        }

        $client->setAccessToken(Session::get(self::TOKEN_SESSION_KEY));

        if ($client->isAccessTokenExpired() && $client->getRefreshToken()) {
            $refreshToken = $client->getRefreshToken();
            $token = $client->fetchAccessTokenWithRefreshToken($refreshToken);
            $token['refresh_token'] ??= $refreshToken;
            Session::put(self::TOKEN_SESSION_KEY, $token);
        }

        return $client;
    }
}
