<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cartao;
use App\Models\User;
use App\Models\FormaPagamentoTipoCartao;
use App\Models\Status;
use App\Models\ItemVenda;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedido.list')->with(['pedidos'=> $pedidos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuario = User::orderBy('name')->get();
        $pagamento = FormaPagamentoTipoCartao::orderBy('nome')->get();
        $cartao = Cartao::orderBy('nomeTitular')->get();
        $status = Status::orderBy('nome')->get();
        $venda = ItemVenda::orderBy('pedido_id')->get();

        return view('pedido.form')->with([
            'usuario'=> $usuario,
            'pagamento'=> $pagamento,
            'cartao'=> $cartao,
            'status'=> $status,
            'venda'=> $venda
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id'=>'required|max:10',
            'forma_pagamento_id'=>'required|max:10',
            'cartao_id'=>'required|max:10',
            'status_id'=>'required|max:10',
            'observacao'=>'required|max:200',
        ],[
            'usuario_id.required'=>"O :attribute é obrigatório!",
            'forma_pagamento_id.required'=>"O :attribute é obrigatório!",
            'cartao_id.required'=>"O :attribute é obrigatório!",
            'status_id.required'=>"O :attribute é obrigatório!",
            'observacao.max'=>" Só é permitido 200 caracteres em :attribute !",
        ]);

        $dados = ['usuario_id'=> $request->usuario_id,
            'forma_pagamento_id'=> $request->forma_pagamento_id,
            'cartao_id'=> $request->cartao_id,
            'status_id'=> $request->status_id,
            'observacao'=>$request->observacao,
        ];

        Pedido::create($dados);

        return redirect('pedido')->with('success', "Cadastrado com sucesso!");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pedido = Pedido::find($id);

        $usuario = User::orderBy('name')->get();
        $pagamento = FormaPagamentoTipoCartao::orderBy('nome')->get();
        $cartao = Cartao::orderBy('nomeTitular')->get();
        $status = Status::orderBy('nome')->get();
        $venda = ItemVenda::orderBy('pedido_id')->get();

        return view('pedido.form')->with([
        'pedido'=> $pedido,
        'usuario'=> $usuario,
        'pagamento'=> $pagamento,
        'cartao'=> $cartao,
        'status'=> $status,
        'venda'=> $venda ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'usuario_id'=>'required|max:10',
            'forma_pagamento_id'=>'required|max:10',
            'cartao_id'=>'required|max:10',
            'status_id'=>'required|max:10',
            'observacao'=>'required|max:200',
        ],[
            'usuario_id.required'=>"O :attribute é obrigatório!",
            'forma_pagamento_id.required'=>"O :attribute é obrigatório!",
            'cartao_id.required'=>"O :attribute é obrigatório!",
            'status_id.required'=>"O :attribute é obrigatório!",
            'observacao.max'=>" Só é permitido 200 caracteres em :attribute !",
        ]);

        $dados = ['usuario_id'=> $request->usuario_id,
            'forma_pagamento_id'=> $request->forma_pagamento_id,
            'cartao_id'=> $request->cartao_id,
            'status_id'=> $request->status_id,
            'observacao'=>$request->observacao,
        ];

        Pedido::UpdateOrCreate(
            ['id'=>$request->id],
            $dados);

        return redirect('pedido.edit')->with('success', "Atualizado com sucesso!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);

        $pedido->delete();

        return redirect('pedido')->with('success', "Deletado com sucesso!");
    }

    public function search(Request $request)
    {
        if(!empty($request->valor)){
            $pedido = Pedido::where($request->tipo, 'like', "%". $request->valor."%")->get();
        }
        else {
            $pedido = Pedido::all();
        }

        return view('pedido.list')->with(['pedido'=> $pedido]);
    }

}
