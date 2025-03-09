@extends('adminlte::page')

@section('title', 'Asignar Template')

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
                <h2 class="text-center mb-4">Asignar template a un curso</h2>
            </div>

            <form action="{{ route('admin.templates.assign') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="course">Curso:</label>
                    <select class="form-control" id="course" name="course_id" required>
                        <option value="">Seleccione un curso</option>
                        @foreach ($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="template">Template:</label>
                    <select class="form-control" id="template" name="template_id" required>
                        <option value="">Seleccione un template</option>
                        @foreach ($templates as $template)
                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="{{ route('admin.templates.index') }}">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Asignar</button>
                </div>
            </form>
        </div>
    </div>
</div>


@stop