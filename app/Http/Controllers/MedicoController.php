<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;
use App\Http\Requests\MedicoFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $medicos = DB::table('medico as m')
            ->select('m.id', 'm.nombre', 'm.especialidad', 'm.aniosservicio', 'm.foto')
            ->where('m.nombre', 'LIKE', '%' . $texto . '%')
            ->orWhere('m.especialidad', 'LIKE', '%' . $texto . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('almacen.medico.index', compact('medicos', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("almacen.medico.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicoFormRequest $request)
    {
        // Crear un nuevo objeto Medico con los datos del formulario
        $medico = new Medico;
        $medico->nombre = $request->input('nombre');
        $medico->especialidad = $request->input('especialidad');
        $medico->aniosservicio = $request->input('aniosservicio');

        if ($request->hasFile("foto")) {
            $foto = $request->file("foto");
            $nombrefoto = Str::slug($request->nombre) . "." . $foto->guessExtension();
            $ruta = public_path("/imagenes/medicos/");
            copy($foto->getRealPath(), $ruta . $nombrefoto);
            $medico->foto = $nombrefoto;
        }

        $medico->save();

        // Redireccionar a la página de índice de medicos con un mensaje de éxito
        return redirect()->route('medico.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view("almacen.medico.show", ["medico" => Medico::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medico = Medico::findOrFail($id);
        return view('almacen.medico.edit', ["medico" => $medico]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicoFormRequest $request, $id)
    {
        // Obtener el medico a actualizar
        $medico = Medico::findOrFail($id);
        $medico->nombre = $request->input('nombre');
        $medico->especialidad = $request->input('especialidad');
        $medico->aniosservicio = $request->input('aniosservicio');

        if ($request->hasFile("foto")) {
            $foto = $request->file("foto");
            $nombrefoto = Str::slug($request->nombre) . "." . $foto->guessExtension();
            $ruta = public_path("/imagenes/medicos/");
            copy($foto->getRealPath(), $ruta . $nombrefoto);
            $medico->foto = $nombrefoto;
        }

        $medico->update();

        // Redirigir al usuario a la página de detalles del medico actualizado
        return redirect()->route('medico.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el medico por su ID
        $medico = Medico::findOrFail($id);

        // Eliminar el medico
        $medico->delete();

        // Redirigir al usuario a la página de listado de medicos
        return redirect()->route('medico.index')->with('success', 'Medico eliminado correctamente');
    }
}
