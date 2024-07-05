@extends('layouts.app')

@include('layouts.navbar')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h1>{{ $datos_empresa['nombre'] }}</h1>
                        <hr>
                        <b>NIT: </b> {{ $datos_empresa['nit'] }}<br>
                        <b>NRC: </b> {{ $datos_empresa['nrc'] }}<br>
                        <b>Nombre Comercial: </b> {{ $datos_empresa['nombreComercial'] }}<br>
                        <b>Giro: </b> {{ $datos_empresa['descActividad'] }}<br>
                        <b>Dirección: </b> {{ $datos_empresa['complemento'] }}<br>
                        <b>Teléfono: </b> {{ $datos_empresa['telefono'] }}<br>
                        <b>Correo Electrónico: </b> {{ $datos_empresa['correo'] }}<br>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-md-2 text-center">
                        <a href="/invoices" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file text-info fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics['total'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Generados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=ANULADO" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-minus text-secondary fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics['anulado'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Anulados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=PROCESADO" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-check text-success fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics['approved'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Enviados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=RECHAZADO" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-xmark text-danger fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics['rejected'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Rechazados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=CONTINGENCIA" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-exclamation text-warning fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics['contingencia'] }}</h2>
                                        <p class="card-text h6">Documentos<br>en Contingencia</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-sack-dollar text-success fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h5 class="card-title">${{ number_format($statistics['total_facturado'], 2) }}</h5>
                                        <p class="card-text h6">Total<br>Facturado</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
