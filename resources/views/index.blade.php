@extends('adminlte::page')

@section('title', 'Propiedades')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestión de Propiedades</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addPropertyModal">
            <i class="fas fa-plus"></i> Nueva Propiedad
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Filtros -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Filtros</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo de Propiedad</label>
                                <select class="form-control" id="filter-type">
                                    <option value="">Todos</option>
                                    <option value="departamento">Departamento</option>
                                    <option value="casa">Casa</option>
                                    <option value="local">Local Comercial</option>
                                    <option value="oficina">Oficina</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" id="filter-status">
                                    <option value="">Todos</option>
                                    <option value="disponible">Disponible</option>
                                    <option value="ocupada">Ocupada</option>
                                    <option value="mantenimiento">En Mantenimiento</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Ubicación</label>
                                <input type="text" class="form-control" id="filter-location" placeholder="Buscar por ubicación">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button class="btn btn-info btn-block" onclick="applyFilters()">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Lista de Propiedades -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Propiedades</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="properties-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dirección</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Precio Alquiler</th>
                                    <th>Inquilino Actual</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de ejemplo -->
                                <tr>
                                    <td>001</td>
                                    <td>Av. Corrientes 1234, CABA</td>
                                    <td><span class="badge badge-info">Departamento</span></td>
                                    <td><span class="badge badge-success">Ocupada</span></td>
                                    <td>$45,000</td>
                                    <td>Juan Pérez</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewProperty(1)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editProperty(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProperty(1)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td>San Martín 567, Belgrano</td>
                                    <td><span class="badge badge-primary">Casa</span></td>
                                    <td><span class="badge badge-warning">Disponible</span></td>
                                    <td>$65,000</td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewProperty(2)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editProperty(2)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProperty(2)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>003</td>
                                    <td>Florida 890, Microcentro</td>
                                    <td><span class="badge badge-success">Local Comercial</span></td>
                                    <td><span class="badge badge-success">Ocupada</span></td>
                                    <td>$80,000</td>
                                    <td>María González</td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewProperty(3)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editProperty(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProperty(3)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nueva Propiedad -->
    <div class="modal fade" id="addPropertyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Propiedad</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="property-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dirección *</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Propiedad *</label>
                                    <select class="form-control" name="type" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="departamento">Departamento</option>
                                        <option value="casa">Casa</option>
                                        <option value="local">Local Comercial</option>
                                        <option value="oficina">Oficina</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Precio Alquiler *</label>
                                    <input type="number" class="form-control" name="rent_price" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expensas</label>
                                    <input type="number" class="form-control" name="expenses">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select class="form-control" name="status">
                                        <option value="disponible">Disponible</option>
                                        <option value="ocupada">Ocupada</option>
                                        <option value="mantenimiento">En Mantenimiento</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveProperty()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    function applyFilters() {
        // Implementar lógica de filtros
        console.log('Aplicando filtros...');
    }

    function viewProperty(id) {
        // Implementar vista de propiedad
        console.log('Ver propiedad:', id);
    }

    function editProperty(id) {
        // Implementar edición de propiedad
        console.log('Editar propiedad:', id);
    }

    function deleteProperty(id) {
        if (confirm('¿Está seguro de que desea eliminar esta propiedad?')) {
            // Implementar eliminación
            console.log('Eliminar propiedad:', id);
        }
    }

    function saveProperty() {
        // Implementar guardado de propiedad
        console.log('Guardando propiedad...');
        $('#addPropertyModal').modal('hide');
    }

    $(document).ready(function() {
        $('#properties-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            }
        });
    });
</script>
@stop
