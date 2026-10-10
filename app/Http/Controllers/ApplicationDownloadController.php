<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDownloadLog;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApplicationDownloadController extends Controller
{
    public function __invoke(Request $request): BinaryFileResponse
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

        $path = Storage::disk('public')->path($settings->application_pdf_path);
        $filename = $this->downloadFilename($settings, $path);
        $headers = [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'no-store, private',
            'Pragma' => 'no-cache',
        ];

        if ($request->boolean('save')) {
            return response()->download($path, $filename, $headers);
        }

        ApplicationDownloadLog::record();

        return response()
            ->file($path, $headers)
            ->setContentDisposition('inline', $filename);
    }

    private function downloadFilename(ApplicationSetting $settings, string $path): string
    {
        $name = $this->cleanFilename($settings->application_pdf_original_name)
            ?? $this->cleanFilename($this->pdfTitle($path))
            ?? basename($settings->application_pdf_path);

        if (! str_ends_with(strtolower($name), '.pdf')) {
            $name .= '.pdf';
        }

        return $name;
    }

    private function cleanFilename(?string $name): ?string
    {
        $name = trim(str_replace(["\\", "/", "\0"], '', (string) $name));
        $name = preg_replace('/[\r\n"]+/', '', $name) ?? '';

        return $name !== '' ? $name : null;
    }

    private function pdfTitle(string $path): ?string
    {
        $size = filesize($path);
        $raw = file_get_contents($path, false, null, $size > 65536 ? $size - 65536 : 0);

        if (! is_string($raw) || ! preg_match_all('/\/Title\s*\((.*?)\)/s', $raw, $matches) || $matches[1] === []) {
            return null;
        }

        return stripcslashes((string) end($matches[1]));
    }
}
