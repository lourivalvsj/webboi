<?php

namespace App\Http\Controllers;

use App\Models\Uf;
use Illuminate\Http\Request;

class UfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna a listagem de todos os UFs
        $ufs = Uf::all();
        return view('ufs.index', compact('ufs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retorna a view de criação da UF
        return view('ufs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos no formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:2',
        ]);

        // Cria a UF com os dados validados
        Uf::create($request->all());

        // Redireciona para a listagem de UFs com mensagem de sucesso
        return redirect()->route('ufs.index')->with('success', 'UF cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function show(Uf $uf)
    {
        // Exibe os detalhes de uma UF específica
        return view('ufs.show', compact('uf'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function edit(Uf $uf)
    {
        // Retorna a view de edição de uma UF específica
        return view('ufs.edit', compact('uf'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uf $uf)
    {
        // Validação dos dados de atualização
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:2',
        ]);

        // Atualiza os dados da UF
        $uf->update($request->all());

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('ufs.index')->with('success', 'UF atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Uf $uf)
    {
        // Exclui a UF do banco de dados
        $uf->delete();

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('ufs.index')->with('success', 'UF excluída com sucesso.');
    }
}
