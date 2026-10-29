<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:export-production-sql {--output=database/production_import.sql}')]
#[Description('Export the schema and data of the local database as a MySQL/MariaDB dump')]
class ExportProductionSql extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $outputPath = base_path((string) $this->option('output'));

        $quote = fn (mixed $value): string => $value === null
            ? 'NULL'
            : "'".str_replace(['\\', "'"], ['\\\\', "\\'"], (string) $value)."'";

        $insertRows = function (string $table, array $rows, array $columns) use ($quote): string {
            if ($rows === []) {
                return '';
            }

            $values = array_map(function (array $row) use ($columns, $quote): string {
                $cells = array_map(function (string $column) use ($row, $quote): string {
                    $value = $row[$column] ?? null;

                    if (is_array($value)) {
                        $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                    }

                    return $quote($value);
                }, $columns);

                return '  ('.implode(', ', $cells).')';
            }, $rows);

            return "INSERT INTO `{$table}` (".implode(', ', array_map(fn (string $c): string => "`{$c}`", $columns)).") VALUES\n"
                .implode(",\n", $values).";\n\n";
        };

        $sql = "-- ============================================================\n";
        $sql .= "-- ELICPO - schema + data for MySQL / MariaDB\n";
        $sql .= '-- Generated: '.now()->format('Y-m-d H:i:s')."\n";
        $sql .= "-- Import this file into phpMyAdmin to get a ready-to-use database.\n";
        $sql .= "-- ============================================================\n\n";
        $sql .= "SET NAMES utf8mb4;\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $schema = file_get_contents(base_path('database/schema_mysql.sql'));

        if ($schema !== false) {
            $sql .= "-- ---------- SCHEMA ----------\n";
            $sql .= $schema."\n\n";
        }

        $sql .= "-- ---------- DATA ----------\n\n";

        $sql .= $insertRows('migrations', DB::table('migrations')->orderBy('id')->get()
            ->map(fn ($row) => ['id' => $row->id, 'migration' => $row->migration, 'batch' => $row->batch])
            ->all(), ['id', 'migration', 'batch']);

        $sql .= $insertRows('users', User::query()->orderBy('id')->get()->map(fn (User $user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at?->format('Y-m-d H:i:s'),
            'password' => $user->password,
            'remember_token' => $user->remember_token,
            'created_at' => $user->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $user->updated_at?->format('Y-m-d H:i:s'),
            'two_factor_secret' => $user->two_factor_secret,
            'two_factor_recovery_codes' => $user->two_factor_recovery_codes,
            'two_factor_confirmed_at' => $user->two_factor_confirmed_at?->format('Y-m-d H:i:s'),
            'is_admin' => (int) $user->is_admin,
        ])->all(), [
            'id', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at',
            'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'is_admin',
        ]);

        $sql .= $insertRows('leads', Lead::query()->orderBy('id')->get()->map(fn (Lead $lead) => [
            'id' => $lead->id,
            'name' => $lead->name,
            'phone' => $lead->phone,
            'address' => $lead->address,
            'coupon_code' => $lead->coupon_code,
            'variant' => $lead->variant,
            'plant_type' => $lead->plant_type,
            'symptoms' => $lead->symptoms,
            'note' => $lead->note,
            'source' => $lead->source,
            'created_at' => $lead->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $lead->updated_at?->format('Y-m-d H:i:s'),
        ])->all(), [
            'id', 'name', 'phone', 'address', 'coupon_code', 'variant', 'plant_type', 'symptoms', 'note', 'source', 'created_at', 'updated_at',
        ]);

        $sql .= $insertRows('site_settings', SiteSetting::query()->orderBy('id')->get()->map(fn (SiteSetting $setting) => [
            'id' => $setting->id,
            'key' => $setting->key,
            'value' => $setting->value,
            'created_at' => $setting->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $setting->updated_at?->format('Y-m-d H:i:s'),
        ])->all(), ['id', 'key', 'value', 'created_at', 'updated_at']);

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($outputPath, $sql);

        $this->info(sprintf('Wrote %s (%s bytes)', $outputPath, number_format(strlen($sql))));

        return self::SUCCESS;
    }
}
