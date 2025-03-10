<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Certificado</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <a class="navbar-brand text-white mx-auto" href="#">Sistema de Certificados</a>
    </nav>

    <div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="card shadow-sm" style="width: 100%; max-width: 500px;">
            <div class="card-body">
                <h2 class="card-title text-center">Buscar Certificado</h2>

                <!-- Error Message -->
                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Search Form -->
                <!-- Search Form -->
                <form action="{{ route('certificate.search') }}" method="GET">
                    <div class="form-group">
                        <label for="certificate_code">Ingresa el código del certificado:</label>
                        <input type="text" id="certificate_code" name="code" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>