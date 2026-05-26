<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->app->booted(function () {
            $this->configureStorageFromDatabase();
        });
    }

    protected function configureStorageFromDatabase(): void
    {
        try {
            $driver = Setting::getValue('storage_driver', 'local');

            if ($driver !== 'r2') {
                return;
            }

            $accountId = Setting::getValue('r2_account_id');
            $accessKey = Setting::getValue('r2_access_key');
            $secretKey = Setting::getValue('r2_secret_key');
            $bucket = Setting::getValue('r2_bucket');
            $publicUrl = Setting::getValue('r2_public_url');

            if (! $accountId || ! $accessKey || ! $secretKey || ! $bucket) {
                return;
            }

            $r2Config = [
                'driver' => 's3',
                'key' => $accessKey,
                'secret' => $secretKey,
                'region' => 'auto',
                'bucket' => $bucket,
                'url' => $publicUrl,
                'endpoint' => "https://{$accountId}.r2.cloudflarestorage.com",
                'use_path_style_endpoint' => false,
                'visibility' => 'public',
            ];

            // Override the 'public' disk to point to R2.
            // All FileUpload components use ->disk('public'), so uploads go to R2.
            // Storage::disk('public')->url() returns R2 CDN URLs automatically.
            config([
                'filesystems.disks.public' => $r2Config,
                'filesystems.disks.r2' => $r2Config,
                'filesystems.default' => 'r2',
            ]);
        } catch (\Throwable) {
            // Silently fail when DB is unavailable (during migrations, early boot, etc.)
        }
    }

    /**
     * Build a temporary R2 disk from explicit credentials (for connection testing).
     *
     * @param  array<string, string>  $credentials
     */
    public static function buildR2Disk(array $credentials): Filesystem
    {
        return Storage::build([
            'driver' => 's3',
            'key' => $credentials['access_key'],
            'secret' => $credentials['secret_key'],
            'region' => 'auto',
            'bucket' => $credentials['bucket'],
            'endpoint' => "https://{$credentials['account_id']}.r2.cloudflarestorage.com",
            'use_path_style_endpoint' => false,
        ]);
    }
}
