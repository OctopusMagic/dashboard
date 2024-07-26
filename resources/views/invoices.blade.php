@extends('layouts.app')
@php
    $tiposDte = [
        '01' => 'Factura Electrónica',
        '03' => 'Crédito Fiscal',
        '05' => 'Nota de Crédito',
        '07' => 'Comprobante de Retención',
        '11' => 'Factura de Exportación',
        '14' => 'Factura de Sujeto Excluido',
    ];

    $receptores_nit = ['03', '05'];
    $receptores_num = ['01', '07', '11', '14'];
@endphp
@include('layouts.navbar')
@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar'
                });
            </script>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row mt-5 mb-2">
                    <div class="col-md-12">
                        <div class="header-content">
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <h1 class="header-title text-center">
                                        Documentos Emitidos
                                        @if($fecha)
                                            : {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                                        @endif
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <table class="table table-bordered table-hover table-striped w-100 align-middle" id="invoicesTable">
                        <thead>
                            <tr class="align-middle text-center">
                                <th style="width: 5%;">ID</th>
                                <th style="width: 10%;">Tipo de Documento</th>
                                <th style="width: 15%;">Información Hacienda</th>
                                <th style="width: 15%;">Información Receptor</th>
                                <th style="width: 10%;">Fecha Procesamiento</th>
                                <th style="width: 10%;">Estado</th>
                                <th style="width: 15%;">Observaciones</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                @if ($invoice['estado'] == 'RECHAZADO')
                                    <tr class="table-danger">
                                    @elseif ($invoice['estado'] == 'CONTINGENCIA')
                                    <tr class="table-warning">
                                    @else
                                    <tr>
                                @endif
                                <td>{{ $invoice['id'] }}</td>
                                <td>{{ $tiposDte[$invoice['tipo_dte']] }}</td>
                                <td class="small">
                                    <p>
                                        <strong>Código Generacion:</strong><br>{{ $invoice['codGeneracion'] }}<br>
                                        <strong>Número de
                                            Control:</strong><br>{{ $invoice['documento']->identificacion->numeroControl }}<br>
                                        @if ($invoice['selloRecibido'])
                                            <strong>Sello de Recibido:</strong><br>{{ $invoice['selloRecibido'] }}
                                        @endif
                                    </p>
                                </td>
                                <td>
                                    @php
                                        $nombre = '';
                                        $documento = '';

                                        if ($invoice['tipo_dte'] == '14') {
                                            $receptor = $invoice['documento']->sujetoExcluido;
                                        } else {
                                            $receptor = $invoice['documento']->receptor;
                                        }

                                        $nombre = $receptor->nombre;
                                        if (in_array($invoice['tipo_dte'], $receptores_nit)) {
                                            $documento = $receptor->nit;
                                        } else {
                                            $documento = $receptor->numDocumento;
                                        }
                                    @endphp
                                    <p>
                                        @if ($nombre)
                                            <strong>Nombre:<br></strong> {{ $nombre }}<br>
                                        @endif
                                        @if ($documento)
                                            <strong>Identicacion:<br></strong> {{ $documento }}
                                        @endif
                                    </p>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($invoice['fhProcesamiento'])->format('d/m/Y H:i:s') }}
                                </td>
                                <td>{{ $invoice['estado'] }}</td>
                                <td class="small">
                                    {{-- {{ $invoice['observaciones'] }} --}}
                                    @php
                                        $decoded = json_decode($invoice['observaciones'], true);
                                    @endphp
                                    @if (is_array($decoded))
                                        @if (!empty($decoded))
                                            @if (array_key_exists('descripcionMsg', $decoded))
                                                <p>{{ $decoded['descripcionMsg'] }}</p>
                                            @else
                                                @foreach ($decoded as $observacion)
                                                    <p>{{ trim($observacion, '[]') }}</p>
                                                @endforeach
                                            @endif
                                        @endif
                                    @else
                                        @if (str_starts_with($invoice['observaciones'], '[') && str_ends_with($invoice['observaciones'], ']'))
                                            @php
                                                $json_string = str_replace("'", "\"", $invoice['observaciones']);
                                                // Decode the JSON string to a PHP array
                                                $array = json_decode($json_string, true);
                                            @endphp
                                            @if (is_array($array))
                                                @foreach ($array as $observacion)
                                                    <p>{{ $observacion }}</p>
                                                @endforeach
                                            @endif
                                        @else
                                            <p>{{ $invoice['observaciones'] }}</p>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($invoice['estado'] === 'CONTINGENCIA' || $invoice['estado'] === 'RECHAZADO')
                                    @else
                                        <div class="d-inline-flex">
                                            <a href="http://dashboard.octopus.local/storage/dtes/{{ $invoice['codGeneracion'] }}/{{ $invoice['codGeneracion'] }}.pdf"
                                                class="btn btn-sm btn-danger ms-1 d-flex align-items-center"
                                                target="_blank">PDF</a>
                                            <a href="http://dashboard.octopus.local/storage/dtes/{{ $invoice['codGeneracion'] }}/{{ $invoice['codGeneracion'] }}.json"
                                                class="btn btn-sm btn-success ms-1 d-flex align-items-center"
                                                target="_blank">JSON</a>
                                            <a href="http://dashboard.octopus.local/storage/dtes/{{ $invoice['codGeneracion'] }}/{{ $invoice['codGeneracion'] }}_ticket.pdf"
                                                class="btn btn-sm btn-warning ms-1 d-flex align-items-center"
                                                target="_blank">Tiquete</a>
                                            <button type="button"
                                                class="btn btn-primary btn-sm ms-1 btn-modal d-flex align-items-center"
                                                data-bs-toggle="modal" data-bs-target="#mailModal"
                                                data-id="{{ $invoice['codGeneracion'] }}">
                                                Reenviar Correo
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="align-middle text-center">
                                <th>ID</th>
                                <th>Tipo de Documento</th>
                                <th>Información Hacienda</th>
                                <th>Información Receptor</th>
                                <th>Fecha Procesamiento</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reenviar Correo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('invoices.send') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="mail">Dirección de Correo:</label>
                            <input type="email" class="form-control" id="mail" name="correo"
                                aria-describedby="emailHelp">
                            <small id="emailHelp" class="form-text text-muted">Correo electrónico del destinatario de este
                                DTE</small>
                            <input type="hidden" name="codGeneracion" value="" id="codGeneracion">
                        </div>
                        <div class="form-group mt-2">
                            <input type="submit" value="Enviar Correo" class="btn btn-success">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/invoices.js')
@endsection
