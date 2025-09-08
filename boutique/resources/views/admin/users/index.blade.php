<h1>Gestion des clients</h1>

<table>
    <thead>
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