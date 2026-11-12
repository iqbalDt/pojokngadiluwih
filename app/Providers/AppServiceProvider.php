<?php

namespace App\Providers;

use App\Services\FirebaseService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\DevCommands;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FirebaseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('firebase', static function (Application $app, array $config): FirebaseUserProvider {
            return new FirebaseUserProvider($app->make(FirebaseService::class));
        });

        DevCommands::register(
            command: $this->aiServiceCommand(),
            name: 'ai-service',
        );
    }

    /**
     * Resolve the shell command to start the FastAPI AI service,
     * using the virtual environment bundled inside ai_service/.venv.
     */
    private function aiServiceCommand(): string
    {
        $isWindows = PHP_OS_FAMILY === 'Windows';

        $uvicorn = $isWindows
            ? base_path('ai_service/.venv/Scripts/uvicorn.exe')
            : base_path('ai_service/.venv/bin/uvicorn');

        return "\"{$uvicorn}\" app.main:app --host 0.0.0.0 --port 8001 --reload --app-dir \"".base_path('ai_service').'"';
    }
}
