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

class SSOAuthorizationController extends ApplicationApiController
{
    private $jwtService;

    public function __construct(JwtService $jwtService)
    {
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

//        $auth = Container::getInstance()->make(AuthManager::class);
//        $auth->guard()->login($user, true);
//        $auth->guard('web')->login($user, true);
//        Event::dispatch(new DirectLogin($user, true));

        dd(Auth::check(), Auth::user());

        return redirect()->intended('/');
    }
}
