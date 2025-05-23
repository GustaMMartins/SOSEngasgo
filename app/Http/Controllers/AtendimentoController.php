<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Atendimento;

class AtendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atendimento $atendimento)
    {
        if(!$this->validarAcesso($atendimento)){
            return redirect()->route('dashboard')->with('error', 'Você não tem permissão para excluir esta tarefa!');
        }

        $atendimento->delete();
        return redirect()->route('dashboar')->with('success', 'Tarefa excluída com sucesso!');
    }

    private function validarAcesso(Atendimento $atendimento):bool
    {
        $user = Auth::user();
        if($atendimento->user_id != $user->id){
            return false;
        }

        return true;

    }
}
