<?php

namespace App\Http\Controllers;

use App\Models\Presente;
use App\Models\Cor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PresenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Inertia::render($this->returnComponentToRender(request()), $this->returnBaseProps());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function admin()
    {
        try {
            return Inertia::render($this->returnComponentToRender(request()), $this->returnBaseProps());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function comprado(Request $request)
    {
        try {
            $presente = Presente::find($request->id);
            $presente->comprado = true;
            $presente->nome_comprador = $request->nome_comprador;
            $presente->save();

            return Inertia::render($this->returnComponentToRender($request), $this->returnBaseProps());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function naoComprado(Request $request)
    {
        try {
            $presente = Presente::find($request->id);
            $presente->comprado = false;
            $presente->nome_comprador = null;
            $presente->save();

            return Inertia::render($this->returnComponentToRender($request), $this->returnBaseProps());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $presente['nome'] = $request->nome;
            $presente['descricao'] = $request->descricao;
            $presente['categoria'] = $request->especial ? 'especial' : 'normal';
            $presente['comprado'] = false;
            $presente['nome_comprador'] = '';

            $presente = Presente::create($presente);

            $links = $request->links;

            array_filter($links, function ($link) {
                return $link['value'] !== '';
            });

            foreach ($links as $link) {
                $presente->links()->create(['link' => $link['value']]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($presente_id)
    {
        try {
            $presente = Presente::find($presente_id);
            $presente->delete();

            return Inertia::render($this->returnComponentToRender(request()), $this->returnBaseProps());
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    private function returnComponentToRender(Request $request): string
    {
        if ($request->getRequestUri() === '/') {
            return 'List';
        } else if ($request->getRequestUri() === '/admin') {
            return 'Admin';
        }

        return 'List';
    }

    private function returnBaseProps(): array
    {
        $presentes_normais = Presente::where('categoria', 'normal')->with('links')->get();
        $presentes_especiais = Presente::where('categoria', 'especial')->with('links')->get();
        $cores = Cor::all();

        return [
            'presentes_normais' => $presentes_normais,
            'presentes_especiais' => $presentes_especiais,
            'cores' => $cores,
        ];
    }
}
