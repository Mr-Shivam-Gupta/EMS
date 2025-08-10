<!DOCTYPE html>
<html>

<head>
    <title>Setup - Database Connection</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <form method="POST" action="{{ route('setup.db') }}"
        class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md space-y-6 border border-gray-100">
        @csrf
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800">Database Configuration</h2>
            <p class="text-gray-500 text-sm mt-1">Step 1: Setup your database connection</p>
        </div>

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                @foreach ($errors->all() as $error)
                    <div class="flex  text-red-600 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        {{-- DB Connection --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Database Type</label>
            <select name="DB_CONNECTION" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="mysql" {{ old('DB_CONNECTION') == 'mysql' ? 'selected' : '' }}>MySQL</option>
                <option value="pgsql" {{ old('DB_CONNECTION') == 'pgsql' ? 'selected' : '' }}>PostgreSQL</option>
                <option value="sqlite" {{ old('DB_CONNECTION') == 'sqlite' ? 'selected' : '' }}>SQLite</option>
                <option value="sqlsrv" {{ old('DB_CONNECTION') == 'sqlsrv' ? 'selected' : '' }}>SQL Server</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            {{-- DB Host --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Host</label>
                <input type="text" name="DB_HOST" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('DB_HOST', '127.0.0.1') }}" placeholder="localhost">
            </div>

            {{-- DB Port --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Port</label>
                <input type="number" name="DB_PORT" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('DB_PORT', '3306') }}" placeholder="3306">
            </div>
        </div>

        {{-- Database Name --}}
        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Database Name</label>
            <input type="text" name="DB_DATABASE" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('DB_DATABASE') }}" placeholder="my_database">
        </div>

        <div class="grid grid-cols-2 gap-4">
            {{-- DB Username --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="DB_USERNAME" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('DB_USERNAME') }}" placeholder="root">
            </div>

            {{-- DB Password --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="DB_PASSWORD" class="w-full border-gray-300 rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Save & Continue
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
</body>

</html>