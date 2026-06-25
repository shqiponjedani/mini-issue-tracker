@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-gray-200 shadow-sm space-y-4">
    <h1 class="text-2xl font-bold text-gray-800">Launch New Project</h1>
    
    @if($errors->any())
        <div class="p-3 bg-red-100 text-red-800 text-xs rounded-lg space-y-1">
            @foreach($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('projects.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Project Identifier Title</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 p-2.5 border">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Core Objectives</label>
            <textarea name="description" rows="4" required class="w-full rounded-lg border-gray-300 p-2.5 border">{{ old('description') }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kickoff Date</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full rounded-lg border-gray-300 p-2.5 border">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Final Deadline</label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full rounded-lg border-gray-300 p-2.5 border">
            </div>
        </div>
        <div class="flex gap-2 justify-end pt-4 border-t">
            <a href="{{ route('projects.index') }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50 transition">Cancel</a>
            <button type="submit" class="bg-indigo-600 text-white px-5 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Save Project</button>
        </div>
    </form>
</div>
@endsection