<?php

namespace App\Providers;

use App\Models\Client;
use BeyondCode\LaravelWebSockets\Apps\AppProvider;
use BeyondCode\LaravelWebSockets\Apps\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ConfigAppProvider implements AppProvider
{
    protected $apps;

    public function __construct()
    {
        $this->apps = Client::all()->map(function($client) {
            return [
                'id' => $client->key,
                'name' => $client->name,
                'host' => Str::after($client->host, '//'),
                'key' => $client->key,
                'secret' => $client->secret,
                'capacity' => null,
                'enable_client_messages' => false,
                'enable_statistics' => false,
                'allow_origins' => []
            ];
        });
    }

    public function all(): array
    {
        return $this->apps
            ->map(function (array $appAttributes) {
                return $this->instanciate($appAttributes);
            })
            ->toArray();
    }

    public function findById($appId): ?App
    {
        $appAttributes = $this
            ->apps
            ->firstWhere('id', $appId);

        return $this->instanciate($appAttributes);
    }

    public function findByKey(string $appKey): ?App
    {
        $appAttributes = $this
            ->apps
            ->firstWhere('key', $appKey);

        return $this->instanciate($appAttributes);
    }

    public function findBySecret(string $appSecret): ?App
    {
        $appAttributes = $this
            ->apps
            ->firstWhere('secret', $appSecret);

        return $this->instanciate($appAttributes);
    }

    protected function instanciate(?array $appAttributes): ?App
    {
        if (! $appAttributes) {
            return null;
        }

        $app = new App(
            $appAttributes['id'],
            $appAttributes['key'],
            $appAttributes['secret']
        );

        if (isset($appAttributes['name'])) {
            $app->setName($appAttributes['name']);
        }

        if (isset($appAttributes['host'])) {
            $app->setHost($appAttributes['host']);
        }

        if (isset($appAttributes['path'])) {
            $app->setPath($appAttributes['path']);
        }

        $app
            ->enableClientMessages($appAttributes['enable_client_messages'])
            ->enableStatistics($appAttributes['enable_statistics'])
            ->setCapacity($appAttributes['capacity'] ?? null);

        return $app;
    }
}
