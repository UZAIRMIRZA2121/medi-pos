<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install - Database Configuration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Database Configuration</h2>
        <h3 class="text-lg font-semibold mb-4">Step 2: Database Details</h3>
        
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form action="{{ route('install.database.post') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700">Database Host</label>
                <input type="text" name="db_host" value="127.0.0.1" class="w-full border p-2 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Database Port</label>
                <input type="text" name="db_port" value="3306" class="w-full border p-2 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Database Name</label>
                <input type="text" name="db_database" class="w-full border p-2 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Database Username</label>
                <input type="text" name="db_username" class="w-full border p-2 rounded mt-1" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Database Password</label>
                <input type="password" name="db_password" class="w-full border p-2 rounded mt-1">
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('install.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">&larr; Back</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Test & Next</button>
            </div>
        </form>
    </div>
</body>
</html>
