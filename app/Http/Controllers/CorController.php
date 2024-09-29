<?php

namespace App\Http\Controllers;

use App\Models\Cor;
use Illuminate\Http\Request;

class CorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $cor = Cor::create($request->all());
            return response()->json($cor);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cor $cor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cor $cor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cor $cor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cor_id)
    {
        try {
            $cor = Cor::find($cor_id);
            $cor->delete();

            return response()->json('Cor deletada com sucesso');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
