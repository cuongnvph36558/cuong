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
                'message' => 'Cảm ơn bạn đã đăng ký! Chuyên gia nông nghiệp sẽ gọi cho bạn trong thời gian sớm nhất.',
                'lead' => [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'variant' => $lead->variant,
                ],
            ]);
        }

        return back()->with('success', 'Cảm ơn bạn đã đăng ký!');
    }
}
