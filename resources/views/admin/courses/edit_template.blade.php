@extends('adminlte::page')

@section('title', 'Crear Curso')

@section('content_header')
    <h1></h1>
@stop

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Contenedor de ancho medio -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <h2 class="text-center mb-4">Formulario de Edicion de Template de Curso</h2>
            </div>

            <form enctype="multipart/form-data" action="{{ route('admin.courses.storeCertifyTemplate') }}" method="POST">
                @csrf

                <input name="course_id" value="{{$course->id}}" type="hidden">
                <div class="form-group">
                    <label for="name">Imagen del certificado:</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>


                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="{{ route('admin.courses') }}">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Plantilla</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
