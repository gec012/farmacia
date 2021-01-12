<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
</head>
<body>
        <div class="container">
               
        <div  class="card text-center " style=";font-size:16px">
                <div class="card-header" style="background-color:#0B610B;">
                        <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="pull-left">
                                        <h2 align="center" style="color:#E6E6E6"> Detalle de Consumo</h2>
                                    </div>
                                   
                                </div>
                            </div>
                </div>
                <div class="card-body">
                    @if ($tit <> null)
                        <div class="row">

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <strong>Documento del titular:</strong>
                                        {{ $tit->perfil_id }}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                        <strong>Apellido y Nombre del titular :</strong>
                                        {{ $tit->nombre }}
                                    </div>
                                </div>
                        </div>

                        
                    @endif

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
                                    <div class="row tm-4     " style="font:11px">
                                        <br><br><br>
                                            <small><strong>* ESTE DETALLE NO ES VALIDO COMO COMBPROBANTE</strong></small>
                                       
                                    </div>
                            </div>
                           
                   
                </div>
        
               
        
        
                </div>
            </div>
            
        
    
    </div>

       

    
<script>            


    $(document).ready(function() {
        $('#tablaprueba').dataTable( {
            "order": [0,'asc'],
          
            pagingType: 'full',
           
            "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                    
                 
                  
                },          
                
                          
        });
    });

  
</script> 
</body>
</html>