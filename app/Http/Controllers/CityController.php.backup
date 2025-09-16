<?php
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Uf;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retorna a listagem de todas as cidades com a UF associada
        $cities = City::with('uf')->get();
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Passa as UFs para a view para seleção no formulário
        $ufs = Uf::all();
        return view('cities.create', compact('ufs'));
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
            'uf_id' => 'required|exists:ufs,id',  // Verifica se a UF existe
        ]);

        // Cria a cidade com os dados validados
        City::create($request->all());

        // Redireciona para a listagem de cidades com mensagem de sucesso
        return redirect()->route('cities.index')->with('success', 'Cidade cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        // Exibe os detalhes de uma cidade específica
        return view('cities.show', compact('city'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        // Passa as UFs para a view e a cidade a ser editada
        $ufs = Uf::all();
        return view('cities.edit', compact('city', 'ufs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        // Validação dos dados de atualização
        $request->validate([
            'name' => 'required|string|max:255',
            'uf_id' => 'required|exists:ufs,id',
        ]);

        // Atualiza os dados da cidade
        $city->update($request->all());

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('cities.index')->with('success', 'Cidade atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        // Exclui a cidade do banco de dados
        $city->delete();

        // Redireciona para a listagem com mensagem de sucesso
        return redirect()->route('cities.index')->with('success', 'Cidade excluída com sucesso.');
    }
}
