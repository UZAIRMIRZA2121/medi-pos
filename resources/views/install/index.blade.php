<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install - System Requirements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">System Installation</h2>
        <h3 class="text-lg font-semibold mb-4">Step 1: Welcome</h3>
        <p class="text-gray-600 mb-6">Welcome to the installation wizard. We'll set up your database, verify your purchase code, and configure your admin account.</p>
        
        <div class="flex justify-end mt-6">
            <a href="{{ route('install.database') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Next Step &rarr;</a>
        </div>
    </div>
</body>
</html>
