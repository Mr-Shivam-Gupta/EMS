<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SetupController extends Controller
{
    public function index()
    {
        return view('setup.database');
    }

    public function saveDatabase(Request $request)
    {
        // dd($request);
        $request->validate([
            'DB_CONNECTION' => 'required|in:mysql,pgsql,sqlite,sqlsrv',
            'DB_HOST'       => 'required_if:DB_CONNECTION,mysql,pgsql,sqlsrv',
            'DB_PORT'       => 'required_if:DB_CONNECTION,mysql,pgsql,sqlsrv|numeric',
            'DB_DATABASE'   => 'required_unless:DB_CONNECTION,sqlite',
            'DB_USERNAME'   => 'required_if:DB_CONNECTION,mysql,pgsql,sqlsrv',
            'DB_PASSWORD'   => 'nullable',
        ], [
            'DB_CONNECTION.required' => 'Please select a database connection type.',
            'DB_CONNECTION.in'       => 'The selected database connection type is invalid.',
            'DB_HOST.required_if'    => 'The database host is required for MySQL, PostgreSQL, and SQL Server.',
            'DB_PORT.required_if'    => 'The database port is required for MySQL, PostgreSQL, and SQL Server.',
            'DB_PORT.numeric'        => 'The database port must be a number.',
            'DB_DATABASE.required_unless' => 'The database name is required unless you are using SQLite.',
            'DB_USERNAME.required_if' => 'The database username is required for MySQL, PostgreSQL, and SQL Server.',
        ]);

        foreach (
            $request->only([
                'DB_CONNECTION',
                'DB_HOST',
                'DB_PORT',
                'DB_DATABASE',
                'DB_USERNAME',
                'DB_PASSWORD'
            ]) as $key => $value
        ) {
            $this->setEnv($key, $value);
        }
        $this->setEnv('SESSION_DRIVER', 'file');
        Artisan::call('config:clear');
        try {
            DB::purge();
            config([

                'database.default' => $request->DB_CONNECTION,
                'database.connections.' . $request->DB_CONNECTION . '.host'     => $request->DB_HOST,
                'database.connections.' . $request->DB_CONNECTION . '.port'     => $request->DB_PORT,
                'database.connections.' . $request->DB_CONNECTION . '.database' => $request->DB_DATABASE,
                'database.connections.' . $request->DB_CONNECTION . '.username' => $request->DB_USERNAME,
                'database.connections.' . $request->DB_CONNECTION . '.password' => $request->DB_PASSWORD,
            ]);
            DB::reconnect();
            DB::connection()->getPdo();
            Artisan::call('migrate', ['--force' => true]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'DB_DATABASE' => 'Database connection failed: ' . $e->getMessage()
            ]);
        }
        return redirect('/');
    }

    private function setEnv($key, $value)
    {
        $path = base_path('.env');
        $env = file_get_contents($path);
        $escaped = preg_quote($key, '/');
        $value = trim($value);

        // Pattern to match both commented and uncommented versions of the key
        $pattern = "/^\s*#?\s*{$escaped}=.*$/m";

        if (preg_match($pattern, $env)) {
            // Replace existing (commented or not) with new value
            $env = preg_replace($pattern, "{$key}=\"{$value}\"", $env);
        } else {
            // Append if key not found
            $env .= PHP_EOL . "{$key}=\"{$value}\"";
        }

        file_put_contents($path, $env);
    }



    public function check()
    {
        $requirements = [
            'php' => [
                'required' => '8.1',
                'current' => PHP_VERSION,
                'status' => version_compare(PHP_VERSION, '8.2', '>=')
            ],
            'extensions' => [
                'pdo' => extension_loaded('pdo'),
                'mbstring' => extension_loaded('mbstring'),
                'openssl' => extension_loaded('openssl'),
                'tokenizer' => extension_loaded('tokenizer'),
                'xml' => extension_loaded('xml'),
                'ctype' => extension_loaded('ctype'),
                'json' => extension_loaded('json'),
                'bcmath' => extension_loaded('bcmath'),
                'fileinfo' => extension_loaded('fileinfo')
            ],
            'database' => [
                'driver' => config('database.default'),
                'status' => $this->testDatabase()
            ]
        ];

        return view('setup.requirement', compact('requirements'));
    }

    private function testDatabase()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
