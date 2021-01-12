@extends('home')
@section('content')

  


    <div class="container">
        <div class="card text-center " style=";font-size:12px">
                <div class="card-header"  style="background-color:#0B610B;">
                        <div >
                                <h2 align="center" style="color:#E6E6E6">Mis Adherentes</h2>
                        </div>            
                        <hr>
                       
                </div>    
                <div class="card-body " >           
                            
                        <div class="table-responsive">
                            <table class="table table-sm  table-striped table-hover" id="tablaprueba">
                                <thead style="background-color:#0B610B;color:#E6E6E6">
                                    <tr>
                                          
                                            
                                        <th >Tipo Documento</th>   
                                        <th >Documento</th>
                                        
                                        <th>Apellido y Nombre </th>
                                  
                                    
                                        
                                    </tr>
                                </thead>
                                <tbody class="text-dark"  style="background-color:#eeeeee ">
                                    @foreach ($adherentes as $ad)
                                        <tr >
                                         <td>{{ $ad->tipo_documento }}</td>
                                            <td>{{ $ad->dni}}</td>
                                            
                                            <td>{{ $ad->nombre}}</td>                                                   
                                            
                                           
                                            
                                        </tr>
                                    @endforeach
                                </tbody>    
                            </table>
                        </div>
                </div> 
            </div>
    </div>
    



    <script>            
        $(document).ready(function() {
            $('#tablaprueba').dataTable( {
                "order": [2,'desc'], 
                "pageLength": 30,
                "searching": false,
                "paging": false,
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

  