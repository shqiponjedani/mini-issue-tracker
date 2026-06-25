@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">All Tracked Issues</h1>
        <a href="{{ route('issues.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium text-sm">+ Track New Issue</a>
    </div>

    <form id="filter-form" method="GET" action="{{ route('issues.index') }}" class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Search Keywords</label>
            <input type="text" name="search" id="search-input" value="{{ request('search') }}" placeholder="Type to search..." class="w-full rounded-lg border-gray-300 shadow-sm p-2 border">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Filter Status</label>
            
            <select name="status" id="status-select" class="w-full rounded-lg border-gray-300 shadow-sm p-2 border bg-gray-50">
                <option value="">All Statuses</option>
                <option value="open" @selected(request('status') === 'open')>Open</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                <option value="closed" @selected(request('status') === 'closed')>Closed</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Filter Priority</label>
         
            <select name="priority" id="priority-select" class="w-full rounded-lg border-gray-300 shadow-sm p-2 border bg-gray-50">
                <option value="">All Priorities</option>
                <option value="low" @selected(request('priority') === 'low')>Low</option>
                <option value="medium" @selected(request('priority') === 'medium')>Medium</option>
                <option value="high" @selected(request('priority') === 'high')>High</option>
            </select>
        </div>
    </form>

    <div id="issues-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @include('issues.list',['issues'=> $issues])
     
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('search-input');
        const statusSelect = document.getElementById('status-select');
        const prioritySelect = document.getElementById('priority-select');
        const container = document.getElementById('issues-container');

        let debounceTimer;

        
        function performSearch() {
           
            const params = new URLSearchParams({
                search: searchInput.value,
                status: statusSelect.value,
                priority: prioritySelect.value
            });

           
            window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);

            
            axios.get(`${window.location.pathname}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
         
                container.innerHTML = response.data;
            })
            .catch(err => console.error("Error executing dynamic search matrix:", err));
        }

    
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                performSearch();
            }, 300); 
        });

        
        statusSelect.addEventListener('change', performSearch);
        prioritySelect.addEventListener('change', performSearch);
    });
</script>
@endpush