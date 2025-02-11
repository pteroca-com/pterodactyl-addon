<?php

namespace Pteroca\PterodactylAddon\Commands;

use Illuminate\Console\Command;
use Pterodactyl\Exceptions\PterodactylException;
use Pterodactyl\Traits\Commands\EnvironmentWriterTrait;

class GenerateSecretKey extends Command
{
    use EnvironmentWriterTrait;

    protected $description = 'Generate secret key for SSO';

    protected $signature = 'pteroca:generate-secret-key';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $key = str_random(64);
            $this->writeToEnvironment(['PTEROCA_SSO_SECRET' => $key]);

            $this->info(sprintf('Secret key generated successfully: %s', $key));
            $this->info('Copy the key and paste it in the PteroCA Panel settings.');
        } catch (PterodactylException $exception) {
            $this->error(sprintf(
                'An error occurred while generating the secret key: %s',
                $exception->getMessage()
            ));
            return 1;
        }

        return 0;
    }
}
