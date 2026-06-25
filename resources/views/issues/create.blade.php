@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
    <h1 class="text-2xl font-bold text-gray-800">Track New Workspace Issue</h1>
    
    @if($errors->any())
        <div class="p-3 bg-red-100 text-red-800 text-xs rounded-lg">
            @foreach($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('issues.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Parent Project</label>
            <select name="project_id" required class="w-full rounded-lg border-gray-300 p-2.5 border bg-gray-50">
                @foreach($projects as $p)
                    <option value="{{ $p->id }}" @selected(request('project_id') == $p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Issue Title</label>
            <input type="text" name="title" required class="w-full rounded-lg border-gray-300 p-2.5 border">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Detailed Description</label>
            <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 p-2.5 border"></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Initial Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 p-2.5 border bg-gray-50">
                    <option value="open">Open</option>
                    <option value="in_progress">In Progress</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Priority Metric</label>
                <select name="priority" class="w-full rounded-lg border-gray-300 p-2.5 border bg-gray-50">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Target Due Date</label>
                <input type="date" name="due_date" class="w-full rounded-lg border-gray-300 p-2.5 border">
            </div>
        </div>
        <div class="flex gap-2 justify-end pt-4">
            <a href="{{ route('issues.index') }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-indigo-700">Save Task</button>
        </div>
    </form>
</div>
@endsection