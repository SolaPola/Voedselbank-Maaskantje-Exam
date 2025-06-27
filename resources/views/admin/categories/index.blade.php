@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Categorieën Beheer') }}</span>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                        Nieuwe Categorie
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Naam</th>
                                    <th>Aantal Producten</th>
                                    <th>Status</th>
                                    <th>Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->products->count() }}</td>
                                        <td>
                                            <span class="badge badge-{{ $category->isactive ? 'success' : 'secondary' }}">
                                                {{ $category->isactive ? 'Actief' : 'Inactief' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info">Bekijken</a>
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">Bewerken</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Weet je zeker dat je deze categorie wilt verwijderen?')">
                                                    Verwijderen
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
