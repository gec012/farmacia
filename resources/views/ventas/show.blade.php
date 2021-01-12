@extends('home')

@section('content')
        
        <div class="container">
                <form action="{{ route('ventas.index') }}" method="GET">
                        @csrf
        
                <div class="pull-right mb-4">         

                  
                        <input type="submit" value="Volver" class="btn btn-success" style="color:#E6E6E6;border-radius:20px">
                    </div>
        <div  class="card text-center " style=";font-size:16px">
                <div class="card-header" style="background-color:#0B610B;">
                        <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="pull-left">
                                        <h2 align="center" style="color:#E6E6E6"> Detalle de Factura</h2>
                                        
                                    </div>
                                    
                                   
                                </div>
                            </div>
                            <div class="row  ">
                                <a class="btn btn-danger btn-sm ml-auto" style="border-radius: 50px;" href="{{ route('comprobante',$factura->id )}}"><i class="fa fa-file-pdf" aria-hidden="true"> Descargar</i></a>
                                             

                            </div>
                </div>
                <div class="card-body">
                    <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                    <strong>Documento:</strong>
                                    {{ $factura->perfil_id }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                    <strong>Apellido y Nombre :</strong>
                                    {{ $perfil->nombre }}
                                </div>
                            </div>
                    </div>

                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                <strong>Sede:</strong>
                                {{ $factura->sucursal }}
                            </div>
                        </div>
        
                        <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                <strong>Fecha:</strong>
                               {{ date_format($factura->fecha,'d-m-Y H:i:s')}} hs
                            </div>
                        </div>
                    </div>             
                       
        
                        <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <strong>Número de factura:</strong>
                                        {{  $factura->numero_factura  }}
                                    </div>
                                </div>
                
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <strong>Total en $:</strong>
                                        {{ number_format( $factura->total_pagado , 2) }}
                                        
                                    </div>
                                </div>
                        </div>
                        <div class="table-responsive">
                                <table class="table table-sm  table-striped table-hover" id="tablaprueba" style=";font-size:12px">
                                        <thead style="background-color:#0B610B;color:#E6E6E6">
                                            <tr>

                                                <th>Producto</th>
                                                <th>Cant</th>
                                                <th>Rubro</th>                                                
                                                <th>Total Neto en $</th>
                                                <th>Cobertura en $</th>                                                
                                                <th>Descuento Adicional en $</th>
                                                <th>Total Bruto en $</th>
                                                <th>Total Pagado en $</th>
                                                
                                                </tr>
                                        </thead>
                                        
                                        <tbody>
                                            
                                                @foreach ($detalles as  $detalle)
                                                <tr>
                                                    <th>{{ $detalle->Producto}}</th>
                                                    <th>{{ $detalle->Cant}}</th>
                                                    <th>{{ $detalle->Rubro}}</th>                                                        
                                                    <th>{{ number_format($detalle->Total_Neto_Renglón, 2) }}</th>
                                                    <th>{{ number_format($detalle->Cobertura, 2) }}</th>
                                                    <th>{{ number_format($detalle->Dto_Adic, 2) }}</th>
                                                    <th>{{ number_format($detalle->Total_Bruto_Renglón, 2) }}</th>                                                   
                                                    <th>{{ number_format($detalle->Tot_Cliente, 2) }}</th>
                                                    
                                            </tr> 
                                                @endforeach         
                                            
                            
                                        </tbody>
                                    </table>
                            </div>
                           
                   
                </div>
        
               
        
        
                </div>
            </div>
        <div class="row">
               
               
                <input id="inicio" name="inicio" type="data" value="{{ $inicio}}" style="display:none">
                <input id="fin" name="fin" type="data" value="{{ $fin}}" style="display:none">
                        
                </form>

        </div>           
        
    
    </div>

        
        <script>            


                $(document).ready(function() {
                    $('#tablaprueba').dataTable( {
                        "searching": false,
                        "paging": false,
                    "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                           
                        },          
                    } );
                } );
        
              
            </script> 

@endsection 