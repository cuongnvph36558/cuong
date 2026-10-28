<?php

use App\Console\Commands\BuildDeployArchive;

afterEach(function () {
    @unlink(base_path('.env.deploy'));
    @unlink(base_path('rootbio-deploy-test.zip'));
});

it('includes the environment file and the database dump in the archive', function () {
    file_put_contents(base_path('.env.deploy'), implode("\n", [
        'APP_ENV=production',
        'APP_DEBUG=false',
        'APP_KEY=base64:abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOP=',
        '',
    ]));

    $this->artisan('app:build-deploy-archive', [
        '--output' => 'rootbio-deploy-test.zip',
        '--vendor' => 'none',
    ])->assertSuccessful();

    $archive = new ZipArchive;
    $archive->open(base_path('rootbio-deploy-test.zip'));

    $names = [];

    for ($index = 0; $index < $archive->numFiles; $index++) {
        $names[] = $archive->getNameIndex($index);
    }

    $archive->close();

    expect($names)->toContain('.env.deploy')
        ->and($names)->toContain('database/production_import.sql')
        ->and($names)->toContain('index.php')
        ->and($names)->toContain('.htaccess')
        ->and($names)->toContain('storage/framework/views/.gitignore')
        ->and($names)->toContain('bootstrap/cache/.gitignore');
});

it('warns when the environment file is missing', function () {
    $this->artisan('app:build-deploy-archive', [
        '--output' => 'rootbio-deploy-test.zip',
        '--vendor' => 'none',
    ])->assertSuccessful();

    expect(is_file(base_path('rootbio-deploy-test.zip')))->toBeTrue();
});

it('accepts an environment file that uses windows line endings', function () {
    file_put_contents(base_path('.env.deploy'), implode("\r\n", [
        'APP_ENV=production',
        'APP_DEBUG=false',
        'APP_KEY=base64:abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOP=',
        '',
    ]));

    $this->artisan('app:build-deploy-archive', [
        '--output' => 'rootbio-deploy-test.zip',
        '--vendor' => 'none',
    ])->assertSuccessful();

    expect(is_file(base_path('rootbio-deploy-test.zip')))->toBeTrue();
});

it('fails when the environment file is not production ready', function () {
    file_put_contents(base_path('.env.deploy'), implode("\n", [
        'APP_ENV=local',
        'APP_DEBUG=true',
        'APP_KEY=base64:abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOP=',
        '',
    ]));

    $this->artisan('app:build-deploy-archive', [
        '--output' => 'rootbio-deploy-test.zip',
        '--vendor' => 'none',
    ])->assertFailed();

    expect(is_file(base_path('rootbio-deploy-test.zip')))->toBeFalse();
});

it('never ships a vendor directory when it is disabled', function () {
    $this->artisan('app:build-deploy-archive', [
        '--output' => 'rootbio-deploy-test.zip',
        '--vendor' => 'none',
    ])->assertSuccessful();

    $archive = new ZipArchive;
    $archive->open(base_path('rootbio-deploy-test.zip'));

    $hasVendor = false;

    for ($index = 0; $index < $archive->numFiles; $index++) {
        if (str_starts_with((string) $archive->getNameIndex($index), 'vendor/')) {
            $hasVendor = true;
            break;
        }
    }

    $archive->close();

    expect($hasVendor)->toBeFalse();
});

it('keeps the archive builder aware of the environment file name', function () {
    $reflection = new ReflectionClass(BuildDeployArchive::class);

    expect($reflection->hasConstant('ENVIRONMENT_FILE'))->toBeTrue()
        ->and($reflection->getConstant('ENVIRONMENT_FILE'))->toBe('.env.deploy');
});
