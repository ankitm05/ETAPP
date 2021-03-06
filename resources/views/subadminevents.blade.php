@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Sub Admin Events</h1>
               <div class="add-product">
                  <a href="{{route('subadmin-management')}}"> Back </a>
               </div>
            </div>
            <div class="row">
            
            @if($events)

               @foreach($events as $event)
                  <div class="col-md-6">
                        <div class="ftrevents">
                           <div class="evtgenare showcompic">
                              <div class="evtimage">
                              @if(strlen($event->banner) > 0)
                                 <img src="{{ asset('storage/'.$event->banner) }}">
                              @else
                                 <img src="{{asset('admin/img/evtpic.png')}}">
                              @endif
                              </div>
                              <div class="evtdates">
                                 <div class="fromdt">
                                    <p>{{ date('d-M-Y', strtotime($event->datefrom)) }}</p>
                                 </div>
                                 <div class="todsn">
                                    <p>to</p>
                                 </div>
                                 <div class="fromdt todts">
                                    <p>{{ date('d-M-Y', strtotime($event->dateto))}}</p>
                                 </div>
                              </div>
                              <div class="companythumbspic">
                              @if(strlen($event->logo) > 0)
                                 <img src="{{ asset('storage/'.$event->logo) }}">
                              @else
                                 <img src="{{asset('admin/img/compthumbs.png')}}">
                              @endif
                              </div>
                           </div>
                           <div class="evtnamedis">
                              <p>{{$event->name}}</p>
                           </div>
                           <div class="manageoptd">
                              <div class="btmng">
                                 @if($event->status == 2)
                                    <a href="javascript:void(0)"> Deleted </a>
                                 @else
                                    <a href="{{ route('subadmin-view-event', $event->id) }}">View Event <i class="fa fa-sliders"></i></a>
                                 @endif

                              </div>
                              <div class="btmng rightmngs">
                                 
                              </div>
                           </div>
                        </div>
                  </div>
               @endforeach
            @endif

            </div>
            <div class="row">
               <div class="col-md-12">
                  @if(count($events) > 0)
                  @else
                     <p>No event found</p>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')

@endsection