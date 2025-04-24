<!-- resources/views/certificate/result.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resultado de la Búsqueda</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="antialiased bg-light">
    <div class="container mt-5">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/resources/aiet-logo.jpg') }}" alt="Logo AIET" style="height: 80px;">
        </div>

        <div class="card shadow-lg border-0">
            <div class="card-header text-white" style="background: linear-gradient(90deg, #007bff, #0056b3);">
                <h2 class="h4 mb-0 text-center">Resultado de la Búsqueda</h2>
            </div>

            <div class="card-body">
                @if($certificate)
                    <div class="alert alert-success text-center">
                        <strong>✅ Certificado Encontrado</strong>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Código del Certificado:</strong> {{ $certificate->certify_code }}</li>
                        <li class="list-group-item"><strong>Nombre del Titular:</strong> {{ $certificate->student_fullname }}</li>
                        <li class="list-group-item"><strong>CURP del Estudiante:</strong> {{ $certificate->student_curp }}</li>
                        <li class="list-group-item"><strong>Curso:</strong> {{ $certificate->course_name }}</li>
                        <li class="list-group-item"><strong>Carga Horaria del Curso:</strong> {{ $certificate->course_hour_load }} horas</li>
                        <li class="list-group-item"><strong>Fecha de Emisión:</strong> {{ $certificate->issue_date }}</li>
                        <li class="list-group-item"><strong>Instructor:</strong> {{ $certificate->instructor_name }}</li>
                    </ul>
                @else
                    <div class="alert alert-danger text-center">
                        <strong>❌ Certificado no encontrado</strong>
                    </div>
                @endif
            </div>

            <div class="card-footer text-center">
                <a href="{{ route('certificate.searchForm') }}" class="btn btn-outline-primary">🔎 Buscar otro certificado</a>
            </div>
        </div>
    </div>
    <br><br>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>