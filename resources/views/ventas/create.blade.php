@extends('home')
@section('content')

@if (count($errors) < 0)
    <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
@endif

<div class="container">

                
        <div class="card text-center">
                        <div class="card-header"  style="background-color:#0B610B;">
                                <h2 class="card-title" style="color:#ccd4c2" > Cargar un nuevo archivo de farmacia</h2>
                                @if ($message = Session::get('success'))
                                        <div class="alert alert-warning">
                                                <p>{{ $message }}</p>
                                        </div>
                                @endif
                        </div>
                
                        <div class="card-body" >
                        
                       
                                {!! Form::open( ['method' => 'POST','files' => true,'route' => ['ventas.store']]) !!}
                                        @include('ventas.form')
                                {!! Form::close() !!}
                        </div>
                </div>
        <div class="table-responsive">
           <table class="table table-sm  table-striped table-hover " id="tablaprueba">
                   <thead>
                           <tr>
                                   
                                   <th>Fecha</th>
                                   <th>Sede</th>
                                   <th>Eliminar</th>
                           </tr>

                   </thead>

                   <tbody>
                        @foreach ($fechas as $f)
                            <tr>
                                <td>{{ $f->fecha}}</td>
                                <td>{{ $f->sucursal}}</td>
                                <td  >
                                        {!! Form::open(['method' => 'DELETE','route' => ['ventas.destroy',$f->fecha.' '.$f->sucursal],'style'=>'display:inline']) !!}
                                            {{ Form::button('<i class="fa fa-sm fa-trash" style="color:black"></i>', ['class' => 'btn btn-danger btn-sm','data-toggle'=>"tooltip",'title'=>'Eliminar' ,'type' => 'submit','style'=>'border-radius: 50px; ']) }}
                                            {!! Form::close() !!}
        
                                </td>
                            </tr>
                        @endforeach
                   </tbody>
                   <tfoot>

                   </tfoot>
           </table>     
       </div>        
</div>

<script>            
        $(document).ready(function() {
            $('#tablaprueba').dataTable( {
                "order": [2,'desc'], 
                
                "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                        
                        "paginate": {
                            "next": "Next page",
                            }
                    },          
                    
                              
            });
        });

    </script> 
@endsection