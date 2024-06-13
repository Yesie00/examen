@extends('layouts.admin')
@section('contenido')
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editar Médico</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('medico.update', $medico->id) }}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group"> 
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="{{ $medico->nombre }}" placeholder="Ingresa el nombre del médico">
                            </div> 
                        </div>  
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="especialidad">Especialidad</label>
                                <input type="text" class="form-control" name="especialidad" value="{{ $medico->especialidad }}" placeholder="Ingresa la especialidad del médico">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="aniosservicio">Años de Servicio</label>
                                <input type="text" class="form-control" name="aniosservicio" value="{{ $medico->aniosservicio }}" placeholder="Ingresa los años de servicio del médico">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input type="file" class="form-control" name="foto" id="foto">
                                @if ($medico->foto)
                                    <img src="{{ asset('imagenes/medicos/' . $medico->foto) }}" height="100px" width="100px">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-success me-1 mb-1">Guardar</button>
                    <button type="button" class="btn btn-danger me-1 mb-1" onclick="window.location.href='{{ route('medico.index') }}'">Cancelar</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.row -->
@endsection
