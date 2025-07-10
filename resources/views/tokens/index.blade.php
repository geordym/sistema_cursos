@extends('adminlte::page')

@section('title', 'Dashboard Administración')

@section('content_header')
    <h1>Tokens </h1>
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

    </div>
    <div class="row">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createUserModal">
            Asignar Token
        </button>

         <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeTokenModal">
            Remover Token
        </button>
    </div>
    <div class="row bg-white mt-3">
    <div class="container mt-4">
    <h2 class="text-center mb-4">Registro de Tokens</h2>
    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Colaborador</th>
                <th scope="col">Operación</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Descripción</th>
                <th scope="col">Fecha de Operación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tokensLogs as $token)
            <tr>
                <td>{{ $token->user->name }}</td>
                <td>
                    @if($token->type === 'addition')
                        <span class="badge badge-success">Adición</span>
                    @else
                        <span class="badge badge-danger">Deducción</span>
                    @endif
                </td>
                <td>{{ $token->tokens }}</td>
                <td>{{ $token->description ?? 'N/A' }}</td>
                <td>{{ $token->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Asignar token</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


               <form action="{{ route('admin.tokens.add') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="collaborator_id">Colaborador:</label>
        <select class="form-control" id="collaborator_id" name="collaborator_id" required>
            <option value="">Selecciona un colaborador</option>
            @foreach($collaborators as $collaborator)
                <option value="{{ $collaborator->user->id }}">{{ $collaborator->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="tokens">Cantidad de Tokens:</label>
        <input type="number" class="form-control" id="tokens" name="tokens" min="1" required>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <input type="text" class="form-control" id="description" name="description" required>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Añadir Tokens</button>
    </div>
</form>



            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="removeTokenModal" tabindex="-1" role="dialog" aria-labelledby="removeTokenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeTokenModalLabel">Remover tokens</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('admin.tokens.remove') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="collaborator_id_remove">Colaborador:</label>
                        <select class="form-control" id="collaborator_id_remove" name="collaborator_id" required>
                            <option value="">Selecciona un colaborador</option>
                            @foreach($collaborators as $collaborator)
                                <option value="{{ $collaborator->user->id }}">{{ $collaborator->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tokens_remove">Cantidad de Tokens a remover:</label>
                        <input type="number" class="form-control" id="tokens_remove" name="tokens" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="description_remove">Descripción:</label>
                        <input type="text" class="form-control" id="description_remove" name="description" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Remover Tokens</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


@stop