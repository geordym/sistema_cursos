@extends('adminlte::page')

@section('title', 'Crear Template')

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
                <h2 class="text-center mb-4">Formulario de Creacion de Templates</h2>
            </div>

            <form enctype="multipart/form-data" action="{{ route('admin.templates.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="template_image_path">Imagen del Template:</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>

                <div class="form-group">
                    <label for="qr_x">Posición QR (X):</label>
                    <input type="number" step="0.01" class="form-control" id="qr_x" name="qr_x" required>
                </div>

                <div class="form-group">
                    <label for="qr_y">Posición QR (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="qr_y" name="qr_y" required>
                </div>

                <div class="form-group">
                    <label for="qr_size">Tamaño del QR:</label>
                    <input type="number" class="form-control" id="qr_size" name="qr_size">
                </div>

                <div class="form-group">
                    <label for="alumn_name_x">Posición Nombre Alumno (X):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_name_x" name="alumn_name_x" required>
                </div>

                <div class="form-group">
                    <label for="alumn_name_y">Posición Nombre Alumno (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_name_y" name="alumn_name_y" required>
                </div>

                <div class="form-group">
                    <label for="alumn_name_text_size">Tamaño del texto Nombre Alumno:</label>
                    <input type="number" class="form-control" id="alumn_name_text_size" name="alumn_name_text_size">
                </div>

                <div class="form-group">
                    <label for="alumn_name_text_color">Color del texto Nombre Alumno:</label>
                    <input type="text" class="form-control" id="alumn_name_text_color" name="alumn_name_text_color">
                </div>

                <div class="form-group">
                    <label for="alumn_name_text_align">Alineación del texto Nombre Alumno:</label>
                    <input type="text" class="form-control" id="alumn_name_text_align" name="alumn_name_text_align">
                </div>

                <div class="form-group">
                    <label for="alumn_finishCourseDate_x">Posición Fecha de Finalización del Curso (X):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_finishCourseDate_x" name="alumn_finishCourseDate_x" required>
                </div>

                <div class="form-group">
                    <label for="alumn_finishCourseDate_y">Posición Fecha de Finalización del Curso (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_finishCourseDate_y" name="alumn_finishCourseDate_y" required>
                </div>

                <div class="form-group">
                    <label for="finish_course_text_size">Tamaño del texto Fecha de Finalización:</label>
                    <input type="number" class="form-control" id="finish_course_text_size" name="finish_course_text_size">
                </div>

                <div class="form-group">
                    <label for="finish_course_text_color">Color del texto Fecha de Finalización:</label>
                    <input type="text" class="form-control" id="finish_course_text_color" name="finish_course_text_color">
                </div>

                <div class="form-group">
                    <label for="finish_course_text_align">Alineación del texto Fecha de Finalización:</label>
                    <input type="text" class="form-control" id="finish_course_text_align" name="finish_course_text_align">
                </div>

                <div class="form-group">
                    <label for="alumn_courseName_x">Posición Nombre del Curso (X):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_courseName_x" name="alumn_courseName_x" required>
                </div>

                <div class="form-group">
                    <label for="alumn_courseName_y">Posición Nombre del Curso (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_courseName_y" name="alumn_courseName_y" required>
                </div>

                <div class="form-group">
                    <label for="course_name_text_size">Tamaño del texto Nombre del Curso:</label>
                    <input type="number" class="form-control" id="course_name_text_size" name="course_name_text_size">
                </div>

                <div class="form-group">
                    <label for="course_name_text_color">Color del texto Nombre del Curso:</label>
                    <input type="text" class="form-control" id="course_name_text_color" name="course_name_text_color">
                </div>

                <div class="form-group">
                    <label for="course_name_text_align">Alineación del texto Nombre del Curso:</label>
                    <input type="text" class="form-control" id="course_name_text_align" name="course_name_text_align">
                </div>

                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="{{ route('admin.templates.index') }}">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar Template</button>
                </div>
            </form>


        </div>
    </div>
</div>

@stop