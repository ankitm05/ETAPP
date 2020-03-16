@extends('layouts.admin')
@section('content')

<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="sparkline13-list">
               <div class="sparkline13-hd">
                  <div class="main-sparkline13-hd">
                     <h1>Page Name :- {{ $pageContent['title']}}</h1>
                     <div class="add-product">
                     </div>
                  </div>
               </div>
               <form method="post" action="{{ route('update-static-page', $id) }}">
                  @csrf
                  <div class="responsive-mg-b-30"> 
                     <textarea name="content" id="description"> {{ $pageContent['content']}}</textarea>
                  </div>
                  <div style="margin-top:40px;">
                     <center> <button type="submit" name="update" class="btn btn-warning"> Update </button> </center>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'description' );
</script>
@endsection