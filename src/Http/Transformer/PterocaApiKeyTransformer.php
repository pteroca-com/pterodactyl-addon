<?php

namespace Pteroca\PterodactylAddon\Http\Transformer;

use Pterodactyl\Transformers\Api\Client\ApiKeyTransformer;
use Pterodactyl\Models\ApiKey;

class PterocaApiKeyTransformer extends ApiKeyTransformer
{
    public function transform(ApiKey $model): array
    {
        return [
            'identifier' => $model->identifier,
            'description' => $model->memo,
            'allowed_ips' => $model->allowed_ips,
            'last_used_at' => $model->last_used_at ? $model->last_used_at->toAtomString() : null,
            'created_at' => $model->created_at->toAtomString(),
            'token' => $model->token,
        ];
    }
}
