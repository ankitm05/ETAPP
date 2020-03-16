@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>My Account Information</h1>
               <div class="setrgtbts">
                  <a class="btn btn-custon-four btn-danger" href="{{ route('dashboard') }}">Back</a>
               </div>
            </div>
            <div class="row">

               <form method="post" action="{{route('admin-update',$myprofile->id)}}">
                    @csrf
                  <div class="col-md-7">
                     @if (Session::has('success'))

                                <div class="alert alert-success" role="alert">
                                   <strong>Success:</strong> {{ Session::get('success') }}
                                </div>

                            @endif
                     <div class="ftrevents">
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro"> Password </label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="password" class="form-control" placeholder="Enter New Password"  name="password" required="">
                                 @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Confirm Password </label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="password" class="form-control" placeholder="Enter Confirm Password" name="confirm_password" required="">
                                 @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                 <img src="{{ asset('admin/img/adminprofile.png') }}">
                              </div>
                              <div class="dtlinfosall">
                                 
                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Username</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $myprofile->username }} </p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Email</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $myprofile->email }} </p>
                                    </div>
                                 </div>

                                 <div class="infossets">
                                    <div class="leftlabels">
                                       <label>Created At</label>
                                    </div>
                                    <div class="rgtinfosall">
                                       <p> {{ $myprofile->created_at }} </p>
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