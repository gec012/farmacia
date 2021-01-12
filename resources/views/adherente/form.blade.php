<div class="container"   >
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
    



<form method="POST" action="xls" accept-charset="UTF-8" enctype="multipart/form-data">
            
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <div class="col-md-12">
    <label class=" text-dark"for="">Buscar archivo de excel en formato .xlsx </label>
      <input id="" type="file" class="form-control" name="adherentefile" style="border-radius:15px;"  required>
    </div>
  </div>

  <div class="form-group">
    <div class="col-md-12 ">
      <button type="submit" class="btn btn-success mx-auto" style="border-radius:15px;">Enviar</button>
    </div>
  </div>
</form>