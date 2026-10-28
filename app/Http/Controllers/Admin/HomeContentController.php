<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHomeContentRequest;
use App\Http\Requests\UploadHomeContentImageRequest;
use App\Support\HomeContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class HomeContentController extends Controller
{
    /**
     * Show the landing page content editor.
     */
    public function edit(): InertiaResponse
    {
        return Inertia::render('admin/HomeContent', [
            'schema' => HomeContent::schema(),
            'content' => HomeContent::get(),
        ]);
    }

    /**
     * Persist the landing page content.
     */
    public function update(UpdateHomeContentRequest $request): JsonResponse
    {
        HomeContent::store($request->sanitizedContent());

        return response()->json([
            'message' => 'Đã cập nhật nội dung trang chủ.',
            'content' => HomeContent::get(),
        ]);
    }

    /**
     * Restore the default landing page content.
     */
    public function reset(): JsonResponse
    {
        HomeContent::store(HomeContent::defaults());

        return response()->json([
            'message' => 'Đã khôi phục nội dung mặc định.',
            'content' => HomeContent::get(),
        ]);
    }

    /**
     * Upload an image and return its public path.
     */
    public function uploadImage(UploadHomeContentImageRequest $request): JsonResponse
    {
        $file = $request->file('image');
        $extension = strtolower($file->getClientOriginalExtension() ?: 'png');
        $filename = Str::random(40).'.'.$extension;

        Storage::disk('public')->putFileAs('home-content', $file, $filename);

        return response()->json([
            'message' => 'Đã tải ảnh lên thành công.',
            'path' => '/storage/home-content/'.$filename,
        ]);
    }
}
