@extends('lanzamiento.layout')

@section('title',"Ajax Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h2 class="text text-md-center ">Ajax Seleccione las Competencias para la Evaluacion de</h2>
        <h2 class="text text-md-center text-danger">{{ $evaluado->name }}</h2>
    </div>

    @if ($errors->any())

        <div class="alert alert-danger">
            <p>Errores encontrados:</p>

            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach


            </ul>

        </div>

    @endif
    @if ($evaluadores->isNotEmpty())
        <div class="col-md-12">
            <div   data-id="form-select">
                {{-- {{ method_field('PUT') }} --}}
                {{-- @csrf --}}

            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Competencia</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Check</th>
                    <th scope="col">Seleccionar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competencias as $competencia)
                <tr data-id="{{"$competencia->id"}}">
                    <th scope="row">{{ $competencia->id }}</th>
                    <td>{{$competencia->name}}</td>
                    <td>{{$competencia->description}}</td>
                    <td>

                        <div class="form-check">
                            <input type="checkbox" class="check-select" id="{{"competencia$competencia->id"}}"
                            value="{{"$competencia->id"}}" name="competenciascheck[]">
                            <label class="form-check-label" for="{{"$competencia->id"}}">Evaluar</label>
                        </div>


                    </td>
                    <td >
                        <div class="form-check">
                            <a href="#"><span><i class="material-icons check-select">add-box</i></span></a>
                        </div>

                    </td>


                </tr>

                @endforeach

                </tbody>
            </table>
            <div class="clearfix">
                <span class="float-left"><a href="{{ route('lanzar.index') }}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

            </div>

            </div> {{-- form-end --}}

        </div>



    @else
        <p>No hay usuarios registrados</p>
    @endif
    <div class="clearfix">

        {{ $competencias->links() }}
    </div>



</div>

@endsection

@section('sidebar')




@endsection

@section('scripts')
<script>

    $(document).ready(function() {
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });


        $('.ccheck-select').click(function(e){

            //e.preventDefault();

            var row = $(this).parents('tr');
            var id=row.data('id');

            var form = $('#form-select');
            var attrAccion =form.attr('action');
            //var url = attrAccion.replace(':ID-COMPETENCIA',id)

            var data = form.serialize();

            $.ajax({
                type:'POST',
                url:url,// "{{ route('ajaxlanzar.filtrar') }}",
                data:{id:id},
                success:function(data){
                    alert(data.success);

                }

           });



        });


        $("input:checkbox").change(function() {
            //var user_id = $(this).closest('tr').attr('data-id');
            var isChecked = $("input:checkbox").is(":checked") ? 1:0;

            var row = $(this).parents('tr');
            var id=row.data('id');

            // var form = $('#form-select');

            // var data = form.serialize();


            // $.ajaxSetup({
            //     headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            alert(id);
            $.ajax({
                    type:'POST',
                    url:"ajaxlanzar/filtrar",
                    dataType:JSON;
                    data: data,
                  //  headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(data){
                        if(data.success){
                            //do something
                            alert(data.success);
                        }
                    },
                    errors:function(errors){
                        alert(errors.message);
                    }
            });

        });

    });
</script>
@endsection

