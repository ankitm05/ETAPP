@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Event Management</h1>
               <div class="add-product">
                  <a href="{{route('create-event')}}">Create Event</a>
               </div>
            </div>
            <div class="row">
                
            </div>
            
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')

@endsection