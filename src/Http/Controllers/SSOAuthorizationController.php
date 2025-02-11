<?php

namespace Pteroca\PterodactylAddon\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Pteroca\PterodactylAddon\Http\Requests\SSOLoginRequest;
use Pteroca\PterodactylAddon\Services\JwtService;
use Pterodactyl\Http\Controllers\Api\Application\ApplicationApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\CarbonImmutable;
use Pterodactyl\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Event;
use Pterodactyl\Events\Auth\DirectLogin;
use Pterodactyl\Http\Controllers\Auth\AbstractLoginController;

class SSOAuthorizationController extends AbstractLoginController
{
    private $jwtService;

    public function __construct(JwtService $jwtService)
    {
        parent::__construct();
        $this->jwtService = $jwtService;
    }

    public function index(Request $request)
    {
        $token = $request->post('pteroca_sso_token');
        $decodedToken = $this->jwtService->decodeToken($token);

        if (empty($decodedToken) || empty($decodedToken->user->id)) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $pterodactylUserId = $decodedToken->user->id;
        $user = User::findOrFail($pterodactylUserId);
        if (empty($user)) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if ($user['2fa']) {
            return response()->json(['error' => 'Cannot login with 2FA enabled'], 403);
        }

        Auth::login($user);

        $request->session()->put('auth_confirmation_token', [
            'user_id' => $user->id,
            'token_value' => $token = Str::random(64),
            'expires_at' => CarbonImmutable::now()->addMinutes(5),
        ]);

        //Event::dispatch(new DirectLogin($user, Container::getInstance()->make(AuthManager::class)));
        $request->session()->regenerate();

        return $this->sendLoginResponse($user, $request);

        dd(Auth::check(), Auth::user());

        return redirect()->intended('/');
    }
}
