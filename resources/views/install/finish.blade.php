<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install - Complete</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg text-center">
        <h2 class="text-3xl font-bold mb-4 text-green-600">Installation Complete!</h2>
        <p class="text-gray-600 mb-8">The system has been successfully installed and configured. You can now log in and start using your application.</p>
        
        <a href="{{ url('/login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">Go to Login</a>
    </div>
</body>
</html>
