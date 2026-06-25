@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm h-fit space-y-4">
        <h2 class="text-xl font-bold text-gray-800">Create New Tag</h2>
        
        @if($errors->any())
            <div class="p-3 bg-red-100 text-red-800 text-xs rounded-lg space-y-1">
                @foreach($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('tags.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Tag Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g., bug, enhancement, hotfix" class="w-full rounded-lg border-gray-300 p-2 border focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Color Palette Mapping</label>
                <input type="color" name="color" value="#6366f1" class="w-14 h-10 rounded border block cursor-pointer transition">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                Save Tag
            </button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Global Tag Infrastructure</h2>
        <p class="text-xs text-gray-400 mb-6">These are the global tags available to attach to any issues in your tracker.</p>
        
        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 text-xs rounded-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-3">
            @forelse($tags as $tag)
                <div class="flex items-center gap-2 px-3 py-2 rounded-lg border text-sm font-semibold transition hover:scale-[1.01]" 
                     style="background-color: {{ $tag->color ?? '#F3F4F6' }}33; border-color: {{ $tag->color ?? '#D1D5DB' }}88; color: {{ $tag->color ?? '#1F2937' }}">
                    <span class="w-2 h-2 rounded-full shadow-inner" style="background-color: {{ $tag->color ?? '#9CA3AF' }}"></span>
                    <span>{{ $tag->name }}</span>
                </div>
            @empty
                <p class="text-gray-400 italic text-sm">No tags have been created yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection