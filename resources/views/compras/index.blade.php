@extends('home')
@section('content')

  
<div class="container">

        <div class="card text-center " style=";font-size:12px">
                <div class="card-header"  style="background-color:#0B610B;">
                    
                        <div >
                                <h2 align="center" style="color:#E6E6E6">Compras en Farmacia </h2>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-12 mr-auto" style="padding: 0px; margin-bottom:0% ">
                                    <div class="input-group  ">
                                            <select class="select mt-4 " style="border-radius:15px" id="table-filter" >
                                              <option selected value="">TODOS</option>
                                              <option value="{{ $perfil->nombre }}">{{ $perfil->nombre }}</option>
                                              @foreach ($adherentes as $ad)
                                                  <option value="{{ $ad->nombre }}">{{ $ad->nombre }}</option>
                                              @endforeach
                                            
                                            </select>
                                           
                                          </div>

                            </div>
                      
                        </div>     
            
                        <hr>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                </div>    
                <div class="card-body " >
                    <div class="row">
                            <form  class="ml-auto" action="{{ route('pdf') }}" method="GET">
                                    <input id="inicio" name="inicio" type="data" value="{{ $inicio}}" style="display:none">
                                    <input id="fin" name="fin" type="data" value="{{ $fin}}" style="display:none">


                                    <button  class="btn btn-dark btn-sm" style="background-color:#0B610B;border-radius: 15px;" type="submit"><i class="fa fa-print" aria-hidden="true"> Descargar detalle</i></button>

                            </form>
                    </div>
                    <div class="row">
                            <a href="{{ route('busqueda') }}" class="btn mb-3 mx-auto btn-success" style="color:#E6E6E6;border-radius:15px;"> Nueva Busqueda </a>  
                    </div>
                               
                        <div class="table-responsive">
                            <table class="table table-sm  table-striped table-hover"   id="tablaprueba">
                                <thead style="background-color:#0B610B;color:#E6E6E6">
                                        <tr>
                                                <th >Documento</th>
                                                <th>Apellido y Nombre </th>
                                                <th >Fecha</th>
                                                <th>Sucursal</th>
                                                <th >Numero de Factura</th>
                                                <th>Total en $</th>
                                                <th >Acciones</th>
                                            </tr>
                                </thead>
                                <tbody class="text-dark"  style=" background-color:#eeeeee ">
                                         
                                    @foreach ($facturas as $fac)
                                    <tr >
                                            <td >{{ $fac->perfil_id}}</td>
                                            <td>{{ $fac->nombre}}</td>                      
                                            <td > <span style="display:none" >{{ $fac->fecha }}</span> {{ date_format($fac->fecha,'d-m-Y H:i:s')}} hs </td>
                                            
                                            <td>{{ $fac->sucursal}}</td> 
                                            <td>{{ $fac->numero_factura }}</td>
                                            <td>{{ number_format( $fac->total_pagado , 2) }} </td>
                                            
                     
                                            
                                            <td   >
                                                
                                                    
                                                <form action="{{ route('ventas.show',$fac->id) }}" method="GET">
                                                        <input id="inicio" name="inicio" type="data" value="{{ $inicio}}" style="display:none">
                                                        <input id="fin" name="fin" type="data" value="{{ $fin}}" style="display:none">
        
                                                        <button class="btn btn-dark btn-sm"  style="background-color:#0B610B;border-radius: 15px;" type="submit"> <i class="fa fa-info-circle" aria-hidden="true"> Ver Detalle</i> </button>
                                                        
                                                        <a class="btn btn-danger btn-sm ml-auto" style="border-radius: 50px;" href="{{ route('comprobante',$fac->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"> Descargar</i></a>
                                 
                                                        </form>
        
                                                        
                                            </td>   
                                                  
                                        </tr>
                                        
                                    @endforeach

                                    @foreach ($facturasAd as $fac)
                                    <tr >
                                    <td >{{ $fac->perfil_id}}</td>
                                    <td>{{ $fac->nombre}}</td>                      
                                    <td > <span style="display:none" >{{ $fac->fecha }}</span> {{ date_format($fac->fecha,'d-m-Y H:i:s')}} hs</td>
                                    
                                    <td>{{ $fac->sucursal}}</td> 
                                    <td>{{ $fac->numero_factura }}</td>
                                    <td>{{ number_format( $fac->total_pagado , 2) }}</td>
                                    
             
                                    
                                    <td  >                                       
                                            
                                                <form action="{{ route('ventas.show',$fac->id) }}" method="GET">
                                                        <input id="inicio" name="inicio" type="data" value="{{ $inicio}}" style="display:none">
                                                        <input id="fin" name="fin" type="data" value="{{ $fin}}" style="display:none">
                                                      
                                                        <button class="btn btn-dark btn-sm"  style="background-color:#0B610B;border-radius: 15px;" type="submit"> <i class="fa fa-info-circle" aria-hidden="true"> Ver Detalle</i> </button>
                                                        
                                                        <a class="btn btn-danger btn-sm ml-auto" style="border-radius: 50px;" href="{{ route('comprobante',$fac->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"> Descargar</i></a>
                                 
                                                        </form>

                                                        
                                            </td>   
                                                
                                        
                                        </tr>
                                    @endforeach
                                
                                </tbody>    
                                   
                            </table>
                        </div>
                      
                    
                </div> 
            </div>
</div>

            

<script>            


   

        $(document).ready(function (){
            var table = $('#tablaprueba').DataTable({
            "order": [2,'desc'], 
            
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                
                "paginate": {
                    "next": "Next page",
                
                    }
                    
            }, 
            
               
            });
            
            $('#table-filter').on('change', function(){
               table.search(this.value).draw();   
            });
        });
         
      
    </script> 
    
@endsection

  