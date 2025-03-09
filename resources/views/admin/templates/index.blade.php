@extends('adminlte::page')

@section('title', 'Crear colaboradors')

@section('content_header')

@stop

@section('content')


<div class="container">

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


    <div class="row">
        <h1>Templates</h1>

    </div>
    <div class="row">

        <div class="row">
            <a type="button" href="{{route('admin.templates.create')}}" class="ml-2 btn btn-primary">
                Crear Template
            </a>
            <a type="button" href="{{route('admin.templates.course.assign')}}" class="ml-2 btn btn-info">
                Asignar Template a Curso
            </a>
        </div>
       

    </div>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Templates</h2>
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Path de Imagen</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($templates as $template)
                <tr>
                    <td>{{ $template->id }}</td>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->template_image_path }}</td>
                    <td>
                        <a href="{{route('admin.templates.edit', $template->id)}}" class="btn btn-primary">Editar</a>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        

    </div>


    
    <div class="container mt-4">
        <h2 class="text-center mb-4">Cursos con templates asignados</h2>
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Curso ID</th>
                    <th scope="col">Curso Nombre</th>
                    <th scope="col">Curso Impartido Por</th>
                    <th scope="col">Template ID</th>
                    <th scope="col">Template Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->collaborator->name }}</td>
                    <td>{{ $course->template?->id ?? 'Sin plantilla' }}</td>
                    <td>{{ $course->template?->name ?? 'Sin plantilla' }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <br>
    <br>
    <br>
    <br>
    <br>

</div>



@stop