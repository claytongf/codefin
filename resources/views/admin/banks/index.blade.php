@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="row">
            <h4>Listagem de bancos</h4>
            <a href="{{ route('admin.banks.create') }}" class="btn waves-effect">Novo banco</a>
            <table class="table-bordered z-depth-5 responsive-table" id="table-banks">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banks as $bank)
                    <tr>
                        <td>{{ $bank->id }}</td>
                        <td>{{ $bank->name }}</td>
                        <td>
                            <a href="{{ route('admin.banks.edit', ['bank' => $bank->id]) }}" class="btn waves-effect blue-grey darken-2">Editar</a>
                            <a data-href="{{route('admin.banks.destroy', $bank->id)}}" data-id="{{$bank->id}}" data-name="{{ $bank->name }}" class="btn waves-effect red darken-4 clickButton">Excluir</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $banks->links() !!}
        </div>
    </div>
@endsection
@section('post-script')
    @include('admin.banks._ajax')
@endsection
