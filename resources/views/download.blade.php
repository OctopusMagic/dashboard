@extends('layouts.app')
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
        <div class="col-md-12 text-center">
            <h1>Descargar Documentos Tributarios Electrónicos</h1>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('invoices.download') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="fecha_inicio" class="form-label text-md-right">Desde</label>
                                <input name="fecha_inicio" id="fecha_inicio" type="datetime-local" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_fin" class="form-label text-md-right">Hasta</label>
                                <input name="fecha_fin" id="fecha_fin" type="datetime-local" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group mt-3 justify-content-center">
                            <input type="submit" value="Descargar" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection