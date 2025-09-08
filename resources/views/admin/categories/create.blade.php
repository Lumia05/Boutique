@extends('admin.layout')

@section('title', '')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-danger fw-bold">Créer une nouvelle catégorie</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la catégorie</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-lg">Créer la catégorie</button>
                </div>
            </form>
        </div>
    </div>
@endsection