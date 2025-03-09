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
        <h1>Cursos</h1>

    </div>
    <div class="row">

    </div>
    <div class="container mt-4">
    <h2 class="text-center mb-4">Lista de Cursos</h2>
    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Duracion en horas</th>
                <th scope="col">Fecha de Creación</th>
                <th scope="col">Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->hour_load }}</td>
                <td>{{ $course->created_at->format('d/m/Y H:i') }}</td> 
                <td>
                    <a class="btn btn-primary" href="{{route('admin.courses.edit_template', $course->id)}}">Editar Template Curso</a>
                </td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>



@stop
