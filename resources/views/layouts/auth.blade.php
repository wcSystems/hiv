<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FullStack DEVELOPER</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('css/transparent/app.min.css') }}" rel="stylesheet" />
    <style>
        :root {

            /* COLORES DEFAULT */
            /*   --global-1: none !important;        Fondo Template        */     
            /*   --global-2: #fff !important;        Fondo Tablas          */     
            /*   --global-4: #000 !important;        Color textos tabla    */     
            /*   --global-6: #7ef067 !important;     Color primario        */
            
            --global-2: <?= ( $palette_colors ) ? $palette_colors->color_primary : '#FFFFFFF2'; ?> !important;       
            --global-4: <?= ( $palette_colors ) ? $palette_colors->color_secondary : '#000'; ?> !important;        
            --global-6: <?= ( $palette_colors ) ? $palette_colors->color_tertiary : '#5c5c5c'; ?> !important;
        }
        .right-content{
            background-color: var(--global-6) !important
        }
        .form-control{
            border-color: var(--global-2) !important
        }
        ::-webkit-input-placeholder { color: var(--global-2) !important } 
        :-moz-placeholder { color: var(--global-2) !important } 
        ::-moz-placeholder { color: var(--global-2) !important } 
        :-ms-input-placeholder { color: var(--global-2) !important }
        .brand > small{
            color: var(--global-2) !important
        }
        .btn-primary {
            color: var(--global-2) !important;
            background-color: transparent !important;
            border-color: var(--global-2) !important;
            -webkit-box-shadow: 0;
            box-shadow: 0;
        }
    </style>
</head>
<body class="pace-top bg-black-darker">
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <div id="page-container" class="fade page-container">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/theme/transparent.min.js') }}"></script>
</body>
</html>