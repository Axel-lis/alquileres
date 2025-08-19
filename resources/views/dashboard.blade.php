@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Administración - Alquileres</h1>
@stop

@section('content')
    <div class="row">
        <!-- Resumen de métricas -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-income">$0</h3>
                    <p>Ingresos Totales</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="total-properties">0</h3>
                    <p>Propiedades Activas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-home"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="contracts-expiring">0</h3>
                    <p>Contratos por Vencer</p>
                </div>
                <div class="icon">
                    <i class="ion ion-calendar"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="total-expenses">$0</h3>
                    <p>Gastos del Mes</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Ingresos vs Gastos -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresos vs Gastos (Últimos 12 meses)</h3>
                </div>
                <div class="card-body">
                    <div id="income-expenses-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Distribución de Propiedades -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Distribución de Propiedades por Tipo</h3>
                </div>
                <div class="card-body">
                    <div id="property-distribution-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Vencimientos de Contratos -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vencimientos de Contratos (Próximos 6 meses)</h3>
                </div>
                <div class="card-body">
                    <div id="contract-expiration-chart" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Estado de Pagos -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Estado de Pagos</h3>
                </div>
                <div class="card-body">
                    <div id="payment-status-chart" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Gráfico de Tendencia de Ocupación -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tendencia de Ocupación de Propiedades</h3>
                </div>
                <div class="card-body">
                    <div id="occupancy-trend-chart" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .chart-container {
            position: relative;
        }

        .axis {
            font-size: 12px;
        }

        .axis path,
        .axis line {
            fill: none;
            stroke: #000;
            shape-rendering: crispEdges;
        }

        .bar {
            fill: steelblue;
        }

        .bar:hover {
            fill: orange;
        }

        .line {
            fill: none;
            stroke: steelblue;
            stroke-width: 2px;
        }

        .area {
            fill: lightsteelblue;
            opacity: 0.7;
        }

        .tooltip {
            position: absolute;
            text-align: center;
            width: auto;
            height: auto;
            padding: 8px;
            font: 12px sans-serif;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border: 0px;
            border-radius: 8px;
            pointer-events: none;
            opacity: 0;
        }

        .legend {
            font-size: 12px;
        }

        .legend rect {
            stroke-width: 2;
        }
    </style>
@stop

@section('js')
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        // Datos de ejemplo (en producción estos vendrían del backend)
        const dashboardData = {
            monthlyData: [
                {month: 'Ene', income: 15000, expenses: 8000},
                {month: 'Feb', income: 18000, expenses: 9500},
                {month: 'Mar', income: 16500, expenses: 7800},
                {month: 'Abr', income: 19000, expenses: 10200},
                {month: 'May', income: 17500, expenses: 8900},
                {month: 'Jun', income: 20000, expenses: 11000},
                {month: 'Jul', income: 22000, expenses: 9800},
                {month: 'Ago', income: 21500, expenses: 10500},
                {month: 'Sep', income: 19500, expenses: 9200},
                {month: 'Oct', income: 18000, expenses: 8700},
                {month: 'Nov', income: 17000, expenses: 8300},
                {month: 'Dic', income: 16000, expenses: 7900}
            ],
            propertyTypes: [
                {type: 'Departamentos', count: 25},
                {type: 'Casas', count: 15},
                {type: 'Locales Comerciales', count: 8},
                {type: 'Oficinas', count: 12}
            ],
            contractExpirations: [
                {month: 'Ene 2024', count: 3},
                {month: 'Feb 2024', count: 5},
                {month: 'Mar 2024', count: 2},
                {month: 'Abr 2024', count: 7},
                {month: 'May 2024', count: 4},
                {month: 'Jun 2024', count: 6}
            ],
            paymentStatus: [
                {status: 'Al día', count: 45},
                {status: 'Atrasado', count: 8},
                {status: 'Moroso', count: 3}
            ],
            occupancyTrend: [
                {month: 'Ene', occupied: 48, total: 60},
                {month: 'Feb', occupied: 50, total: 60},
                {month: 'Mar', occupied: 52, total: 60},
                {month: 'Abr', occupied: 55, total: 60},
                {month: 'May', occupied: 56, total: 60},
                {month: 'Jun', occupied: 58, total: 60}
            ]
        };

        // Actualizar métricas principales
        function updateMetrics() {
            const totalIncome = dashboardData.monthlyData.reduce((sum, d) => sum + d.income, 0);
            const totalExpenses = dashboardData.monthlyData.reduce((sum, d) => sum + d.expenses, 0);
            const totalProperties = dashboardData.propertyTypes.reduce((sum, d) => sum + d.count, 0);
            const contractsExpiring = dashboardData.contractExpirations.slice(0, 3).reduce((sum, d) => sum + d.count, 0);

            document.getElementById('total-income').textContent = '$' + totalIncome.toLocaleString();
            document.getElementById('total-properties').textContent = totalProperties;
            document.getElementById('contracts-expiring').textContent = contractsExpiring;
            document.getElementById('total-expenses').textContent = '$' + dashboardData.monthlyData[dashboardData.monthlyData.length - 1].expenses.toLocaleString();
        }

        // Gráfico de Ingresos vs Gastos
        function createIncomeExpensesChart() {
            const margin = {top: 20, right: 80, bottom: 30, left: 70};
            const width = 500 - margin.left - margin.right;
            const height = 300 - margin.top - margin.bottom;

            const svg = d3.select("#income-expenses-chart")
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);

            const x = d3.scaleBand()
                .domain(dashboardData.monthlyData.map(d => d.month))
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(dashboardData.monthlyData, d => Math.max(d.income, d.expenses))])
                .range([height, 0]);

            // Barras de ingresos
            svg.selectAll(".bar-income")
                .data(dashboardData.monthlyData)
                .enter().append("rect")
                .attr("class", "bar-income")
                .attr("x", d => x(d.month))
                .attr("width", x.bandwidth() / 2)
                .attr("y", d => y(d.income))
                .attr("height", d => height - y(d.income))
                .attr("fill", "#28a745");

            // Barras de gastos
            svg.selectAll(".bar-expenses")
                .data(dashboardData.monthlyData)
                .enter().append("rect")
                .attr("class", "bar-expenses")
                .attr("x", d => x(d.month) + x.bandwidth() / 2)
                .attr("width", x.bandwidth() / 2)
                .attr("y", d => y(d.expenses))
                .attr("height", d => height - y(d.expenses))
                .attr("fill", "#dc3545");

            // Ejes
            svg.append("g")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x));

            svg.append("g")
                .call(d3.axisLeft(y).tickFormat(d => "$" + d.toLocaleString()));

            // Leyenda
            const legend = svg.append("g")
                .attr("class", "legend")
                .attr("transform", `translate(${width - 100}, 20)`);

            legend.append("rect")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", 15)
                .attr("height", 15)
                .attr("fill", "#28a745");

            legend.append("text")
                .attr("x", 20)
                .attr("y", 12)
                .text("Ingresos");

            legend.append("rect")
                .attr("x", 0)
                .attr("y", 20)
                .attr("width", 15)
                .attr("height", 15)
                .attr("fill", "#dc3545");

            legend.append("text")
                .attr("x", 20)
                .attr("y", 32)
                .text("Gastos");
        }

        // Gráfico de Distribución de Propiedades (Donut Chart)
        function createPropertyDistributionChart() {
            const width = 300;
            const height = 300;
            const radius = Math.min(width, height) / 2;

            const svg = d3.select("#property-distribution-chart")
                .append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", `translate(${width/2},${height/2})`);

            const color = d3.scaleOrdinal()
                .domain(dashboardData.propertyTypes.map(d => d.type))
                .range(["#007bff", "#28a745", "#ffc107", "#dc3545"]);

            const pie = d3.pie()
                .value(d => d.count);

            const arc = d3.arc()
                .innerRadius(radius * 0.4)
                .outerRadius(radius * 0.8);

            const arcs = svg.selectAll(".arc")
                .data(pie(dashboardData.propertyTypes))
                .enter().append("g")
                .attr("class", "arc");

            arcs.append("path")
                .attr("d", arc)
                .attr("fill", d => color(d.data.type))
                .on("mouseover", function(event, d) {
                    d3.select(this).attr("opacity", 0.7);
                })
                .on("mouseout", function(event, d) {
                    d3.select(this).attr("opacity", 1);
                });

            arcs.append("text")
                .attr("transform", d => `translate(${arc.centroid(d)})`)
                .attr("text-anchor", "middle")
                .text(d => d.data.count)
                .style("font-size", "14px")
                .style("font-weight", "bold");

            // Leyenda
            const legend = svg.append("g")
                .attr("class", "legend")
                .attr("transform", `translate(${radius + 20}, -${radius/2})`);

            const legendItems = legend.selectAll(".legend-item")
                .data(dashboardData.propertyTypes)
                .enter().append("g")
                .attr("class", "legend-item")
                .attr("transform", (d, i) => `translate(0, ${i * 20})`);

            legendItems.append("rect")
                .attr("width", 15)
                .attr("height", 15)
                .attr("fill", d => color(d.type));

            legendItems.append("text")
                .attr("x", 20)
                .attr("y", 12)
                .text(d => d.type)
                .style("font-size", "12px");
        }

        // Gráfico de Vencimientos de Contratos
        function createContractExpirationChart() {
            const margin = {top: 20, right: 30, bottom: 40, left: 50};
            const width = 600 - margin.left - margin.right;
            const height = 350 - margin.top - margin.bottom;

            const svg = d3.select("#contract-expiration-chart")
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);

            const x = d3.scaleBand()
                .domain(dashboardData.contractExpirations.map(d => d.month))
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(dashboardData.contractExpirations, d => d.count)])
                .range([height, 0]);

            const tooltip = d3.select("body").append("div")
                .attr("class", "tooltip");

            svg.selectAll(".bar")
                .data(dashboardData.contractExpirations)
                .enter().append("rect")
                .attr("class", "bar")
                .attr("x", d => x(d.month))
                .attr("width", x.bandwidth())
                .attr("y", d => y(d.count))
                .attr("height", d => height - y(d.count))
                .attr("fill", "#ffc107")
                .on("mouseover", function(event, d) {
                    tooltip.transition()
                        .duration(200)
                        .style("opacity", .9);
                    tooltip.html(`${d.month}<br/>${d.count} contratos`)
                        .style("left", (event.pageX + 10) + "px")
                        .style("top", (event.pageY - 28) + "px");
                })
                .on("mouseout", function(d) {
                    tooltip.transition()
                        .duration(500)
                        .style("opacity", 0);
                });

            svg.append("g")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x))
                .selectAll("text")
                .style("text-anchor", "end")
                .attr("dx", "-.8em")
                .attr("dy", ".15em")
                .attr("transform", "rotate(-45)");

            svg.append("g")
                .call(d3.axisLeft(y));

            svg.append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 0 - margin.left)
                .attr("x", 0 - (height / 2))
                .attr("dy", "1em")
                .style("text-anchor", "middle")
                .text("Número de Contratos");
        }

        // Gráfico de Estado de Pagos (Donut Chart)
        function createPaymentStatusChart() {
            const width = 250;
            const height = 350;
            const radius = Math.min(width, height) / 3;

            const svg = d3.select("#payment-status-chart")
                .append("svg")
                .attr("width", width)
                .attr("height", height)
                .append("g")
                .attr("transform", `translate(${width/2},${height/2 - 50})`);

            const color = d3.scaleOrdinal()
                .domain(dashboardData.paymentStatus.map(d => d.status))
                .range(["#28a745", "#ffc107", "#dc3545"]);

            const pie = d3.pie()
                .value(d => d.count);

            const arc = d3.arc()
                .innerRadius(radius * 0.5)
                .outerRadius(radius);

            const arcs = svg.selectAll(".arc")
                .data(pie(dashboardData.paymentStatus))
                .enter().append("g")
                .attr("class", "arc");

            arcs.append("path")
                .attr("d", arc)
                .attr("fill", d => color(d.data.status));

            arcs.append("text")
                .attr("transform", d => `translate(${arc.centroid(d)})`)
                .attr("text-anchor", "middle")
                .text(d => d.data.count)
                .style("font-size", "12px")
                .style("font-weight", "bold")
                .style("fill", "white");

            // Leyenda
            const legend = svg.append("g")
                .attr("class", "legend")
                .attr("transform", `translate(-${width/2 - 20}, ${radius + 30})`);

            const legendItems = legend.selectAll(".legend-item")
                .data(dashboardData.paymentStatus)
                .enter().append("g")
                .attr("class", "legend-item")
                .attr("transform", (d, i) => `translate(0, ${i * 25})`);

            legendItems.append("rect")
                .attr("width", 15)
                .attr("height", 15)
                .attr("fill", d => color(d.status));

            legendItems.append("text")
                .attr("x", 20)
                .attr("y", 12)
                .text(d => `${d.status}: ${d.count}`)
                .style("font-size", "12px");
        }

        // Gráfico de Tendencia de Ocupación
        function createOccupancyTrendChart() {
            const margin = {top: 20, right: 30, bottom: 40, left: 50};
            const width = 900 - margin.left - margin.right;
            const height = 400 - margin.top - margin.bottom;

            const svg = d3.select("#occupancy-trend-chart")
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform", `translate(${margin.left},${margin.top})`);

            const x = d3.scaleBand()
                .domain(dashboardData.occupancyTrend.map(d => d.month))
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(dashboardData.occupancyTrend, d => d.total)])
                .range([height, 0]);

            // Barras totales
            svg.selectAll(".bar-total")
                .data(dashboardData.occupancyTrend)
                .enter().append("rect")
                .attr("class", "bar-total")
                .attr("x", d => x(d.month))
                .attr("width", x.bandwidth())
                .attr("y", d => y(d.total))
                .attr("height", d => height - y(d.total))
                .attr("fill", "#e9ecef");

            // Barras ocupadas
            svg.selectAll(".bar-occupied")
                .data(dashboardData.occupancyTrend)
                .enter().append("rect")
                .attr("class", "bar-occupied")
                .attr("x", d => x(d.month))
                .attr("width", x.bandwidth())
                .attr("y", d => y(d.occupied))
                .attr("height", d => height - y(d.occupied))
                .attr("fill", "#007bff");

            // Línea de porcentaje de ocupación
            const line = d3.line()
                .x(d => x(d.month) + x.bandwidth() / 2)
                .y(d => y(d.occupied / d.total * d.total));

            svg.append("path")
                .datum(dashboardData.occupancyTrend)
                .attr("class", "line")
                .attr("d", line)
                .attr("stroke", "#dc3545")
                .attr("stroke-width", 3)
                .attr("fill", "none");

            // Puntos en la línea
            svg.selectAll(".dot")
                .data(dashboardData.occupancyTrend)
                .enter().append("circle")
                .attr("class", "dot")
                .attr("cx", d => x(d.month) + x.bandwidth() / 2)
                .attr("cy", d => y(d.occupied))
                .attr("r", 4)
                .attr("fill", "#dc3545");

            // Etiquetas de porcentaje
            svg.selectAll(".percentage-label")
                .data(dashboardData.occupancyTrend)
                .enter().append("text")
                .attr("class", "percentage-label")
                .attr("x", d => x(d.month) + x.bandwidth() / 2)
                .attr("y", d => y(d.occupied) - 10)
                .attr("text-anchor", "middle")
                .text(d => Math.round(d.occupied / d.total * 100) + "%")
                .style("font-size", "11px")
                .style("font-weight", "bold");

            svg.append("g")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x));

            svg.append("g")
                .call(d3.axisLeft(y));

            svg.append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 0 - margin.left)
                .attr("x", 0 - (height / 2))
                .attr("dy", "1em")
                .style("text-anchor", "middle")
                .text("Número de Propiedades");

            // Leyenda
            const legend = svg.append("g")
                .attr("class", "legend")
                .attr("transform", `translate(${width - 150}, 20)`);

            legend.append("rect")
                .attr("x", 0)
                .attr("y", 0)
                .attr("width", 15)
                .attr("height", 15)
                .attr("fill", "#007bff");

            legend.append("text")
                .attr("x", 20)
                .attr("y", 12)
                .text("Ocupadas");

            legend.append("rect")
                .attr("x", 0)
                .attr("y", 20)
                .attr("width", 15)
                .attr("height", 15)
                .attr("fill", "#e9ecef");

            legend.append("text")
                .attr("x", 20)
                .attr("y", 32)
                .text("Total");
        }

        // Inicializar dashboard
        document.addEventListener('DOMContentLoaded', function() {
            updateMetrics();
            createIncomeExpensesChart();
            createPropertyDistributionChart();
            createContractExpirationChart();
            createPaymentStatusChart();
            createOccupancyTrendChart();
        });
    </script>
@stop
