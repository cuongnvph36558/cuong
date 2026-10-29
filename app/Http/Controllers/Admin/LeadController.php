<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Support\HomeContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    /**
     * List all leads submitted from the landing page.
     */
    public function index(Request $request): InertiaResponse
    {
        $search = trim((string) $request->string('search'));
        $symptom = (string) $request->string('symptom');

        $leads = Lead::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($symptom !== '', fn ($query) => $query->whereJsonContains('symptoms', $symptom))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('admin/Leads', [
            'leads' => $leads,
            'filters' => [
                'search' => $search,
                'symptom' => $symptom,
            ],
            'stats' => [
                'total' => Lead::count(),
                'today' => Lead::whereDate('created_at', today())->count(),
                'week' => Lead::where('created_at', '>=', now()->subDays(7))->count(),
            ],
            'symptoms' => array_combine(
                HomeContent::symptomOptions(),
                array_map(
                    fn (string $symptom): int => Lead::whereJsonContains('symptoms', $symptom)->count(),
                    HomeContent::symptomOptions(),
                ),
            ),
        ]);
    }

    /**
     * Export the filtered leads as a CSV file.
     */
    public function export(Request $request): StreamedResponse
    {
        $search = trim((string) $request->string('search'));
        $symptom = (string) $request->string('symptom');

        $leads = Lead::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($symptom !== '', fn ($query) => $query->whereJsonContains('symptoms', $symptom))
            ->latest()
            ->get();

        $filename = 'leads-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($leads): void {
            $handle = fopen('php://output', 'wb');

            if ($handle === false) {
                return;
            }

            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Họ tên', 'Số điện thoại', 'Địa chỉ', 'Quy cách', 'Loại cây', 'Tình trạng', 'Mã giảm giá', 'Ghi chú', 'Thời gian']);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->name,
                    $lead->phone,
                    $lead->address,
                    $lead->variant,
                    $lead->plant_type,
                    implode(' | ', $lead->symptoms ?? []),
                    $lead->coupon_code,
                    $lead->note,
                    $lead->created_at?->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Delete a lead.
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return back()->with('success', 'Đã xoá dữ liệu khách hàng.');
    }
}
