<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Http\Requests\UploadFeedbackImageRequest;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class FeedbackController extends Controller
{
    /**
     * List all customer feedback.
     */
    public function index(Request $request): InertiaResponse
    {
        $search = trim((string) $request->string('search'));

        $feedbacks = Feedback::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('admin/Feedbacks', [
            'feedbacks' => $feedbacks,
            'filters' => [
                'search' => $search,
            ],
            'stats' => [
                'total' => Feedback::count(),
                'featured' => Feedback::where('is_featured', true)->count(),
                'withImages' => Feedback::whereNotNull('image')->count(),
            ],
        ]);
    }

    /**
     * Show the feedback creation form.
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('admin/FeedbackForm', [
            'feedback' => null,
        ]);
    }

    /**
     * Store a new feedback.
     */
    public function store(StoreFeedbackRequest $request): RedirectResponse
    {
        Feedback::create($this->payload($request));

        return to_route('admin.feedbacks.index')
            ->with('success', 'Đã thêm phản hồi mới.');
    }

    /**
     * Show the feedback edit form.
     */
    public function edit(Feedback $feedback): InertiaResponse
    {
        return Inertia::render('admin/FeedbackForm', [
            'feedback' => $feedback,
        ]);
    }

    /**
     * Update an existing feedback.
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback): RedirectResponse
    {
        $feedback->update($this->payload($request));

        return to_route('admin.feedbacks.index')
            ->with('success', 'Đã cập nhật phản hồi.');
    }

    /**
     * Delete a feedback.
     */
    public function destroy(Feedback $feedback): RedirectResponse
    {
        $feedback->delete();

        return back()->with('success', 'Đã xoá phản hồi.');
    }

    /**
     * Upload an image and return its public path.
     */
    public function uploadImage(UploadFeedbackImageRequest $request): JsonResponse
    {
        $file = $request->file('image');
        $extension = strtolower($file->getClientOriginalExtension() ?: 'png');
        $filename = Str::random(40).'.'.$extension;

        Storage::disk('public')->putFileAs('feedbacks', $file, $filename);

        return response()->json([
            'message' => 'Đã tải ảnh lên thành công.',
            'path' => '/storage/feedbacks/'.$filename,
        ]);
    }

    /**
     * Build the persisted attributes from the validated request.
     *
     * @return array<string, mixed>
     */
    private function payload(StoreFeedbackRequest|UpdateFeedbackRequest $request): array
    {
        $validated = $request->validated();

        return [
            'name' => $validated['name'],
            'role' => $validated['role'] ?? null,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'image' => $validated['image'] ?? null,
            'photos' => $validated['photos'] ?? [],
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
        ];
    }
}
