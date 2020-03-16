@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Event Information</h1>
               <div class="setrgtbts">
                  <!--<a class="btn btn-custon-four btn-danger" href="#">Delete Event</a>-->
               </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                  <div class="stepebentsd">
                     <ul>
                        <li>
                           <a href="{{route('create-event')}}" class="active">
                              <span class="educate-icon educate-event icon-wrap"></span>
                              <p> Event Info</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Features</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-student icon-wrap"></span>
                              <p>Content</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-department icon-wrap"></span>
                              <p>Notification</p>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Social</p>
                           </a>
                        </li>
                        
                     </ul>
                  </div>
               </div>
               
               <div class="col-md-7">

                     <!--detail-1  -->
                  <div class="ftrevents" id="form1">
                     <form method="POST" action="{{ route('save-event') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Name</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="eventname" class="form-control eventname" placeholder="Enter Event Name">
                                 @if ($errors->has('eventname'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventname') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Duration</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <div class="row">
                                    <div class="col-lg-12 col-md-2 col-sm-2 col-xs-12">
									            <div class="date-picker-inner">
									               <div class="form-group data-custon-pick data-custom-mg" id="data_5">
                                             <div class="input-daterange input-group" id="datepicker">
                                                <input type="text" class="form-control" name="fromdate" value="{{ date('m/d/Y') }}" />
                                                <span class="input-group-addon">to</span>
                                                <input type="text" class="form-control" name="todate" value="{{ date('m/d/Y') }}" />
                                                   @if ($errors->has('fromdate'))
                                                      <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $errors->first('fromdate') }}</strong>
                                                      </span>
                                                   @endif
                                                   @if ($errors->has('todate'))
                                                      <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $errors->first('todate') }}</strong>
                                                      </span>
                                                   @endif
                                             </div>
                                          </div>
									
									
                                  <!--  <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
									
									<div class="form-group data-custon-pick data-custom-mg" id="data_6">
                                       <input type='text' name="fromdate" class="form-control" id='datepicker' />
                                       @if ($errors->has('fromdate'))
                                          <span class="invalid-feedback" role="alert">
                                             <strong>{{ $errors->first('fromdate') }}</strong>
                                          </span>
                                       @endif
									   </div>
									   
									    <div class="form-select-list">
                                          <input type='text' name="todate" class="form-control" id='datetimepicker5' />
                                          @if ($errors->has('todate'))
                                             <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('todate') }}</strong>
                                             </span>
                                          @endif
                                       </div>
									   
									   </div>-->
                                    </div>
									
                                      
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Description</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <textarea class="form-control eventdesc" name="desc" placeholder="Enter Event Info.."></textarea>
                                 @if ($errors->has('desc'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('desc') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Venue</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input class="form-control eventvenu" name="location" placeholder="Enter Location..">
                                 @if ($errors->has('location'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Upload Event Pic</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="file" name="eventpic" class="form-control" placeholder="Upload event ic">
                                 @if ($errors->has('eventpic'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventpic') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Company Logo Pic</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="file" name="eventpic1" class="form-control" placeholder="Upload Company Logo">
                                 @if ($errors->has('eventpic1'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventpic1') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Email</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="email" class="form-control eventemail" placeholder="Enter Email id">
                                 @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Phone Number</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="phone" class="form-control eventphone" placeholder="Enter Phone Number">
                                 @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Event Verification Code</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="eventcode" class="form-control" placeholder="Enter Event Verification Code" value="" style="text-transform:uppercase">
                                 @if ($errors->has('eventcode'))
                                    <span class="invalid-feedback" role="alert">
                                       <strong>{{ $errors->first('eventcode') }}</strong>
                                    </span>
                                 @endif
                              </div>
                           </div>
                        </div>

                        <div class="gosubbtns">
                           <button type="submit" name="save" class="btn btn-custon-four btn-primary">Next</button>
                        </div>

                        </form>
                     </div>
                  </div>

                  <div class="col-md-5">
                     <div class="ftrevents">
                        <div class="evtgenare showcompic">
                           <div class="evtimage">
                              <img src="{{ asset('admin/img/evtpic.png')}}">
                           </div>
                           <div class="evtdates">
                              <div class="fromdt">
                                 <p> -- </p>
                              </div>
                              <div class="todsn">
                                 <p>to</p>
                              </div>
                              <div class="fromdt todts">
                                 <p> -- </p>
                              </div>
                           </div>
                           <div class="companythumbspic">
                              <img src="{{ asset('admin/img/compthumbs.png')}}">
                           </div>
                        </div>
                        <div class="evtnamedis">
                           <p class="eventnametext">  </p>
                        </div>
                        <div class="manageoptd">
                           <div class="btmng rightmngs">
                              <a href="#">Unpublish</a>
                           </div>
                        </div>
                        <div class="evtnamedis">
                           <p class="eventdesctext"> </p>
                        </div>
                        <div class="evtnamedis">
                           <p class="eventvenutext"> </p>
                        </div>
                        <div class="evtnamedis">
                           <p class="eventemailtext"> </p>
                        </div>
                        <div class="evtnamedis">
                           <p class="eventphonetext"> </p>
                        </div>
                     </div>
                     <div class="sparkline9-graph">
                        <div class="google-map-single">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.5403150035045!2d-58.16606168522769!3d6.825622995066911!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8dafef14679c0cfb%3A0x92a6c3c92a56f32!2sGuyana%20Marriott%20Hotel%20Georgetown!5e0!3m2!1sen!2sin!4v1569418588573!5m2!1sen!2sin" width="400" height="200" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                     </div>
                  </div>
               
            </div>
         </div>
      </div>
   </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
   $(document).ready(function() {
      $('#datetimepicker4, #datetimepicker5').datetimepicker();
   });

   $(document).ready(function () {
      $('.eventname').keyup(function() {
         var textvalue = $('.eventname').val();
         $(".eventnametext").html(textvalue);
      });

      $('.eventdesc').keyup(function() {
         var textvalue = $('.eventdesc').val();
         $(".eventdesctext").html(textvalue);
      });

      $('.eventvenu').keyup(function() {
         var textvalue = $('.eventvenu').val();
         var textvaluedata = '<b>Venu :</b>' + textvalue;
         $(".eventvenutext").html(textvaluedata);
      });

      $('.eventemail').keyup(function() {
         var textvalue = $('.eventemail').val();
         var textvaluedata = '<b>Email :</b>' + textvalue;
         $(".eventemailtext").html(textvaluedata);
      });

      $('.eventphone').keyup(function() {
         var textvalue = $('.eventphone').val();
         var textvaluedata = '<b>Phone :</b>' + textvalue;
         $(".eventphonetext").html(textvaluedata);
      });
   });
</script>

 <script src="admin/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="admin/js/datapicker/datepicker-active.js"></script>
	
@endsection