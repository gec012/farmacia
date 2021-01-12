@extends('layouts.app')

@section('content')
<div class="container">
               
</div>

        @if (Auth::user()->estado == true and  Auth::user()->email_verified_at <> null )
                

                <div class="container">

                        <div class="card">
                
                                <div class="card-header" style="background-color:#0B610B;">
                                                <div class="row">
                                                <div class="col-lg-12 margin-tb">
                                                <div class="pull-left">
                                                        <h2 align="center" style="color:#E6E6E6">Buscar</h2>
                                                </div>
                                                
                                                </div>
                                        </div>
                                </div>
                                <div class="card-body">
                                <form action="{{ route('ventas.index') }}" method="GET">
                                        @csrf
                                        <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                                                        <div class="form-group">
                                                                                        <label for="inicio"><strong>Fecha de inicio :</strong> </label> 
                                                                                        <input id="inicio"  name="inicio" max="{{ date('Y-m-d') }}" min="2019-01-01" required>                       </div>
                                                                </div>
                                             
                        
                        
                                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                                                <div class="form-group">
                                                        <label for="fin"><strong>Fecha de Fin (Inlcuida) :</strong> </label>
                                                <input id="fin" name="fin" max="{{ date('Y-m-d') }}"  min="2019-01-01" required >
                                                </div>
                                        </div>
                        
                                                
                                        </div>
                        
                                        <div class="row">
                                                <div class=" mt-4 mx-auto">
                                                        <input type="submit" value="Buscar" class="btn btn-success" style="border-radius:20px">
                                                </div>
                                        </div>
                                </form>
                                </div>
                        </div>
                </div>
        @else
                @if (Auth::user()->estado == true)
                        @include('auth.verify')

                @else
                        @include('aviso')
                @endif
        @endif
       
       
        <script>
                var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                $('#inicio').datepicker({
                        footer: true, modal: true ,
                        uiLibrary: 'bootstrap4', 
                        format: 'dd-mm-yyyy' ,
                        minDate: '01-01-2019',
                        maxDate: today,
                });
        </script>
        <script>

                        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

                $('#fin').datepicker({
                        
                        footer: true, 
                        modal: true ,
                        format: 'dd-mm-yyyy' ,
                        minDate: '01-01-2019',
                        maxDate: today, 
                        uiLibrary: 'bootstrap4',
                   
                });
            </script>


@endsection
