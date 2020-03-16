@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Edit User Information</h1>
               <div class="setrgtbts">
                  <a class="btn btn-custon-four btn-danger" href="{{ route('dashboard') }}">Back</a>
               </div>
            </div>
            <div class="row">
               <form method="post" action="{{route('user-update',$user->id)}}">
                    @csrf
                  <div class="col-md-7">
                     <div class="ftrevents">
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Name </label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" class="form-control" placeholder="Enter Name" value="{{ $user->name }}" name="name">
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Position </label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" class="form-control" placeholder="Enter Position" value="{{ $user->position }}" name="position">
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Company Name </label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" class="form-control" placeholder="Enter Company Name" value="{{ $user->company_name }}" name="company_name">
                              </div>
                           </div>
                        </div>
                        

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Website</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" class="form-control" placeholder="Enter Website" value="{{ $user->website }}" name="website">
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Location</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" class="form-control" placeholder="Enter Location" value="{{ $user->location }}" name="location">
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Phone</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" class="form-control" placeholder="Enter Company Name" value="{{ $user->phone }}" value="phone">
                              </div>
                           </div>
                        </div>
                        
                        <div class="gosubbtns">
                            <button type="submit" class="btn btn-custon-four btn-primary">Update</button>
                        </div>

                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="ftrevents">
                        <div class="ministryevents">
                           <div class="infoviews">
                              <div class="thumbspns">
                                 <img src="img/mini.png">
                              </div>
                              <div class="dtlinfosall">
                                 
                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Name</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $user->name }} </p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Position</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $user->position }} </p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Company Name</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $user->company_name }} </p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Website</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <a href="{{ $user->website }}"> {{ $user->website }} </a>
                                    </div>
                                 </div>
                                 
                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Email</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $user->email }} </p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Location</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p>{{ $user->location }}</p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Phone Number</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $user->phone }} </p>
                                    </div>
                                 </div>

                                

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')
@endsection