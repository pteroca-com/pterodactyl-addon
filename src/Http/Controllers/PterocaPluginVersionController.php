<?php

namespace Pteroca\PterodactylAddon\Http\Controllers;

use Pterodactyl\Http\Controllers\Api\Application\ApplicationApiController;

class PterocaPluginVersionController extends ApplicationApiController
{
    /**
     * Current version of the PteroCA addon.
     */
    const VERSION = '0.1.2';
    
    /**
     * Get the current version of the PteroCA addon.
     */
    public function getVersion()
    {
        return response()->json([
            'name' => 'PteroCA Pterodactyl Addon',
            'version' => self::VERSION,
            'description' => 'This package brings an API interface to the application API in order to be able to create API tokens for a user',
            'installed' => true
        ]);
    }
}
