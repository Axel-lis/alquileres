@extends('adminlte::page')

@section('title', 'Contratos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestión de Contratos</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addContractModal">
            <i class="fas fa-plus"></i> Nuevo Contrato
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Resumen de Contratos -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>45</h3>
                    <p>Contratos Activos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>12</h3>
                    <p>Renovaciones Pendientes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-refresh"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>8</h3>
                    <p>Vencen en 30 días</p>
                </div>
                <div class="icon">
                    <i class="ion ion-calendar"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>3</h3>
                    <p>Contratos Vencidos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-alert"></i>
                </div>
            </div>
        </div>
    </div>

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
                                <label>Estado del Contrato</label>
                                <select class="form-control" id="filter-status">
                                    <option value="">Todos</option>
                                    <option value="activo">Activo</option>
                                    <option value="vencido">Vencido</option>
                                    <option value="renovacion">En Renovación</option>
                                    <option value="finalizado">Finalizado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Inquilino</label>
                                <input type="text" class="form-control" id="filter-tenant" placeholder="Buscar inquilino">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha de Vencimiento</label>
                                <input type="date" class="form-control" id="filter-expiry">
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
        <!-- Lista de Contratos -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Contratos</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="contracts-table">
                            <thead>
                                <tr>
                                    <th>Nº Contrato</th>
                                    <th>Inquilino</th>
                                    <th>Propiedad</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Monto Mensual</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de ejemplo -->
                                <tr>
                                    <td>CTR-001</td>
                                    <td>Juan Pérez</td>
                                    <td>Av. Corrientes 1234</td>
                                    <td>01/01/2023</td>
                                    <td>31/12/2024</td>
                                    <td>$45,000</td>
                                    <td><span class="badge badge-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewContract(1)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editContract(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="renewContract(1)">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="generatePDF(1)">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CTR-002</td>
                                    <td>María González</td>
                                    <td>Florida 890</td>
                                    <td>15/06/2022</td>
                                    <td>14/06/2024</td>
                                    <td>$80,000</td>
                                    <td><span class="badge badge-warning">Por Vencer</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewContract(2)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editContract(2)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="renewContract(2)">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="generatePDF(2)">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CTR-003</td>
                                    <td>Carlos López</td>
                                    <td>San Martín 567</td>
                                    <td>01/03/2023</td>
                                    <td>28/02/2025</td>
                                    <td>$65,000</td>
                                    <td><span class="badge badge-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewContract(3)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editContract(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="renewContract(3)">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="generatePDF(3)">
                                            <i class="fas fa-file-pdf"></i>
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

    <!-- Modal para Nuevo Contrato -->
    <div class="modal fade" id="addContractModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Contrato</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contract-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Inquilino *</label>
                                    <select class="form-control" name="tenant_id" required>
                                        <option value="">Seleccionar inquilino...</option>
                                        <option value="1">Juan Pérez</option>
                                        <option value="2">María González</option>
                                        <option value="3">Carlos López</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Propiedad *</label>
                                    <select class="form-control" name="property_id" required>
                                        <option value="">Seleccionar propiedad...</option>
                                        <option value="1">Av. Corrientes 1234</option>
                                        <option value="2">San Martín 567</option>
                                        <option value="3">Florida 890</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Inicio *</label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Vencimiento *</label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Duración (meses)</label>
                                    <input type="number" class="form-control" name="duration" min="1" max="60">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Monto Mensual *</label>
                                    <input type="number" class="form-control" name="monthly_amount" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Depósito de Garantía</label>
                                    <input type="number" class="form-control" name="deposit">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Comisión (%)</label>
                                    <input type="number" class="form-control" name="commission" step="0.01" min="0" max="100">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Términos y Condiciones</label>
                                    <textarea class="form-control" name="terms" rows="4" placeholder="Términos específicos del contrato..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Renovación Automática</label>
                                    <select class="form-control" name="auto_renewal">
                                        <option value="0">No</option>
                                        <option value="1">Sí</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Notificar Vencimiento (días antes)</label>
                                    <input type="number" class="form-control" name="notification_days" value="30">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveContract()">Guardar Contrato</button>
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

    function viewContract(id) {
        // Implementar vista de contrato
        console.log('Ver contrato:', id);
    }

    function editContract(id) {
        // Implementar edición de contrato
        console.log('Editar contrato:', id);
    }

    function renewContract(id) {
        if (confirm('¿Desea iniciar el proceso de renovación de este contrato?')) {
            // Implementar renovación
            console.log('Renovar contrato:', id);
        }
    }

    function generatePDF(id) {
        // Implementar generación de PDF
        console.log('Generar PDF del contrato:', id);
    }

    function saveContract() {
        // Implementar guardado de contrato
        console.log('Guardando contrato...');
        $('#addContractModal').modal('hide');
    }

    $(document).ready(function() {
        $('#contracts-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "order": [[ 4, "asc" ]] // Ordenar por fecha de vencimiento
        });

        // Calcular duración automáticamente
        $('input[name="start_date"], input[name="end_date"]').on('change', function() {
            const startDate = new Date($('input[name="start_date"]').val());
            const endDate = new Date($('input[name="end_date"]').val());

            if (startDate && endDate && endDate > startDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffMonths = Math.ceil(diffTime / (1000 * 60 * 60 * 24 * 30));
                $('input[name="duration"]').val(diffMonths);
            }
        });
    });
</script>
@stop
