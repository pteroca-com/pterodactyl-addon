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
            'version' => self::VERSION,
        ]);
    }
}
