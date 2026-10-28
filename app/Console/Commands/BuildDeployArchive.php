<?php

/**
 * Build the deploy archive for shared hosting.
 *
 * Usage: php artisan app:build-deploy-archive
 *
 * The archive only contains what a shared host needs, and every entry uses
 * forward slashes so it extracts correctly on Linux.
 */

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use ZipArchive;

#[Signature('app:build-deploy-archive {--output=rootbio-deploy.zip} {--vendor=vendor}')]
#[Description('Build a deployable archive for shared hosting')]
class BuildDeployArchive extends Command
{
    /**
     * Directories that are shipped to the host.
     *
     * @var list<string>
     */
    private const DIRECTORIES = [
        'app',
        'bootstrap',
        'config',
        'database/seeders',
        'database/migrations',
        'public',
        'resources',
        'routes',
        'storage',
    ];

    /**
     * Files that are shipped to the host.
     *
     * @var list<string>
     */
    private const FILES = [
        'artisan',
        'composer.json',
        'composer.lock',
        'package.json',
        'package-lock.json',
        'vite.config.ts',
        'tsconfig.json',
        'index.php',
        '.htaccess',
    ];

    /**
     * Empty folders the host needs so Laravel can write to them right away.
     *
     * @var list<string>
     */
    private const PLACEHOLDERS = [
        'storage/framework/cache/data/.gitignore',
        'storage/framework/cache/locks/.gitignore',
        'storage/framework/sessions/.gitignore',
        'storage/framework/testing/.gitignore',
        'storage/logs/.gitignore',
        'storage/app/private/.gitignore',
    ];

    /**
     * Paths whose content never ships to the host, but the folder itself is
     * still created because Laravel expects it to exist and be writable.
     *
     * @var list<string>
     */
    private const EXCLUDED = [
        'storage/framework/views/',
        'storage/framework/cache/data/',
        'storage/framework/cache/locks/',
        'storage/framework/sessions/',
        'storage/framework/testing/',
        'storage/logs/',
        'storage/app/private/',
        'storage/inertia-devtools/',
    ];

    /**
     * Individual files that never ship to the host.
     *
     * @var list<string>
     */
    private const EXCLUDED_FILES = [
        'bootstrap/cache/services.php',
        'bootstrap/cache/packages.php',
        'public/fonts-manifest.dev.json',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $outputPath = base_path((string) $this->option('output'));

        if (! extension_loaded('zip')) {
            $this->error('The "zip" PHP extension is required to build the archive.');

            return self::FAILURE;
        }

        if (file_exists($outputPath)) {
            unlink($outputPath);
        }

        $archive = new ZipArchive;

        if ($archive->open($outputPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->error("Unable to create {$outputPath}");

            return self::FAILURE;
        }

        foreach (self::FILES as $file) {
            $path = base_path($file);

            if (is_file($path)) {
                $archive->addFile($path, $file);
            }
        }

        foreach (self::DIRECTORIES as $directory) {
            $this->addDirectory($archive, $directory);
        }

        foreach (self::PLACEHOLDERS as $placeholder) {
            $path = base_path($placeholder);

            if (is_file($path)) {
                $archive->addFile($path, $placeholder);
            }
        }

        $vendorDirectory = (string) $this->option('vendor');

        if ($vendorDirectory !== '' && $vendorDirectory !== 'none') {
            $this->addDirectory($archive, $vendorDirectory);
        }

        $archive->close();

        $size = number_format(filesize($outputPath) / 1024 / 1024, 1);

        $this->info("Wrote {$outputPath} ({$size} MB)");

        return self::SUCCESS;
    }

    /**
     * Add a directory to the archive, skipping excluded paths.
     */
    private function addDirectory(ZipArchive $archive, string $relativeDirectory): void
    {
        $absolute = base_path($relativeDirectory);

        if (! is_dir($absolute)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($absolute, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        );

        /** @var SplFileInfo $item */
        foreach ($iterator as $item) {
            $relative = $relativeDirectory.'/'.str_replace('\\', '/', substr($item->getPathname(), strlen($absolute) + 1));

            if ($this->isExcluded($relative)) {
                continue;
            }

            if ($item->isFile()) {
                $archive->addFile($item->getPathname(), $relative);
            }
        }
    }

    /**
     * Determine whether a relative path must be left out of the archive.
     */
    private function isExcluded(string $relative): bool
    {
        foreach (self::EXCLUDED as $excluded) {
            if (str_starts_with($relative, $excluded)) {
                return true;
            }
        }

        return in_array($relative, self::EXCLUDED_FILES, true);
    }
}
