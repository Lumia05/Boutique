@extends('admin.layout')

@section('title','Gestion des clients')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>ID Client</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Nombre de commandes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->orders?->count() ?? 0 }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}">Voir la fiche</a>
                        </td>
                    </tr>
                    @endforeach
             </tbody>
</table>

{{ $users->links() }}