@extends('master')

@section('title',"Statu de Feedback")

@section('content')


<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="mt-1 text-center">
        <h5>Lista de status de Feedback</h5>
    </div>

    <div class="d-flex justify-content-end">
        <a  href="{{ route('fbstatu.create')}}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
    </div>

    <div class="table table-responsive">
        <table class="table table-light table-striped ">
            <thead>
                <th>#</th>
                <th>Status</th>
                <th>Descripcion</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($fbstatus as $fbstatu)
                <tr id="{{ $fbstatu->id }}">
                    <td>{{ $fbstatu->id }}</td>
                    <td>{{ $fbstatu->name }}</td>
                    <td >{{ substr($fbstatu->description,0,100) }} ....</td>

                    <td><a href="{{ route('fbstatu.edit',$fbstatu) }}" class="btn btn-dark"><i class="material-icons">create</i></a></td>
                    <td>
                        <button class="btn btn-danger" onclick="deleteConfirmation({{$fbstatu->id}},'{{route('fbstatu.delete',$fbstatu->id)}}')">Delete</button>
                    </td>

                </tr>
                @endforeach
                </tbody>
        </table>
    </div>

    <div class=" d-flex justify-content-center">
        {{ $fbstatus->links() }}
    </div>

</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection

@endsection
