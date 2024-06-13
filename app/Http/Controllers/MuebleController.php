<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mueble;
use App\Http\Requests\MuebleFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MuebleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $muebles = DB::table('mueble as a')
            ->select('a.id', 'a.nombre', 'a.material', 'a.precio', 'a.imagen')
            ->where('a.nombre', 'LIKE', '%' . $texto . '%')
            ->orWhere('a.material', 'LIKE', '%' . $texto . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('almacen.mueble.index', compact('muebles', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("almacen.mueble.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MuebleFormRequest $request)
    {
        // Crear un nuevo objeto Mueble con los datos del formulario
        $mueble = new Mueble;
        $mueble->nombre = $request->input('nombre');
        $mueble->material = $request->input('material');
        $mueble->precio = $request->input('precio');

        if ($request->hasFile("imagen")) {
            $imagen = $request->file("imagen");
            $nombreimagen = Str::slug($request->nombre) . "." . $imagen->guessExtension();
            $ruta = public_path("/imagenes/muebles/");
            copy($imagen->getRealPath(), $ruta . $nombreimagen);
            $mueble->imagen = $nombreimagen;
        }

        $mueble->save();

        // Redireccionar a la página de índice de muebles con un mensaje de éxito
        return redirect()->route('mueble.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view("almacen.mueble.show", ["mueble" => Mueble::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mueble = Mueble::findOrFail($id);
        return view('almacen.mueble.edit', ["mueble" => $mueble]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MuebleFormRequest $request, $id)
    {
        // Validar los datos del formulario

        // Obtener el mueble a actualizar
        $mueble = Mueble::findOrFail($id);
        $mueble->nombre = $request->input('nombre');
        $mueble->material = $request->input('material');
        $mueble->precio = $request->input('precio');

        if ($request->hasFile("imagen")) {
            $imagen = $request->file("imagen");
            $nombreimagen = Str::slug($request->nombre) . "." . $imagen->guessExtension();
            $ruta = public_path("/imagenes/muebles/");
            copy($imagen->getRealPath(), $ruta . $nombreimagen);
            $mueble->imagen = $nombreimagen;
        }

        $mueble->update();

        // Redirigir al usuario a la página de detalles del mueble actualizado
        return redirect()->route('mueble.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el mueble por su ID
        $mueble = Mueble::findOrFail($id);

        // Eliminar el mueble
        $mueble->delete();

        // Redirigir al usuario a la página de listado de muebles
        return redirect()->route('mueble.index')->with('success', 'Mueble eliminado correctamente');
    }
}
