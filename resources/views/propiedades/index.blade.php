@extends('adminlte::page')

@section('title', 'Propiedades')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestión de Propiedades</h1>
        <div>
            <button class="btn btn-info mr-2" onclick="toggleMapView()">
                <i class="fas fa-map" id="map-toggle-icon"></i> <span id="map-toggle-text">Ver Mapa</span>
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addPropertyModal">
                <i class="fas fa-plus"></i> Nueva Propiedad
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <!-- Vista de Mapa -->
        <div class="col-md-12" id="map-container" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mapa de Propiedades</h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-secondary" onclick="centerMap()">
                            <i class="fas fa-crosshairs"></i> Centrar Mapa
                        </button>
                        <button class="btn btn-sm btn-info" onclick="toggleMapFullscreen()">
                            <i class="fas fa-expand"></i> Pantalla Completa
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="property-map" style="height: 600px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="table-container">
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
                                <select class="form-control" id="filter-type" onchange="filterProperties()">
                                    <option value="">Todos</option>
                                    <option value="departamento">Departamento</option>
                                    <option value="casa">Casa</option>
                                    <option value="local">Local Comercial</option>
                                    <option value="oficina">Oficina</option>
                                    <option value="loft">Loft</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" id="filter-status" onchange="filterProperties()">
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
                                <input type="text" class="form-control" id="filter-location" placeholder="Buscar por ubicación" onkeyup="filterProperties()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rango de Precio</label>
                                <select class="form-control" id="filter-price" onchange="filterProperties()">
                                    <option value="">Todos</option>
                                    <option value="0-50000">$0 - $50,000</option>
                                    <option value="50000-100000">$50,000 - $100,000</option>
                                    <option value="100000-150000">$100,000 - $150,000</option>
                                    <option value="150000+">$150,000+</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="properties-grid">
        <!-- Lista de Propiedades -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Propiedades</h3>
                    <div class="card-tools">
                        <button class="btn btn-sm btn-success" onclick="exportProperties()">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                    </div>
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
                                    <th>Ubicación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de ejemplo con coordenadas -->
                                <tr data-lat="-34.6037" data-lng="-58.3816" data-type="departamento" data-status="ocupada" data-price="45000">
                                    <td>001</td>
                                    <td>Av. Corrientes 1234, CABA</td>
                                    <td><span class="badge badge-info">Departamento</span></td>
                                    <td><span class="badge badge-success">Ocupada</span></td>
                                    <td>$45,000</td>
                                    <td>Juan Pérez</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary" onclick="showOnMap(-34.6037, -58.3816)">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </button>
                                    </td>
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
                                <tr data-lat="-34.5631" data-lng="-58.4544" data-type="casa" data-status="disponible" data-price="65000">
                                    <td>002</td>
                                    <td>San Martín 567, Belgrano</td>
                                    <td><span class="badge badge-primary">Casa</span></td>
                                    <td><span class="badge badge-warning">Disponible</span></td>
                                    <td>$65,000</td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary" onclick="showOnMap(-34.5631, -58.4544)">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </button>
                                    </td>
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
                                <tr data-lat="-34.6118" data-lng="-58.3960" data-type="local" data-status="ocupada" data-price="80000">
                                    <td>003</td>
                                    <td>Florida 890, Microcentro</td>
                                    <td><span class="badge badge-success">Local Comercial</span></td>
                                    <td><span class="badge badge-success">Ocupada</span></td>
                                    <td>$80,000</td>
                                    <td>María González</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary" onclick="showOnMap(-34.6118, -58.3960)">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </button>
                                    </td>
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
                                <tr data-lat="-34.5895" data-lng="-58.3974" data-type="loft" data-status="disponible" data-price="120000">
                                    <td>004</td>
                                    <td>Puerto Madero 123, CABA</td>
                                    <td><span class="badge badge-dark">Loft</span></td>
                                    <td><span class="badge badge-warning">Disponible</span></td>
                                    <td>$120,000</td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary" onclick="showOnMap(-34.5895, -58.3974)">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewProperty(4)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editProperty(4)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProperty(4)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr data-lat="-34.6158" data-lng="-58.3731" data-type="oficina" data-status="mantenimiento" data-price="55000">
                                    <td>005</td>
                                    <td>Av. 9 de Julio 456, CABA</td>
                                    <td><span class="badge badge-secondary">Oficina</span></td>
                                    <td><span class="badge badge-danger">En Mantenimiento</span></td>
                                    <td>$55,000</td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary" onclick="showOnMap(-34.6158, -58.3731)">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewProperty(5)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editProperty(5)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProperty(5)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr data-lat="-34.5708" data-lng="-58.4370" data-type="loft" data-status="ocupada" data-price="95000">
                                    <td>006</td>
                                    <td>Palermo Soho 789, CABA</td>
                                    <td><span class="badge badge-dark">Loft</span></td>
                                    <td><span class="badge badge-success">Ocupada</span></td>
                                    <td>$95,000</td>
                                    <td>Carlos Rodríguez</td>
                                    <td>
                                        <button class="btn btn-xs btn-outline-primary" onclick="showOnMap(-34.5708, -58.4370)">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="viewProperty(6)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editProperty(6)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteProperty(6)">
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
        <div class="modal-dialog modal-xl" role="document">
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
                            <div class="col-md-8">
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
                                                <option value="loft">Loft</option>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Latitud</label>
                                            <input type="number" class="form-control" name="latitude" step="any" placeholder="-34.6037">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Longitud</label>
                                            <input type="number" class="form-control" name="longitude" step="any" placeholder="-58.3816">
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Seleccionar Ubicación en el Mapa</label>
                                    <div id="location-picker-map" style="height: 300px; width: 100%;"></div>
                                    <small class="text-muted">Haz clic en el mapa para seleccionar la ubicación</small>
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

@section('css')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .leaflet-popup-content {
            font-size: 14px;
        }

        .property-popup {
            min-width: 200px;
        }

        .property-popup h6 {
            margin-bottom: 5px;
            color: #333;
        }

        .property-popup .badge {
            font-size: 11px;
        }

        .map-fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 9999 !important;
            background: white;
        }

        .map-fullscreen #property-map {
            height: 100vh !important;
        }

        .marker-cluster-small {
            background-color: rgba(181, 226, 140, 0.6);
        }

        .marker-cluster-small div {
            background-color: rgba(110, 204, 57, 0.6);
        }

        .marker-cluster-medium {
            background-color: rgba(241, 211, 87, 0.6);
        }

        .marker-cluster-medium div {
            background-color: rgba(240, 194, 12, 0.6);
        }

        .marker-cluster-large {
            background-color: rgba(253, 156, 115, 0.6);
        }

        .marker-cluster-large div {
            background-color: rgba(241, 128, 23, 0.6);
        }
    </style>
@stop

@section('js')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet MarkerCluster Plugin -->
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

    <script>
        let map;
        let locationPickerMap;
        let markers = [];
        let markerClusterGroup;
        let selectedMarker;
        let isMapVisible = false;
        let isFullscreen = false;

        // Datos de propiedades
        const properties = [
            {
                id: 1,
                address: 'Av. Corrientes 1234, CABA',
                type: 'Departamento',
                status: 'Ocupada',
                price: 45000,
                tenant: 'Juan Pérez',
                lat: -34.6037,
                lng: -58.3816
            },
            {
                id: 2,
                address: 'San Martín 567, Belgrano',
                type: 'Casa',
                status: 'Disponible',
                price: 65000,
                tenant: null,
                lat: -34.5631,
                lng: -58.4544
            },
            {
                id: 3,
                address: 'Florida 890, Microcentro',
                type: 'Local Comercial',
                status: 'Ocupada',
                price: 80000,
                tenant: 'María González',
                lat: -34.6118,
                lng: -58.3960
            },
            {
                id: 4,
                address: 'Puerto Madero 123, CABA',
                type: 'Loft',
                status: 'Disponible',
                price: 120000,
                tenant: null,
                lat: -34.5895,
                lng: -58.3974
            },
            {
                id: 5,
                address: 'Av. 9 de Julio 456, CABA',
                type: 'Oficina',
                status: 'En Mantenimiento',
                price: 55000,
                tenant: null,
                lat: -34.6158,
                lng: -58.3731
            },
            {
                id: 6,
                address: 'Palermo Soho 789, CABA',
                type: 'Loft',
                status: 'Ocupada',
                price: 95000,
                tenant: 'Carlos Rodríguez',
                lat: -34.5708,
                lng: -58.4370
            }
        ];

        function initializeMap() {
            // Inicializar mapa principal
            map = L.map('property-map').setView([-34.6037, -58.3816], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Inicializar cluster de marcadores
            markerClusterGroup = L.markerClusterGroup({
                chunkedLoading: true,
                maxClusterRadius: 50
            });

            // Agregar marcadores
            addMarkersToMap();

            map.addLayer(markerClusterGroup);
        }

        function initializeLocationPickerMap() {
            // Inicializar mapa para seleccionar ubicación
            locationPickerMap = L.map('location-picker-map').setView([-34.6037, -58.3816], 12);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(locationPickerMap);

            // Agregar evento de clic para seleccionar ubicación
            locationPickerMap.on('click', function(e) {
                if (selectedMarker) {
                    locationPickerMap.removeLayer(selectedMarker);
                }

                selectedMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(locationPickerMap);

                // Actualizar campos de latitud y longitud
                $('input[name="latitude"]').val(e.latlng.lat.toFixed(6));
                $('input[name="longitude"]').val(e.latlng.lng.toFixed(6));
            });
        }

        function addMarkersToMap() {
            properties.forEach(property => {
                const marker = createPropertyMarker(property);
                markerClusterGroup.addLayer(marker);
                markers.push(marker);
            });
        }

        function createPropertyMarker(property) {
            // Definir colores según el estado
            const statusColors = {
                'Ocupada': '#28a745',
                'Disponible': '#ffc107',
                'En Mantenimiento': '#dc3545'
            };

            // Crear icono personalizado
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background-color: ${statusColors[property.status] || '#6c757d'};
                              width: 25px; height: 25px; border-radius: 50%;
                              border: 3px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                              display: flex; align-items: center; justify-content: center;">
                         <i class="fas fa-home" style="color: white; font-size: 12px;"></i>
                       </div>`,
                iconSize: [25, 25],
                iconAnchor: [12, 12]
            });

            const marker = L.marker([property.lat, property.lng], { icon: icon });

            // Crear popup
            const popupContent = `
                <div class="property-popup">
                    <h6><strong>${property.address}</strong></h6>
                    <p><span class="badge badge-info">${property.type}</span>
                       <span class="badge badge-${getStatusBadgeClass(property.status)}">${property.status}</span></p>
                    <p><strong>Precio:</strong> $${property.price.toLocaleString()}</p>
                    ${property.tenant ? `<p><strong>Inquilino:</strong> ${property.tenant}</p>` : ''}
                    <div class="mt-2">
                        <button class="btn btn-sm btn-info" onclick="viewProperty(${property.id})">
                            <i class="fas fa-eye"></i> Ver
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editProperty(${property.id})">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
            return marker;
        }

        function getStatusBadgeClass(status) {
            switch(status) {
                case 'Ocupada': return 'success';
                case 'Disponible': return 'warning';
                case 'En Mantenimiento': return 'danger';
                default: return 'secondary';
            }
        }

        function toggleMapView() {
            const mapContainer = document.getElementById('map-container');
            const tableContainer = document.getElementById('table-container');
            const propertiesGrid = document.getElementById('properties-grid');
            const toggleIcon = document.getElementById('map-toggle-icon');
            const toggleText = document.getElementById('map-toggle-text');

            if (isMapVisible) {
                // Ocultar mapa, mostrar tabla
                mapContainer.style.display = 'none';
                tableContainer.style.display = 'block';
                propertiesGrid.style.display = 'block';
                toggleIcon.className = 'fas fa-map';
                toggleText.textContent = 'Ver Mapa';
                isMapVisible = false;
            } else {
                // Mostrar mapa, ocultar tabla
                mapContainer.style.display = 'block';
                tableContainer.style.display = 'none';
                propertiesGrid.style.display = 'none';
                toggleIcon.className = 'fas fa-table';
                toggleText.textContent = 'Ver Tabla';
                isMapVisible = true;

                // Inicializar mapa si no existe
                if (!map) {
                    setTimeout(initializeMap, 100);
                } else {
                    setTimeout(() => map.invalidateSize(), 100);
                }
            }
        }

        function toggleMapFullscreen() {
            const mapContainer = document.getElementById('map-container');

            if (isFullscreen) {
                mapContainer.classList.remove('map-fullscreen');
                isFullscreen = false;
            } else {
                mapContainer.classList.add('map-fullscreen');
                isFullscreen = true;
            }

            setTimeout(() => map.invalidateSize(), 100);
        }

        function centerMap() {
            if (map) {
                map.setView([-34.6037, -58.3816], 12);
            }
        }

        function showOnMap(lat, lng) {
            if (!isMapVisible) {
                toggleMapView();
            }

            setTimeout(() => {
                if (map) {
                    map.setView([lat, lng], 16);

                    // Encontrar y abrir el popup del marcador
                    markers.forEach(marker => {
                        const markerLatLng = marker.getLatLng();
                        if (Math.abs(markerLatLng.lat - lat) < 0.001 && Math.abs(markerLatLng.lng - lng) < 0.001) {
                            marker.openPopup();
                        }
                    });
                }
            }, 500);
        }

        function filterProperties() {
            const typeFilter = document.getElementById('filter-type').value;
            const statusFilter = document.getElementById('filter-status').value;
            const locationFilter = document.getElementById('filter-location').value.toLowerCase();
            const priceFilter = document.getElementById('filter-price').value;

            // Filtrar tabla
            const table = document.getElementById('properties-table');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            Array.from(rows).forEach(row => {
                const type = row.getAttribute('data-type');
                const status = row.getAttribute('data-status');
                const price = parseInt(row.getAttribute('data-price'));
                const address = row.cells[1].textContent.toLowerCase();

                let showRow = true;

                // Filtro por tipo
                if (typeFilter && type !== typeFilter) {
                    showRow = false;
                }

                // Filtro por estado
                if (statusFilter && status !== statusFilter) {
                    showRow = false;
                }

                // Filtro por ubicación
                if (locationFilter && !address.includes(locationFilter)) {
                    showRow = false;
                }

                // Filtro por precio
                if (priceFilter) {
                    const [min, max] = priceFilter.split('-').map(p => p.replace('+', ''));
                    const minPrice = parseInt(min);
                    const maxPrice = max ? parseInt(max) : Infinity;

                    if (price < minPrice || price > maxPrice) {
                        showRow = false;
                    }
                }

                row.style.display = showRow ? '' : 'none';
            });

            // Filtrar marcadores en el mapa
            if (map && markerClusterGroup) {
                markerClusterGroup.clearLayers();

                const filteredProperties = properties.filter(property => {
                    let include = true;

                    if (typeFilter && property.type.toLowerCase() !== typeFilter) {
                        include = false;
                    }

                    if (statusFilter && property.status.toLowerCase() !== statusFilter) {
                        include = false;
                    }

                    if (locationFilter && !property.address.toLowerCase().includes(locationFilter)) {
                        include = false;
                    }

                    if (priceFilter) {
                        const [min, max] = priceFilter.split('-').map(p => p.replace('+', ''));
                        const minPrice = parseInt(min);
                        const maxPrice = max ? parseInt(max) : Infinity;

                        if (property.price < minPrice || property.price > maxPrice) {
                            include = false;
                        }
                    }

                    return include;
                });

                filteredProperties.forEach(property => {
                    const marker = createPropertyMarker(property);
                    markerClusterGroup.addLayer(marker);
                });
            }
        }

        function viewProperty(id) {
            console.log('Ver propiedad:', id);
            // Implementar vista de propiedad
        }

        function editProperty(id) {
            console.log('Editar propiedad:', id);
            // Implementar edición de propiedad
        }

        function deleteProperty(id) {
            if (confirm('¿Está seguro de que desea eliminar esta propiedad?')) {
                console.log('Eliminar propiedad:', id);
                // Implementar eliminación
            }
        }

        function saveProperty() {
            console.log('Guardando propiedad...');
            $('#addPropertyModal').modal('hide');
            // Implementar guardado de propiedad
        }

        function exportProperties() {
            console.log('Exportando propiedades...');
            // Implementar exportación
        }

        $(document).ready(function() {
            // Inicializar DataTable
            $('#properties-table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "pageLength": 10,
                "responsive": true
            });

            // Inicializar mapa del modal cuando se abre
            $('#addPropertyModal').on('shown.bs.modal', function () {
                if (!locationPickerMap) {
                    setTimeout(initializeLocationPickerMap, 100);
                } else {
                    setTimeout(() => locationPickerMap.invalidateSize(), 100);
                }
            });

            // Limpiar formulario cuando se cierra el modal
            $('#addPropertyModal').on('hidden.bs.modal', function () {
                document.getElementById('property-form').reset();
                if (selectedMarker && locationPickerMap) {
                    locationPickerMap.removeLayer(selectedMarker);
                    selectedMarker = null;
                }
            });
        });
    </script>
@stop
