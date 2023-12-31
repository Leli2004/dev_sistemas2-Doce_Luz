@extends('base.app')
@section("titulo", 'Formulário Pedidos')
@section('content')

    @php
        if(!empty($pedido->id)){
            $route = route('pedido.update', $pedido->id);
        } else{
            $route = route('pedido.store');
        }
    @endphp

    <div class="mx-auto py-12 divide-y md:max-w-4xl">
        <div class="">
        <h3 class="text-2xl font-medium pb-4 text-pink-600">Formulário de Pedidos</h3>

        <form action="{{ $route }}" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-6 mb-4">
            @csrf <!-- cria um hash de segurança -->

            @if (!empty($pedido->id))
                @method('PUT')
            @endif

            <input type="hidden" name="id" value="@if (!empty($pedido->id)){{$pedido->id}}@elseif(!empty(old('id'))){{old('id')}}@else{{''}}@endif">

            <!--<div class="flex">
                <div class="w-1/2 mr-2">
                    <label class="block">
                        <span class="text-pink-600">Usuário</span>
                        <select name="usuario_id" id="" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black">
                            @foreach ($usuario as $item)
                                <option value="{{ $item->id }}"
                                    @if(!empty($pedido->id)){{ ( $item->id == $pedido->usuario_id) ? 'selected' : '' }} @else{{ '' }}@endif >{{$item->name}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div><br><br>-->

            <input type="hidden" name="usuario_id" value="{{Auth::user()->id}}">

            <div class="flex">
                <div class="w-1/2 mr-2">
                    <label class="block">
                        <span class="text-pink-600">Produto</span>
                        <select name="produto_id" id="" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black">
                            @foreach ($produto as $item)
                                <option value="{{ $item->id }}"
                                    @if(!empty($pedido->id)){{ ( $item->id == $pedido->produto_id) ? 'selected' : '' }}@else{{ '' }}@endif >{{$item->nome}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="w-1/2 mr-2">
                    <label class="block">
                        <span class="text-pink-700">Quantidade</span>
                        <input type="number" name="quantidade" placeholder=" " class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black"
                        value="@if(!empty($pedido->quantidade)){{$pedido->quantidade}}@elseif(!empty(old('quantidade'))){{old('quantidade')}}@else{{''}}@endif">
                    </label><br><br>
                </div>
            </div><br><br>

            <div class="flex">
                <div class="w-1/2 mr-2">
                    <label class="block">
                        <span class="text-pink-600">N° cartão</span>
                        <select name="cartao_id" id="" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black">
                            @foreach ($cartao as $item)
                                <option value="{{ $item->id }}"
                                    @if(!empty($pedido->id)){{ ( $item->id == $pedido->cartao_id) ? 'selected' : '' }}@else{{ '' }}@endif >{{$item->numeroCartao}}
                                </option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="w-1/2 mr-2">
                    <label class="block">
                        <span class="text-pink-600">Forma de pagamento</span>
                        <select name="forma_pagamento_id" id="" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black">
                            @foreach ($pagamento as $item)
                                <option value="{{ $item->id }}"
                                    @if(!empty($pedido->id)){{ ( $item->id == $pedido->forma_pagamento_id) ? 'selected' : '' }}
                                    @else{{ '' }}@endif >{{$item->nome}}
                                </option>
                            @endforeach
                        </select>
                </div>
            </div><br><br>

            <label class="block">
                <span class="text-pink-600">Observação</span>
                <input type="text" name="observacao" placeholder="Mais informações..." class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black"
                value="@if(!empty($pedido->observacao)){{$pedido->observacao}}@elseif(!empty(old('observacao'))){{old('observacao')}}@else{{''}}@endif">
            </label><br><br>

            <label class="block">
                <span class="text-pink-600">Status</span>
                    <select name="status_id" id="" class="mt-0 block w-full px-0.5 border-0 border-b-2 border-pink-200 focus:ring-0 focus:border-black">
                        @foreach ($status as $item)
                            <option value="{{ $item->id }}"
                                @if(!empty($pedido->id)){{ ( $item->id == $pedido->status_id) ? 'selected' : '' }}
                                @else{{ '' }}@endif >{{$item->nome}}
                            </option>
                        @endforeach
                    </select>
            </label><br><br>

            <button class="rounded-2xl text-pink-100 bg-pink-600 px-4 py-2 w-32 font-bold hover:bg-pink-700 hover:text-pink-100 hover:scale-105" type="submit">Salvar</button>
            <a href="{{ route('pedido.index') }}"><button type="button" class="rounded-2xl text-pink-600 bg-pink-200 px-4 py-2 w-32 font-bold hover:bg-pink-700 hover:text-pink-100 hover:scale-105">Voltar</button></a>
        </form>
    </div>
    </div>
@endsection

