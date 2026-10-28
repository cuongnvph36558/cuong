<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class LeadController extends Controller
{
    /**
     * Store a lead submitted from the landing page.
     */
    public function store(StoreLeadRequest $request): JsonResponse|RedirectResponse
    {
        $lead = Lead::create([
            ...$request->validated(),
            'source' => $request->string('source')->toString() ?: 'landing',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Cảm ơn bác đã để lại thông tin. Kỹ sư nông nghiệp sẽ liên hệ trực tiếp để tư vấn và báo giá cho mình ạ!',
                'lead' => [
                    'id' => $lead->id,
                    'name' => $lead->name,
                ],
            ]);
        }

        return back()->with('success', 'Cảm ơn bác đã để lại thông tin!');
    }
}
