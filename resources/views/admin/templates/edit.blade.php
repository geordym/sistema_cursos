@extends('adminlte::page')

@section('title', 'Editar Template')

@section('content_header')
<h1></h1>
@stop

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                <h2 class="text-center mb-4">Editar Template</h2>
            </div>

            <form enctype="multipart/form-data" action="{{ route('admin.templates.update') }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="template_id" value="{{$template->id}}">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $template->name }}" required>
                </div>

                <div class="form-group">
                    <label for="template_image">Imagen del Template (dejar vacío para mantener actual):</label>
                    <input type="file" class="form-control" id="template_image" name="template_image">
                    <small>Imagen actual: <a href="{{ asset('storage/' . $template->template_image_path) }}" target="_blank">{{ $template->template_image_path }}</a></small>
                </div>

                <div class="form-group">
                    <label for="positions">Posiciones:</label>
                    <div class="row">
                        <div class="col-6">
                            <label for="qr_x">QR X:</label>
                            <input type="number" step="0.01" class="form-control" id="qr_x" name="qr_x" value="{{ $template->qr_x }}" required>
                        </div>
                        <div class="col-6">
                            <label for="qr_y">QR Y:</label>
                            <input type="number" step="0.01" class="form-control" id="qr_y" name="qr_y" value="{{ $template->qr_y }}" required>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="alumn_name_x">Nombre Alumno X:</label>
                            <input type="number" step="0.01" class="form-control" id="alumn_name_x" name="alumn_name_x" value="{{ $template->alumn_name_x }}" required>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="alumn_name_y">Nombre Alumno Y:</label>
                            <input type="number" step="0.01" class="form-control" id="alumn_name_y" name="alumn_name_y" value="{{ $template->alumn_name_y }}" required>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="alumn_finishCourseDate_x">Fecha Finalización X:</label>
                            <input type="number" step="0.01" class="form-control" id="alumn_finishCourseDate_x" name="alumn_finishCourseDate_x" value="{{ $template->alumn_finishCourseDate_x }}" required>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="alumn_finishCourseDate_y">Fecha Finalización Y:</label>
                            <input type="number" step="0.01" class="form-control" id="alumn_finishCourseDate_y" name="alumn_finishCourseDate_y" value="{{ $template->alumn_finishCourseDate_y }}" required>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="alumn_courseName_x">Nombre Curso X:</label>
                            <input type="number" step="0.01" class="form-control" id="alumn_courseName_x" name="alumn_courseName_x" value="{{ $template->alumn_courseName_x }}" required>
                        </div>
                        <div class="col-6 mt-3">
                            <label for="alumn_courseName_y">Nombre Curso Y:</label>
                            <input type="number" step="0.01" class="form-control" id="alumn_courseName_y" name="alumn_courseName_y" value="{{ $template->alumn_courseName_y }}" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer mt-4">
                    <a type="button" class="btn btn-secondary" href="{{ route('admin.templates.index') }}">Cancelar</a>
                    <a href="{{ route('admin.templates.preview', $template->id) }}" target="_blank" class="btn btn-info">Previsualizar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop