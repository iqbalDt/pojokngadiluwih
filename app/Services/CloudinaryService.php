<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CloudinaryService
{
    /**
     * Create a new CloudinaryService instance.
     */
    public function __construct(
        protected ?string $cloudName = null,
        protected ?string $apiKey = null,
        protected ?string $apiSecret = null,
    ) {
        $this->cloudName = $this->cloudName ?: (string) config('services.cloudinary.cloud_name');
        $this->apiKey = $this->apiKey ?: (string) config('services.cloudinary.api_key');
        $this->apiSecret = $this->apiSecret ?: (string) config('services.cloudinary.api_secret');
    }

    /**
     * Determine if Cloudinary credentials are fully configured.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->cloudName) && ! empty($this->apiKey) && ! empty($this->apiSecret);
    }

    /**
     * Upload an image to Cloudinary (or fallback to local disk storage if unconfigured or error).
     *
     * @param  UploadedFile  $file
     * @param  string  $folder
     * @return string Cloudinary secure_url OR local relative path
     */
    public function upload(UploadedFile $file, string $folder = 'pojokngadiluwih'): string
    {
        if (! $this->isConfigured()) {
            return $file->store($folder, 'public');
        }

        try {
            $timestamp = time();
            $params = [
                'folder' => $folder,
                'timestamp' => $timestamp,
            ];

            // Cloudinary signature generation:
            // 1. Sort parameters alphabetically by key
            ksort($params);

            // 2. Build string to sign: key=value&key2=value2 . api_secret
            $pairs = [];
            foreach ($params as $key => $value) {
                $pairs[] = "{$key}={$value}";
            }
            $stringToSign = implode('&', $pairs).$this->apiSecret;
            $signature = sha1($stringToSign);

            $endpoint = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";

            $fileHandle = fopen($file->getRealPath(), 'r');
            if ($fileHandle === false) {
                Log::warning('Cloudinary upload unable to open file handle, falling back to local storage.');

                return $file->store($folder, 'public');
            }

            $response = Http::timeout(30)
                ->attach('file', $fileHandle, $file->getClientOriginalName())
                ->post($endpoint, [
                    'api_key' => $this->apiKey,
                    'timestamp' => (string) $timestamp,
                    'folder' => $folder,
                    'signature' => $signature,
                ]);

            if (is_resource($fileHandle)) {
                fclose($fileHandle);
            }

            if ($response->successful()) {
                $secureUrl = $response->json('secure_url');
                if (! empty($secureUrl)) {
                    return (string) $secureUrl;
                }
            }

            Log::warning('Cloudinary upload returned unexpected response, falling back to local disk: '.$response->body());
        } catch (Throwable $e) {
            Log::error('Cloudinary upload exception, falling back to local disk: '.$e->getMessage());
        }

        return $file->store($folder, 'public');
    }

    /**
     * Delete an image from storage (Cloudinary or local public disk).
     */
    public function delete(?string $pathOrUrl): bool
    {
        if (empty($pathOrUrl)) {
            return false;
        }

        // Local disk path
        if (! str_starts_with($pathOrUrl, 'http://') && ! str_starts_with($pathOrUrl, 'https://')) {
            try {
                if (Storage::disk('public')->exists($pathOrUrl)) {
                    return Storage::disk('public')->delete($pathOrUrl);
                }
            } catch (Throwable) {
                return false;
            }

            return false;
        }

        // Cloudinary URL
        if ($this->isConfigured() && str_contains($pathOrUrl, 'res.cloudinary.com')) {
            try {
                $publicId = $this->extractPublicId($pathOrUrl);
                if ($publicId) {
                    $timestamp = time();
                    $params = [
                        'public_id' => $publicId,
                        'timestamp' => $timestamp,
                    ];
                    ksort($params);

                    $pairs = [];
                    foreach ($params as $key => $value) {
                        $pairs[] = "{$key}={$value}";
                    }
                    $stringToSign = implode('&', $pairs).$this->apiSecret;
                    $signature = sha1($stringToSign);

                    $endpoint = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy";

                    $response = Http::timeout(15)->post($endpoint, [
                        'public_id' => $publicId,
                        'api_key' => $this->apiKey,
                        'timestamp' => (string) $timestamp,
                        'signature' => $signature,
                    ]);

                    return $response->successful();
                }
            } catch (Throwable $e) {
                Log::warning('Cloudinary delete exception: '.$e->getMessage());
            }
        }

        return false;
    }

    /**
     * Extract public ID from Cloudinary URL (e.g. "news/abc123xyz").
     */
    public function extractPublicId(string $url): ?string
    {
        // Example: https://res.cloudinary.com/wivrixqi/image/upload/v1731147000/news/sample_id.jpg
        $pattern = '#/image/upload/(?:v\d+/)?([^.]+)(?:\.[a-zA-Z0-9]+)?$#';
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

