@extends('layouts.admin.admin')
@section('content')
<!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Repair Service Prices</h1>
          </div>


          <!-- Content Row -->

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12">
              <div class="card shadow mb-4">
               
                <!-- Card Body -->
                <div class="card-body">
                <div class="mt-2 ml-2 mr-2 mb-4">
                  <form  method="post" enctype="multipart/form-data" action="{{route('updatePrices')}}" >
                @CSRF
                @method('PATCH')
            @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session()->get('message') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
         </button>
        </div>
      @endif
            @if ($errors->any())
              <div class="alert alert-danger">
               <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                   @endforeach
              </ul>
              </div>
            @endif
                  <div class="row">
                  <div class="col-md-6">
                 <div class="form-group">
                        <label>Basic repair fee</label>
                        <input class="form-control @error('basic_fee') is-invalid @enderror"  type="number" name="basic_fee" value="{{$price->basic_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Expert repair fee</label>
                        <input class="form-control @error('expert_fee') is-invalid @enderror"  type="number" name="expert_fee" value="{{$price->expert_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Upgrade fee</label>
                        <input class="form-control @error('upgrade_fee') is-invalid @enderror"  type="number" name="upgrade_fee" value="{{$price->upgrade_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Caloocan city transportation fee</label>
                        <input class="form-control @error('caloocan_fee') is-invalid @enderror"  type="number" name="caloocan_fee" value="{{$price->caloocan_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Malabon city transportation fee</label>
                        <input class="form-control @error('malabon_fee') is-invalid @enderror"  type="number" name="malabon_fee" value="{{$price->malabon_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Navotas city transportation fee</label>
                        <input class="form-control @error('navotas_fee') is-invalid @enderror"  type="number" name="navotas_fee" value="{{$price->navotas_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Valenzuela city transportation fee</label>
                        <input class="form-control @error('valenzuela_fee') is-invalid @enderror"  type="number" name="valenzuela_fee" value="{{$price->valenzuela_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Quezon city transportation fee</label>
                        <input class="form-control @error('quezon_fee') is-invalid @enderror"  type="number" name="quezon_fee" value="{{$price->quezon_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Marikina city transportation fee</label>
                        <input class="form-control @error('marikina_fee') is-invalid @enderror"  type="number" name="marikina_fee" value="{{$price->marikina_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasig city transportation fee</label>
                        <input class="form-control @error('pasig_fee') is-invalid @enderror"  type="number" name="pasig_fee" value="{{$price->pasig_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Taguig city transportation fee</label>
                        <input class="form-control @error('taguig_fee') is-invalid @enderror"  type="number" name="taguig_fee" value="{{$price->taguig_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Makati city transportation fee</label>
                        <input class="form-control @error('makati_fee') is-invalid @enderror"  type="number" name="makati_fee" value="{{$price->makati_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Manila city transportation fee</label>
                        <input class="form-control @error('manila_fee') is-invalid @enderror"  type="number" name="manila_fee" value="{{$price->manila_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Mandaluyong city transportation fee</label>
                        <input class="form-control @error('mandaluyong_fee') is-invalid @enderror"  type="number" name="mandaluyong_fee" value="{{$price->mandaluyong_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>San Juan city transportation fee</label>
                        <input class="form-control @error('sanjuan_fee') is-invalid @enderror"  type="number" name="sanjuan_fee" value="{{$price->sanjuan_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Pasay city transportation fee</label>
                        <input class="form-control @error('pasay_fee') is-invalid @enderror"  type="number" name="pasay_fee" value="{{$price->pasay_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Paranaque city transportation fee</label>
                        <input class="form-control @error('paranaque_fee') is-invalid @enderror"  type="number" name="paranaque_fee" value="{{$price->paranaque_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Las Pinas city transportation fee</label>
                        <input class="form-control @error('laspinas_fee') is-invalid @enderror"  type="number" name="laspinas_fee" value="{{$price->laspinas_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label>Muntinlupa city transportation fee</label>
                        <input class="form-control @error('muntinlupa_fee') is-invalid @enderror"  type="number" name="muntinlupa_fee" value="{{$price->muntinlupa_fee}}" required min="0" step="0.01">
                    </div>
                    </div>
                    </div>
                   
                      <div class="row">&nbsp;</div>
                    
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                   
                  </form>  
                     </div>     
                </div>
              </div>
            </div>

           
          </div>

         
        </div>
        <!-- /.container-fluid -->       
      

    



@endsection