@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Kategori Buku</h1>
    @if($categories->count())
        <ul class="space-y-4">
            @foreach($categories as $category)
                <li class="border rounded p-4 shadow hover:shadow-lg transition">
                    <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
                    <p class="text-gray-600 mt-1">{{ $category->description }}</p>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @else
        <p>Tidak ada kategori yang tersedia.</p>
    @endif
</div>
@endsection
