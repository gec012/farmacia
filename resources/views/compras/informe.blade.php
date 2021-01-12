<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

   
</head>
<body>

<div class="container">

        <div class="card text-center " style=";font-size:12px">
                <div class="card-header"  style="background-color:#0B610B;">
                    
                        <div >
                                <h2 align="center" style="color:#E6E6E6">Consumos en Farmacia desde {{ date_format($inicio,'d-m-Y ')}} hasta {{ date_format($fin,'d-m-Y ')}} </h2>
                        </div>
            
                      
                </div>    
                <div class="card-body " >
                             
                        <div class="table-responsive">
                            <table class="table table-sm  table-striped table-hover" id="tablaprueba">
                                <thead style="background-color:#0B610B;color:#E6E6E6">
                                        <tr>
                                                
                                                <th >Documento</th>
                                                <th>Apellido y Nombre</th>
                                                <th>Nro Factura </th>
                                                <th >Fecha</th>
                                                <th>Sucursal</th>
                                                <th >Producto</th>
                                                <th>Cantidad</th>
                                                <th >Total Bruto</th>
                                                <th >Pagado</th>
                                            </tr>
                                </thead>
                                <tbody class="text-dark"  style="background-color:#eeeeee ">
                                        @foreach ($facturas as $fac)
                                        <tr >
                                            <td >{{ $fac->perfil_id}}</td>
                                            <td >{{ $fac->nombre}}</td>
                                            <td>{{ $fac->numero_factura}}</td>                      
                                            <td >{{ date_format($fac->fecha,'d-m-Y H:i:s')}} hs</td>                                            
                                            <td>{{ $fac->sucursal}}</td> 
                                            <td>{{ $fac->Producto }}</td>
                                            <td>{{ $fac->Cant }}</td>
                                            <td>{{ number_format( $fac->Total_Bruto_Renglón , 2) }}</td>
                                            <td>{{ number_format( $fac->Tot_Cliente , 2) }}</td>                                        
                                           
                                        </tr>
                                    @endforeach
                                    @foreach ($facturasAd as $fac)
                                    <tr >
                                        <td >{{ $fac->perfil_id}}</td>
                                        <td >{{ $fac->nombre}}</td>
                                        <td>{{ $fac->numero_factura}}</td>                      
                                        <td >{{ date_format($fac->fecha,'d-m-Y H:i:s')}} hs</td>                                            
                                        <td>{{ $fac->sucursal}}</td> 
                                        <td>{{ $fac->Producto }}</td>
                                        <td>{{ $fac->Cant }}</td>
                                        <td>{{ number_format( $fac->Total_Bruto_Renglón , 2) }}</td>
                                        <td>{{ number_format( $fac->Tot_Cliente , 2) }}</td>                                        
                                       
                                    </tr>
                                @endforeach
                                
                                </tbody>    
                                   
                            </table>

                            <div class="row tm-4 " style="font:11px">
                                    <br><br><br>
                                        <small><strong>* ESTE DETALLE NO ES VALIDO COMO COMBPROBANTE</strong></small>
                                   
                                </div>
                        </div>
                      
                    
                </div> 
            </div>
</div>

            

<script>            


        $(document).ready(function() {
            $('#tablaprueba').dataTable( {
                "order": [2,'desc'],
              
                pagingType: 'full',
               
                "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                        
                     
                      
                    },          
                    
                              
            });
        });

      
    </script> 
    
</body>
</html>
  