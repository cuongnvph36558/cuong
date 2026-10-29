<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;

/**
 * Serves the newest registrations used by the social proof notifications
 * shown on the landing page.
 */
class RecentRegistrationController extends Controller
{
    /**
     * Return the most recent registrations for the landing page notifications.
     */
    public function __invoke(): JsonResponse
    {
        $registrations = Lead::query()
            ->latest()
            ->limit(20)
            ->get(['id', 'name', 'address', 'variant', 'created_at'])
            ->map(fn (Lead $lead): array => [
                'id' => $lead->id,
                'name' => $this->maskName((string) $lead->name),
                'region' => $this->region((string) ($lead->address ?? '')),
                'package' => (string) ($lead->variant ?? ''),
                'time' => $lead->created_at?->diffForHumans() ?? '',
            ]);

        return response()->json([
            'registrations' => $registrations,
        ]);
    }

    /**
     * Hide part of the name so the notification stays believable.
     */
    private function maskName(string $name): string
    {
        $parts = preg_split('/\s+/u', trim($name)) ?: [];
        $first = $parts[0] ?? '';
        $last = count($parts) > 1 ? (string) end($parts) : '';

        if ($first === '') {
            return 'Khách hàng';
        }

        $masked = mb_substr($first, 0, 1).'.';

        if ($last !== '') {
            $masked .= ' '.mb_substr($last, 0, 1).'.';
        }

        return $masked;
    }

    /**
     * Normalize the address into a short region label.
     */
    private function region(string $address): string
    {
        $address = trim($address);

        if ($address === '') {
            return '';
        }

        $parts = preg_split('/[,;\-–]/u', $address) ?: [];
        $region = trim((string) ($parts[0] ?? ''));

        return mb_substr($region, 0, 24);
    }
}
