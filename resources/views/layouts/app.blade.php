<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Sistemas HIV</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        :root {

            /* COLORES DEFAULT */
            /*   --global-1: none !important;        Fondo Template        */
            /*   --global-2: #fff !important;        Fondo Tablas          */
            /*   --global-4: #000 !important;        Color textos tabla    */
            /*   --global-6: #7ef067 !important;     Color primario        */

            --global-2: <?= ( $palette_colors ) ? $palette_colors->color_primary : 'rgba(255.255.255,0.1)'; ?> !important;
            --global-4: <?= ( $palette_colors ) ? $palette_colors->color_secondary : '#000'; ?> !important;
            --global-6: <?= ( $palette_colors ) ? $palette_colors->color_tertiary : '#5c5c5c'; ?> !important;
            --global-7: rgba(38,38,38,.95) !important;
        }
    </style>
    <link href="{{ asset('css/transparent/app.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/sweetalert/dist/sweetalert.min.css') }}" rel="stylesheet">
    @yield('css')

    {{-- ESTILOS DE CONFIGURACION GLOBAL - SEPARAR EN ARCHIVO- --}}
    <style>
        ::placeholder { color: var(--global-2) !important; opacity: 1; }
        :-ms-input-placeholder {  color: var(--global-2) !important; }
        ::-ms-input-placeholder { color: var(--global-2) !important; }
        .btn-1{
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex !important;
            justify-content: space-around;
        }
        .banner-icons{
            justify-content: space-between !important
        }
        .parsley-normal{
            border-color: var(--global-2) !important
        }
        .right-content{
            background-color: var(--global-6) !important
        }
        .navbar-brand:hover{
            color: var(--global-6) !important
        }
        .sidebar{
            background-color: var(--global-7) !important
        }
        #data-table-default_wrapper > .row:first-child{
            display: none !important;
        }
        .dataTables_paginate,.paging_simple_numbers{
            display: none !important;
        }
    </style>

</head>
<body>
    <div class="page-cover" style="background-image: url('{{ asset('img/login-bg/login-bg-11.jpg') }}');"></div>
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <div id="header" class="header navbar-default">
            <div class="navbar-header">
                <a class="navbar-brand"><b>SISTEMAS </b></a>
                <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <ul class="navbar-nav navbar-right">
                <li class="dropdown navbar-user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="image image-icon bg-black text-grey-darker">
                            <i class="fa fa-user"></i>
                        </div>
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span> <b class="caret"></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div id="sidebar" class="sidebar">

            <div data-scrollbar="true" data-height="100%" class="banner-icons">
                <ul class="nav " data-click="pr-0">
                    <li class="nav-header" style="color: #fff !important">MENÚ</li>

                    <li id="devices_nav" class="has-sub closed">
                        <a href="{{ route('devices') }}">
                            <i class="fas fa-desktop fa-lg text-white"></i>
                            <span class="text-white">DISPOSITIVOS</span>
                        </a>
                    </li>

                    <li id="teams_nav" class="has-sub closed">
                        <a href="{{ route('teams') }}">
                            <i class="fas fa-desktop fa-lg text-white"></i>
                            <span class="text-white">EQUIPOS</span>
                        </a>
                    </li>

                    <li id="diagrams_nav" class="has-sub closed">
                        <a href="{{ route('diagrams') }}">
                            <i class="fas fa-desktop fa-lg text-white"></i>
                            <span class="text-white">DIAGRAMA</span>
                        </a>
                    </li>

                    {{-- <li id="users_nav" class="has-sub closed">
                        <a href="{{ route('users') }}">
                            <i class="fa fa-users fa-lg text-white"></i>
                            <span class="text-white">USUARIOS</span>
                        </a>
                    </li> --}}

                    {{-- <li id="blocks_nav" class="has-sub closed">
                        <a href="{{ route('blocks') }}">
                            <i class="fas fa-cubes fa-lg text-white"></i>
                            <span class="text-white">BLOQUES</span>
                        </a>
                    </li>

                    <li id="types_nav" class="has-sub closed">
                        <a href="{{ route('types') }}">
                            <i class="fas fa-server fa-lg text-white"></i>
                            <span class="text-white">TIPOS DE DISPOSITIVOS</span>
                        </a>
                    </li>
                    <li id="networks_nav" class="has-sub closed">
                        <a href="{{ route('networks') }}">
                            <i class="fas fa-network-wired fa-lg text-white"></i>
                            <span class="text-white">NODOS</span>
                        </a>
                    </li>

                    <li id="palette_colors_nav" class="has-sub closed">
                        <a href="{{ route('palette_colors') }}">
                            <i class="fas fa-palette fa-lg text-white"></i>
                            <span class="text-white">COLORES</span>
                        </a>
                    </li> --}}

                </ul>
            </div>

        </div>
        <div class="sidebar-bg"></div>
        <div id="content" class="content">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/theme/transparent.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/min/moment.min.js') }}"></script>

    {{-- pasar estos script aparte para que sean globales --}}
    <script>
        function dataTable(url,columns) {
            $(document).ready(function() {
                let table = $('#data-table-default').DataTable({
                    searching: false,
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    lengthChange: true,
                    columns: columns,
                    ajax: {
                        "url": url,
                        "data": function (d) {[
                            d.search = $('#search').val(),
                            d.search_network = $('#search_network').val(),
                            d.search_type = $('#search_type').val(),
                            d.search_block = $('#search_block').val(),
                        ]}
                    },
                    columnDefs: [
                        {
                            orderable: false,
                            targets: 1
                        }
                    ],
                    language: {
                        "lengthMenu": "Mostrar _MENU_ registros por página",
                        "emptyTable":  "Sin datos disponibles",
                        "zeroRecords": "Ningun resultado encontrado",
                        "info": "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
                        "infoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "infoEmpty": "Ningun valor disponible",
                        "loadingRecords": "Cargando...",
                        "processing":     "Procesando...",
                        "paginate": {
                            "first":      "Primero",
                            "last":       "Ultimo",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        },
                    }
                }).on( 'processing.dt', function ( e, settings, processing ) {
                    if(processing){ }else{ }
                });
                $("#search").blur( () =>{ $('#data-table-default').DataTable().ajax.reload() });
                $("#search_network").change( () =>{ $('#data-table-default').DataTable().ajax.reload() });
                $("#search_type").change( () =>{ $('#data-table-default').DataTable().ajax.reload() });
                $("#search_block").change( () =>{ $('#data-table-default').DataTable().ajax.reload() });
            });
        }
    </script>
    @yield('js')
</body>
</html>
