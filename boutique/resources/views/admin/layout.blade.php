<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration | Mon E-commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />
    <style>
        body { font-family: sans-serif; background-color: #f8f9fa; }
        .sidebar { background-color: #dc3545; color: white; min-height: 100vh; width: 320px; }
        .sidebar a { color: white; transition: background-color 0.3s; }
        .sidebar a:hover { background-color: #c82333; }
        .sidebar-heading { color: white !important; font-size: 1.5rem; font-weight: bold; }
        .list-group-item { background-color: #dc3545; border: 0; color: white; padding: 1rem 1.25rem; }
        .list-group-item:hover { background-color: #c82333; }
        .header { background-color: white; border-bottom: 1px solid #dee2e6; }
        .chart-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-danger" id="sidebar-wrapper">
            <div class="sidebar-heading p-4 text-center">Gestion</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt me-2"></i> Tableau de bord</a>
                <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-box me-2"></i> Produits</a>
                <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-th-list me-2"></i> Catégories</a>
                <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-shopping-cart me-2"></i> Commandes</a>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action"><i class="fas fa-users me-2"></i> Clients</a>
            </div>
        </div>

        <div id="page-content-wrapper" class="w-100">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <h1 class="h2 text-danger">@yield('title', 'Tableau de bord')</h1>
                    <form action="{{ route('logout') }}" method="POST" class="d-flex">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Déconnexion</button>
                    </form>
                </div>
            </nav>
            <div class="container-fluid p-4">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</html>