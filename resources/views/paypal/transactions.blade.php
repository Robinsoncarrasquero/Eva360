@extends('master')

@section('title',"Transacciones")

@section('content')


<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-1 text-center">
            <h4>Transacciones</h4>
            @if ($unidades>0)
                 <h5 style="color:green">Saldo: {{ $saldo }}</h5>
            @else
                <h5 style="color:red">Saldo: {{ $saldo }}</h5>
            @endif
            @if ($unidades>0)
                 <h5 style="color:green">Unidades: {{ $unidades }}</h5>
            @else
                <h5 style="color:red">Unidades: {{ $unidades }}</h5>
            @endif
        </div>

        <div class="d-flex justify-content-end">
            <a href="{{ route('paypal.editPayPayPal')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>

        <div class="table table-responsive">
            <table class="table table-light table-striped ">
                <thead>
                    <th>#</th>
                    <th>pay-id</th>
                    <th>intent</th>
                    <th>state</th>
                    <th>date</th>
                    <th>name</th>
                    <th>unids</th>
                    <th>total</th>

                    <th></th>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                    <tr id="{{ $record->id }}">
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->payid }}</td>
                        <td>{{ $record->intent }}</td>
                        <td>{{ $record->state }}</td>
                        <td>{{ $record->created_at }}</td>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->unidades }}</td>
                        <td>{{ $record->total}} {{ $record->currency }}</td>
                     </tr>
                    @endforeach

                    </tbody>
            </table>

        </div>

        <div class=" d-flex justify-content-center">
            {{ $records->links() }}
        </div>

</div>

@section('scripts')
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
