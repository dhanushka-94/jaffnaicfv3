<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDownloadLog;
use App\Models\ApplicationSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationDownloadController extends Controller
{
    public function __invoke(): StreamedResponse|RedirectResponse
    {
        $settings = ApplicationSetting::query()->first();

        abort_unless(
            $settings?->application_open && filled($settings->application_pdf_path),
            404
        );

        abort_unless(
            Storage::disk('public')->exists($settings->application_pdf_path),
            404
        );

        ApplicationDownloadLog::record();

        $filename = basename($settings->application_pdf_path);

        return Storage::disk('public')->download(
            $settings->application_pdf_path,
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
}
