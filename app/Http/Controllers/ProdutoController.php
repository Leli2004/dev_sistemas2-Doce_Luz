<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\TipoProduto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function index()
    {
        $produtos = Produto::all();
        return view('produto.list')->with(['produtos'=> $produtos]);
    }

    public function create()
    {
        $tipo_id = TipoProduto::orderBy('nome')->get();

        return view('produto.form')->with(['tipo_id'=> $tipo_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required|max:100',
            'codigo'=>'required|max:40',
            'valorCusto'=>'required|max:6',
            'valorVenda'=>'required|max:6',
        ],[
            'nome.required'=>"O :attribute é obrigatório!",
            'nome.max'=>" Só é permitido 100 caracteres em :attribute !",
            'valorCusto.required'=>"O :attribute é obrigatório!",
            'valorCusto.max'=>" Só é permitido 6 caracteres em :attribute !",
            'valorVenda.required'=>"O :attribute é obrigatório!",
            'valorVenda.max'=>" Só é permitido 6 caracteres em :attribute !",
            'codigo.required'=>"O :attribute é obrigatório!",
            'codigo.max'=>" Só é permitido 40 caracteres em :attribute !",
        ]);

        $dados = ['nome'=> $request->nome,
            'codigo'=> $request->codigo,
            'valorCusto'=> $request->valorCusto,
            'valorVenda'=> $request->valorVenda,
            'descricao'=>$request->descricao,
            'tipo_id'=>$request->tipo_id,
        ];

        $imagem = $request->file('imagem');
        //verifica se existe imagem no formulário
        if($imagem){
            $nome_arquivo =
            date('YmdHis').'.'.$imagem->getClientOriginalExtension();

            $diretorio = "imagem/cartao/";
            //salva imagem em uma pasta do sistema
            $imagem->storeAs($diretorio,$nome_arquivo,'public');

            $dados['imagem'] = $diretorio.$nome_arquivo;
        }

        Produto::create($dados);

        return redirect('produto')->with('success', "Cadastrado com sucesso!");
    }

    public function show(Produto $produto)
    {
        //
    }

    public function edit($id)
    {

        $produto = Produto::find($id);
        //dd($produto);

        $tipo_id = TipoProduto::orderBy('nome')->get();

        return view('produto.form')->with([
        'produto'=> $produto,
        'tipo_id'=> $tipo_id]);

    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome'=>'required|max:100',
            'codigo'=>'required|max:40',
            'valorCusto'=>'required|max:6',
            'valorVenda'=>'required|max:6',
        ],[
            'nome.required'=>"O :attribute é obrigatório!",
            'nome.max'=>" Só é permitido 100 caracteres em :attribute !",
            'valorCusto.required'=>"O :attribute é obrigatório!",
            'valorCusto.max'=>" Só é permitido 6 caracteres em :attribute !",
            'valorVenda.required'=>"O :attribute é obrigatório!",
            'valorVenda.max'=>" Só é permitido 6 caracteres em :attribute !",
            'codigo.required'=>"O :attribute é obrigatório!",
            'codigo.max'=>" Só é permitido 40 caracteres em :attribute !",
        ]);

        $dados = ['nome'=> $request->nome,
            'codigo'=> $request->codigo,
            'valorCusto'=> $request->valorCusto,
            'valorVenda'=> $request->valorVenda,
            'descricao'=>$request->descricao,
            'tipo_id'=>$request->tipo_id,
        ];

        $imagem = $request->file('imagem');
        //verifica se existe imagem no formulário
        if($imagem){
            $nome_arquivo =
            date('YmdHis').'.'.$imagem->getClientOriginalExtension();

            $diretorio = "imagem/cartao/";
            //salva imagem em uma pasta do sistema
            $imagem->storeAs($diretorio,$nome_arquivo,'public');

            $dados['imagem'] = $diretorio.$nome_arquivo;
        }

        Produto::UpdateOrCreate(
            ['id'=>$request->id],
            $dados);

        return redirect('produto')->with('success', "Atualizado com sucesso!");
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        $produto->delete();

        return redirect('produto')->with('success', "Deletado com sucesso!");
    }

    public function search(Request $request)
    {
        if(!empty($request->valor)){
            $produtos = Produto::where($request->tipo, 'like', "%". $request->valor."%")->get();
        }
        else {
            $produtos = Produto::all();
        }

        return view('produto.list')->with(['produtos'=> $produtos]);
    }

}
