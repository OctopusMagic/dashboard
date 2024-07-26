@extends('layouts.app')

@include('layouts.navbar')
@section('content')
    <div class="loading-overlay d-none" id="loadingOverlay">
        <div class="spinner-border text-white" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between">
                            <h1>{{ $datos_empresa['nombre'] }}</h1>
                            <button type="button" class="btn btn-warning btn-lg" id="reenviarContingencia">Reenviar
                                Documentos en Contingencia</button>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-6">
                                <b>NIT: </b> {{ $datos_empresa['nit'] }}<br>
                                <b>NRC: </b> {{ $datos_empresa['nrc'] }}<br>
                                <b>Nombre Comercial: </b> {{ $datos_empresa['nombreComercial'] }}<br>
                                <b>Giro: </b> {{ $datos_empresa['descActividad'] }}<br>
                                <b>Dirección: </b> {{ $datos_empresa['complemento'] }}<br>
                                <b>Teléfono: </b> {{ $datos_empresa['telefono'] }}<br>
                                <b>Correo Electrónico: </b> {{ $datos_empresa['correo'] }}<br>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-2 ">
                                    <div class="card-body bg-light shadow text-start">
                                        <h2 class="card-title">Estadísticas totales: </h2>
                                        <hr>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a class="text-black text-decoration-none mb-2"
                                                            href="/invoices">
                                                            <i class="me-3 fa fa-file text-info"></i> Documentos
                                                            Generados:
                                                        </a>
                                                    </td>
                                                    <td>{{ $statistics['total'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a class="text-black text-decoration-none mb-2"
                                                            href="/invoices?type=ANULADO">
                                                            <i class="me-3 fa fa-file text-secondary"></i> Documentos
                                                            Anulados:
                                                        </a>
                                                    </td>
                                                    <td>{{ $statistics['anulado'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a class="text-black text-decoration-none mb-2"
                                                            href="/invoices?type=PROCESADO">
                                                            <i class="me-3 fa fa-file text-success"></i> Documentos
                                                            Enviados:
                                                        </a>
                                                    </td>
                                                    <td>{{ $statistics['approved'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a class="text-black text-decoration-none mb-2"
                                                            href="/invoices?type=RECHAZADO">
                                                            <i class="me-3 fa fa-file text-danger"></i> Documentos
                                                            Rechazados:
                                                        </a>
                                                    </td>
                                                    <td>{{ $statistics['rejected'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a class="text-black text-decoration-none mb-2"
                                                            href="/invoices?type=CONTINGENCIA">
                                                            <i class="me-3 fa fa-file text-warning"></i> Documentos en
                                                            Contingencia:
                                                        </a>
                                                    </td>
                                                    <td>{{ $statistics['contingencia'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <i class="me-3 fa fa-sack-dollar text-success"></i> Total
                                                        Facturado:
                                                    </td>
                                                    <td>${{ number_format($statistics['total_facturado'], 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                        <h2>Datos del día {{ \Carbon\Carbon::parse(now())->format('d/m/Y') }}</h2>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 text-center">
                        <a href="/invoices?fecha={{ date('Y-m-d') }}" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file text-info fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics_today['total'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Generados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=ANULADO&fecha={{ date('Y-m-d') }}" class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-minus text-secondary fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics_today['anulado'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Anulados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=PROCESADO&fecha={{ date('Y-m-d') }}"
                            class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-check text-success fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics_today['approved'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Enviados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=RECHAZADO&fecha={{ date('Y-m-d') }}"
                            class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-xmark text-danger fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics_today['rejected'] }}</h2>
                                        <p class="card-text h6">Documentos<br>Rechazados</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-2 text-center">
                        <a href="/invoices?type=CONTINGENCIA&fecha={{ date('Y-m-d') }}"
                            class="card mb-2 text-decoration-none">
                            <div class="card-body bg-light btn shadow">
                                <div class="row py-2 justify-content-center">
                                    <div class="col-3">
                                        <br>
                                        <i class="fas fa-file-circle-exclamation text-warning fa-4x fa-4x"></i>
                                    </div>
                                    <div class="col-9">
                                        <h2 class="card-title">{{ $statistics_today['contingencia'] }}</h2>
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
                                        <h5 class="card-title">
                                            ${{ number_format($statistics_today['total_facturado'], 2) }}</h5>
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
    @vite('resources/js/dashboard.js')
@endsection
