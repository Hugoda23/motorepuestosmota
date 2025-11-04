@extends('layouts.app')

@push('styles')
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Custom CSS -->
<link href="{{ asset('css/admin/calendar/dias.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <h1 class="mb-4">Configurar Disponibilidad de Citas</h1>

    <!-- Botón: Nuevo día -->
    <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearDiaModal">
            ➕ Nuevo Día Disponible
        </button>
    </div>

    <!-- Tabla -->
    <table id="diasTable" class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Hora inicio</th>
                <th>Hora fin</th>
                <th>Límite de citas</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($diasDisponibles as $dia)
            <tr id="row-{{ $dia->id }}">
                <td class="td-fecha">{{ $dia->fecha_formateada }}</td>
                <td class="td-hora-inicio">{{ $dia->hora_inicio_formateada }}</td>
                <td class="td-hora-fin">{{ $dia->hora_fin_formateada }}</td>
                <td class="td-limite">{{ $dia->limite_citas }}</td>
                <td class="text-center">
                    <!-- Editar -->
                    <button class="btn btn-warning btn-sm mb-1 btn-edit"
                        data-id="{{ $dia->id }}"
                        data-fecha="{{ $dia->fecha }}"
                        data-hora_inicio="{{ $dia->hora_inicio }}"
                        data-hora_fin="{{ $dia->hora_fin }}"
                        data-limite="{{ $dia->limite_citas }}">
                        ✏ Editar
                    </button>

                    <!-- Eliminar -->
                   <form action="{{ route('admin.dias-disponibles.destroy', $dia->id) }}" method="POST"

                          onsubmit="return confirm('¿Eliminar este día disponible?')" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">🗑 Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: Crear día -->
@include('admin.calendar.partials.modal-crear-dia')

<!-- Modal: Editar día -->
@include('admin.calendar.partials.modal-editar-dia')
@endsection

@push('scripts')
<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<!-- Excel/PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Custom JS -->
<script src="{{ asset('js/admin/calendar/dias.js') }}" defer></script>
@endpush
