@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
    <div class="flex justify-between items-center border-b pb-3">
        <h1 class="text-2xl font-bold text-gray-800">Modify Issue Properties</h1>
        <span class="text-xs font-mono bg-gray-100 text-gray-500 px-2 py-1 rounded">ID: #{{ $issue->id }}</span>
    </div>
    
    @if($errors->any())
        <div class="p-3 bg-red-100 text-red-800 text-xs rounded-lg space-y-1">
            @foreach($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('issues.update', $issue->id) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Issue Title Summary</label>
            <input type="text" name="title" value="{{ old('title', $issue->title) }}" required class="w-full rounded-lg border-gray-300 p-2.5 border">
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Context Log & Description</label>
            <textarea name="description" rows="4" required class="w-full rounded-lg border-gray-300 p-2.5 border">{{ old('description', $issue->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Workflow Status</label>
                <select name="status" class="w-full rounded-lg border-gray-300 p-2.5 border bg-gray-50 text-sm">
                    <option value="open" @selected(old('status', $issue->status) === 'open')>Open</option>
                    <option value="in_progress" @selected(old('status', $issue->status) === 'in_progress')>In Progress</option>
                    <option value="closed" @selected(old('status', $issue->status) === 'closed')>Closed</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Priority Hierarchy</label>
                <select name="priority" class="w-full rounded-lg border-gray-300 p-2.5 border bg-gray-50 text-sm">
                    <option value="low" @selected(old('priority', $issue->priority) === 'low')>Low</option>
                    <option value="medium" @selected(old('priority', $issue->priority) === 'medium')>Medium</option>
                    <option value="high" @selected(old('priority', $issue->priority) === 'high')>High</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Target Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date', $issue->due_date) }}" class="w-full rounded-lg border-gray-300 p-2.5 border text-sm">
            </div>
        </div>

        <div class="flex gap-2 justify-end pt-4 border-t mt-6">
            <a href="{{ route('issues.show', $issue->id) }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Save Adjustments</button>
        </div>
    </form>
</div>
@endsection