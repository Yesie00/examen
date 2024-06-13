@extends('layouts.admin')
@section('contenido')
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Nuevo Mueble</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('mueble.store') }}" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group"> 
                                <label for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese el nombre del mueble">
                            </div> 
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="material">Material</label>
                                <input type="text" class="form-control" name="material" id="material" placeholder="Ingrese el material del mueble">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="text" class="form-control" name="precio" id="precio" placeholder="Ingrese el precio del mueble">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input type="file" class="form-control" name="imagen" id="imagen">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-success me-1 mb-1">Guardar</button>
                    <button type="button" class="btn btn-danger me-1 mb-1" onclick="window.location.href='{{ route('mueble.index') }}'">Cancelar</button>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.row -->
@endsection
