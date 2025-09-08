@extends('admin.layout')

@section('title', '')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h1 class="h3 text-danger fw-bold">Modifier la categorie</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm rounded-3">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i> Erreurs de validation</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-bold text-dark">Nom de la categorie</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}">
                    </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-warning btn-lg px-5 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Mettre à jour la categorie
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

