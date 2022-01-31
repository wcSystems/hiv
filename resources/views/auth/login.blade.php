
@extends('layouts.auth')
@section('content')
    <div class="login login-with-news-feed">
        <div class="news-feed">
            <div class="news-image" style="background-image: url('{{ asset('img/login-bg/login-bg-11.jpg') }} ')"></div>
            <div class="news-caption">
                <h4 class="caption-title"><b>HOTEL INTERNACIONAL VALENCIA</b></h4>
                <p>Administracion de equipos conectados a la red de Sistemas</p>
            </div>
        </div>
        <div class="right-content">
            <div class="login-header">
                <div class="brand">
                    <small>Ingrese sus Credenciales</small>
                </div>
                <div class="icon">
                    <i class="fa fa-sign-in"></i>
                </div>
            </div>
            <div class="login-content">
                <form method="POST" action="{{ route('login') }}" class="margin-bottom-0">
                    @csrf
                    <div class="form-group m-b-15">
                        <input type="text" name="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" placeholder="Usuario" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group m-b-15">
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Contraseña" required autocomplete="current-password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="login-buttons">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
