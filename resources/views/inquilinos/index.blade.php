@extends('adminlte::page')

@section('title', 'Inquilinos')

@section('content_header')
    <h1>Listado de Inquilinos</h1>
@stop

@section('content')
    <a href="{{ route('inquilinos.create') }}" class="btn btn-primary mb-3">Nuevo Inquilino</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inquilinos as $i)
                <tr>
                    <td>{{ $i->id }}</td>
                    <td>{{ $i->nombre }}</td>
                    <td>{{ $i->dni }}</td>
                    <td>{{ $i->telefono }}</td>
                    <td>{{ $i->email }}</td>
                    <td>{{ $i->direccion }}</td>
                    <td>
                        <a href="{{ route('inquilinos.edit', $i) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('inquilinos.destroy', $i) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
