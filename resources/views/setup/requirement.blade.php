<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>System Requirements Check</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 p-5">

    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">System Requirements</h1>

        {{-- PHP Version --}}
        <div
            class="p-3 mb-2 rounded flex justify-between items-center {{ $requirements['php']['status'] ? 'bg-green-100 border border-green-300 text-green-800' : 'bg-red-100 border border-red-300 text-red-800' }}">
            <span>PHP Version (Required: {{ $requirements['php']['required'] }}, Current: {{ $requirements['php']['current'] }})</span>
            <span>{{ $requirements['php']['status'] ? '✅' : '❌' }}</span>
        </div>

        {{-- Extensions --}}
        @foreach ($requirements['extensions'] as $ext => $status)
            <div
                class="p-3 mb-2 rounded flex justify-between items-center {{ $status ? 'bg-green-100 border border-green-300 text-green-800' : 'bg-red-100 border border-red-300 text-red-800' }}">
                <span>Extension: {{ $ext }}</span>
                <span>{{ $status ? '✅ Installed' : '❌ Missing' }}</span>
            </div>
        @endforeach

        {{-- Database --}}
        <div
            class="p-3 mb-2 rounded flex justify-between items-center {{ $requirements['database']['status'] ? 'bg-green-100 border border-green-300 text-green-800' : 'bg-red-100 border border-red-300 text-red-800' }}">
            <span>Database Connection Temporary: ({{ $requirements['database']['driver'] }})</span>
            <span>{{ $requirements['database']['status'] ? '✅ Connected' : '❌ Failed' }}</span>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end mt-5 space-x-3">
            <form method="GET" action="{{ url()->current() }}">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    🔄 Retry Check
                </button>
            </form>

            <a href="{{ route('setup.index') }}"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                ➡ Next
            </a>
        </div>
    </div>

</body>

</html>
