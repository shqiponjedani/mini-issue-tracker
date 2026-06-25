<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Issue Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
     
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token) { window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content; }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 min-h-screen flex flex-col">

    <nav class="bg-white border-b border-gray-200 py-4 px-6 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            
            <div class="flex items-center gap-4">
                <a href="{{ route('projects.index') }}" class="font-bold text-xl tracking-tight text-indigo-600">Workspace Hub</a>
                
                <span class="text-xs font-mono px-2 py-0.5 rounded bg-slate-100 text-slate-700 border">
                    Actor ID: <span class="font-bold text-indigo-600">{{ auth()->check() ? auth()->id() : 'None (Guest)' }}</span>
                </span>
            </div>

            <div class="flex flex-wrap items-center gap-6 text-sm font-medium">
                
                <div class="flex items-center gap-4 text-gray-500">
                    <a href="{{ route('projects.index') }}" class="hover:text-indigo-600 transition">Projects</a>
                    <a href="{{ route('issues.index') }}" class="hover:text-indigo-600 transition">Global Issues</a>
                </div>

                <div class="hidden md:block h-5 w-px bg-gray-200"></div>

                <div class="flex items-center gap-2 bg-gray-50 p-1 rounded-lg border border-gray-100">
                    <span class="text-[11px] text-gray-400 font-bold uppercase tracking-wider px-2">Test Auth:</span>
                    
                    <a href="?impersonate=1" class="text-xs bg-white text-indigo-700 px-2.5 py-1 rounded-md border border-gray-200 shadow-sm font-bold hover:bg-indigo-50 hover:border-indigo-200 transition">
                        👑 Owner (1)
                    </a>
                    
                    <a href="?impersonate=2" class="text-xs bg-white text-amber-700 px-2.5 py-1 rounded-md border border-gray-200 shadow-sm font-bold hover:bg-amber-50 hover:border-amber-200 transition">
                        👤 Guest (2)
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <main class="flex-grow max-w-7xl w-full mx-auto p-6 my-4">
        @yield('content')
    </main>

    <footer class="bg-white border-t py-4 text-center text-xs text-gray-400">
        Mini Issue Tracker Matrix &copy; {{ date('Y') }}
    </footer>

    @stack('scripts')
</body>
</html>