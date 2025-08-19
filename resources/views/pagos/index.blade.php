@extends('adminlte::page')

@section('title', 'Pagos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestión de Pagos</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addPaymentModal">
            <i class="fas fa-plus"></i> Registrar Pago
        </button>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Resumen de Pagos -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>$1,250,000</h3>
                    <p>Ingresos del Mes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-cash"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>42</h3>
                    <p>Pagos Recibidos</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>8</h3>
                    <p>Pagos Pendientes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clock"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>3</h3>
                    <p>Pagos Atrasados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-alert-circled"></i>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" id="filter-status">
                                    <option value="">Todos</option>
                                    <option value="pagado">Pagado</option>
                                    <option value="pendiente">Pendiente</option>
                                    <option value="atrasado">Atrasado</option>
                                    <option value="parcial">Pago Parcial</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Inquilino</label>
                                <input type="text" class="form-control" id="filter-tenant" placeholder="Buscar inquilino">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Mes</label>
                                <select class="form-control" id="filter-month">
                                    <option value="">Todos</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Año</label>
                                <select class="form-control" id="filter-year">
                                    <option value="">Todos</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Método de Pago</label>
                                <select class="form-control" id="filter-method">
                                    <option value="">Todos</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="transferencia">Transferencia</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="tarjeta">Tarjeta</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
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
        <!-- Lista de Pagos -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Pagos</h3>
                    <div class="card-tools">
                        <button class="btn btn-success btn-sm" onclick="exportPayments()">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="payments-table">
                            <thead>
                                <tr>
                                    <th>Recibo Nº</th>
                                    <th>Inquilino</th>
                                    <th>Propiedad</th>
                                    <th>Período</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Fecha Pago</th>
                                    <th>Monto</th>
                                    <th>Método</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de ejemplo -->
                                <tr>
                                    <td>REC-001</td>
                                    <td>Juan Pérez</td>
                                    <td>Av. Corrientes 1234</td>
                                    <td>Enero 2024</td>
                                    <td>10/01/2024</td>
                                    <td>08/01/2024</td>
                                    <td>$45,000</td>
                                    <td><span class="badge badge-info">Transferencia</span></td>
                                    <td><span class="badge badge-success">Pagado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewPayment(1)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="printReceipt(1)">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editPayment(1)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>REC-002</td>
                                    <td>María González</td>
                                    <td>Florida 890</td>
                                    <td>Enero 2024</td>
                                    <td>15/01/2024</td>
                                    <td>-</td>
                                    <td>$80,000</td>
                                    <td>-</td>
                                    <td><span class="badge badge-danger">Atrasado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="registerPayment(2)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="sendReminder(2)">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="viewPayment(2)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>REC-003</td>
                                    <td>Carlos López</td>
                                    <td>San Martín 567</td>
                                    <td>Enero 2024</td>
                                    <td>05/01/2024</td>
                                    <td>05/01/2024</td>
                                    <td>$65,000</td>
                                    <td><span class="badge badge-success">Efectivo</span></td>
                                    <td><span class="badge badge-success">Pagado</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewPayment(3)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-secondary" onclick="printReceipt(3)">
                                            <i class="fas fa-print"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editPayment(3)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>REC-004</td>
                                    <td>Ana Martínez</td>
                                    <td>Rivadavia 456</td>
                                    <td>Enero 2024</td>
                                    <td>20/01/2024</td>
                                    <td>-</td>
                                    <td>$55,000</td>
                                    <td>-</td>
                                    <td><span class="badge badge-warning">Pendiente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick="registerPayment(4)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="sendReminder(4)">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        <button class="btn btn-sm btn-info" onclick="viewPayment(4)">
                                            <i class="fas fa-eye"></i>
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

    <!-- Modal para Registrar Pago -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Pago</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="payment-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Inquilino *</label>
                                    <select class="form-control" name="tenant_id" required>
                                        <option value="">Seleccionar inquilino...</option>
                                        <option value="1">Juan Pérez</option>
                                        <option value="2">María González</option>
                                        <option value="3">Carlos López</option>
                                        <option value="4">Ana Martínez</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Contrato *</label>
                                    <select class="form-control" name="contract_id" required>
                                        <option value="">Seleccionar contrato...</option>
                                        <option value="1">CTR-001 - Av. Corrientes 1234</option>
                                        <option value="2">CTR-002 - Florida 890</option>
                                        <option value="3">CTR-003 - San Martín 567</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Período *</label>
                                    <input type="month" class="form-control" name="period" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Vencimiento *</label>
                                    <input type="date" class="form-control" name="due_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Pago</label>
                                    <input type="date" class="form-control" name="payment_date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Monto Base *</label>
                                    <input type="number" class="form-control" name="base_amount" required step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expensas</label>
                                    <input type="number" class="form-control" name="expenses" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Recargo por Mora</label>
                                    <input type="number" class="form-control" name="late_fee" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Monto Total *</label>
                                    <input type="number" class="form-control" name="total_amount" required step="0.01" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Método de Pago *</label>
                                    <select class="form-control" name="payment_method" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="efectivo">Efectivo</option>
                                        <option value="transferencia">Transferencia Bancaria</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado *</label>
                                    <select class="form-control" name="status" required>
                                        <option value="pendiente">Pendiente</option>
                                        <option value="pagado">Pagado</option>
                                        <option value="parcial">Pago Parcial</option>
                                        <option value="atrasado">Atrasado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea class="form-control" name="notes" rows="3" placeholder="Observaciones adicionales..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Número de Referencia</label>
                                    <input type="text" class="form-control" name="reference_number" placeholder="Nº de transferencia, cheque, etc.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Comprobante</label>
                                    <input type="file" class="form-control-file" name="receipt_file" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="savePayment()">Guardar Pago</button>
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

    function viewPayment(id) {
        // Implementar vista de pago
        console.log('Ver pago:', id);
    }

    function editPayment(id) {
        // Implementar edición de pago
        console.log('Editar pago:', id);
    }

    function registerPayment(id) {
        // Implementar registro rápido de pago
        console.log('Registrar pago para:', id);
        $('#addPaymentModal').modal('show');
    }

    function printReceipt(id) {
        // Implementar impresión de recibo
        console.log('Imprimir recibo:', id);
    }

    function sendReminder(id) {
        if (confirm('¿Enviar recordatorio de pago al inquilino?')) {
            // Implementar envío de recordatorio
            console.log('Enviar recordatorio:', id);
        }
    }

    function exportPayments() {
        // Implementar exportación de pagos
        console.log('Exportando pagos...');
    }

    function savePayment() {
        // Implementar guardado de pago
        console.log('Guardando pago...');
        $('#addPaymentModal').modal('hide');
    }

    $(document).ready(function() {
        $('#payments-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "order": [[ 4, "desc" ]] // Ordenar por fecha de vencimiento descendente
        });

        // Calcular monto total automáticamente
        $('input[name="base_amount"], input[name="expenses"], input[name="late_fee"]').on('input', function() {
            const baseAmount = parseFloat($('input[name="base_amount"]').val()) || 0;
            const expenses = parseFloat($('input[name="expenses"]').val()) || 0;
            const lateFee = parseFloat($('input[name="late_fee"]').val()) || 0;

            const total = baseAmount + expenses + lateFee;
            $('input[name="total_amount"]').val(total.toFixed(2));
        });

        // Establecer fecha actual por defecto
        const today = new Date().toISOString().split('T')[0];
        $('input[name="payment_date"]').val(today);
    });
</script>
@stop
