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
    <div class="card">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('storage/resources/aiet-logo.jpg') }}" alt="Logo AIET" style="height: 50px; width: auto;" class="mr-3">
                <h1 class="h5 mb-0">Resultado de la Búsqueda</h1>
            </div>
        </div>

        <div class="card-body">
            @if($certificate)
            <div class="alert alert-success">
                <strong>Certificado Encontrado</strong>
            </div>

            <p><strong>Código del Certificado:</strong> {{ $certificate->certify_code }}</p>
            <p><strong>Nombre del Titular:</strong> {{ $certificate->student_fullname }}</p>
            <p><strong>CURP del Estudiante:</strong> {{ $certificate->student_curp }}</p>
            <p><strong>Curso:</strong> {{ $certificate->course_name }}</p>
            <p><strong>Carga Horaria del Curso:</strong> {{ $certificate->course_hour_load }} horas</p>
            <p><strong>Fecha de Emisión:</strong> {{ $certificate->issue_date }}</p>
            <p><strong>Instructor:</strong> {{ $certificate->instructor_name }}</p>
            @else
            <div class="alert alert-danger">
                <strong>Certificado no encontrado</strong>
            </div>
            @endif
        </div>

        <div class="card-footer text-right">
            <a href="{{ route('certificate.searchForm') }}" class="btn btn-secondary">Buscar otro certificado</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>