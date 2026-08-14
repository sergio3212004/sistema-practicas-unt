<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoogleDriveController extends Controller
{
    private const RETURN_URL_SESSION_KEY = 'google_drive_return_url';

    public function __construct(
        private readonly GoogleDriveService $drive,
    ) {}

    public function redirectToGoogle(Request $request): RedirectResponse
    {
        $request->session()->put(
            self::RETURN_URL_SESSION_KEY,
            url()->previous(),
        );

        return redirect()->away($this->drive->authorizationUrl());
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $returnUrl = $request->session()->pull(
            self::RETURN_URL_SESSION_KEY,
            route('profile.edit'),
        );

        if (! $request->filled('code')) {
            return redirect($returnUrl)
                ->with('error', 'No se recibió autorización de Google Drive.');
        }

        if (! $this->drive->exchangeAuthorizationCode($request->string('code')->value())) {
            return redirect($returnUrl)
                ->with('error', 'Error al conectar con Google Drive.');
        }

        $request->session()->put('google_picker_ready', true);

        return redirect($returnUrl)
            ->with('success', 'Google Drive conectado exitosamente.')
            ->with('status', 'google-connected');
    }
}
