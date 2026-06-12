<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function index()
    {
        return view('install.index');
    }

    public function database()
    {
        return view('install.database');
    }

    public function postDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
        ]);

        try {
            // Test connection
            $pdo = new \PDO("mysql:host=" . $request->db_host . ";port=" . $request->db_port . ";dbname=" . $request->db_database, $request->db_username, $request->db_password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            return back()->with('error', 'Could not connect to the database. Please check your configuration. Error: ' . $e->getMessage());
        }

        $this->setEnv('DB_HOST', $request->db_host);
        $this->setEnv('DB_PORT', $request->db_port);
        $this->setEnv('DB_DATABASE', $request->db_database);
        $this->setEnv('DB_USERNAME', $request->db_username);
        $this->setEnv('DB_PASSWORD', $request->db_password ?? '');

        return redirect()->route('install.purchase');
    }

    public function purchase()
    {
        return view('install.purchase');
    }

    public function postPurchase(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'purchase_key' => 'required',
        ]);

        // Mock validation: accept any key that starts with "valid-"
        if (str_starts_with($request->purchase_key, 'valid-')) {
            return redirect()->route('install.admin');
        }

        return back()->with('error', 'Invalid purchase key. For testing, use a key starting with "valid-".');
    }

    public function admin()
    {
        return view('install.admin');
    }

    public function postAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        } catch (\Exception $e) {
            // Ignore if already migrated
        }

        // Create admin user
        $user = \App\Models\User::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'type' => 'admin',
                'status' => 'active',
            ]
        );

        // Mark as installed
        file_put_contents(storage_path('installed'), 'installed successfully');

        return redirect()->route('install.finish');
    }

    public function finish()
    {
        return view('install.finish');
    }

    private function setEnv($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $value = '"' . trim($value) . '"';
            $env = file_get_contents($path);

            $env = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', $key . '=' . $value, $env);

            file_put_contents($path, $env);
        }
    }
}
