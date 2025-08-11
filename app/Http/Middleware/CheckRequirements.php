<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRequirements
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $errors = [];

        // PHP version
        if (version_compare(PHP_VERSION, '8.2.0', '<')) {
            $errors[] = "PHP 8.2 or higher is required. Current: " . PHP_VERSION;
        }

        // Required extensions
        $extensions = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'];
        foreach ($extensions as $ext) {
            if (!extension_loaded($ext)) {
                $errors[] = "Missing PHP extension: $ext";
            }
        }

        // Writable folders
        $paths = [storage_path(), base_path('bootstrap/cache')];
        foreach ($paths as $path) {
            if (!is_writable($path)) {
                $errors[] = "Folder not writable: $path";
            }
        }
        // If any errors, redirect to setup
        if ($errors && !$request->is('setup/*')) {
            return redirect()->route('setup.requirements')->with('errors', $errors);
        }

        return $next($request);
    }
}
