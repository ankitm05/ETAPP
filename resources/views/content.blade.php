@extends('layouts.admin')
<style>
   .well-sm {
      padding: 9px;
      border-radius: 3px;
      height: 52px;
   }
</style>
@section('content')

<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="bothwaysevt main-sparkline13-hd">
               <h1>Event Information</h1>
               <div class="setrgtbts">
                 
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="stepebentsd">
                     <ul>
                        <li>
                           <a href="{{ route('view-event', $id) }}">
                              <span class="educate-icon educate-event icon-wrap"></span>
                              <p> Event Info</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('features', $id) }}">
                              <span class="educate-icon educate-interface icon-wrap"></span> 
                              <p>Features</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('content', $id) }}" class="active">
                              <span class="educate-icon educate-course icon-wrap"></span>
                              <p>Content</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('notifications', $id) }}">
                              <span class="educate-icon educate-message icon-wrap"></span>
                              <p>Notification</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('social', $id) }}">
                              <span class="educate-icon educate-professor icon-wrap"></span> 
                              <p>Social</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('polls', $id) }}">
                              <span class="educate-icon educate-data-table icon-wrap"></span> 
                              <p>Polls</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('joined', $id) }}">
                              <span class="educate-icon educate-department icon-wrap"></span> 
                              <p>Joined users</p>
                           </a>
                        </li>
                        <li>
                           <a href="{{ route('reports', $id) }}">
                              <span class="educate-icon educate-charts icon-wrap"></span> 
                              <p>Reports</p>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>

                <div class="col-md-7">
                    <div class="ftrevents" style="min-height: 416px;">

                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                            
                            @if($featureDetails)
                                @php $xx=1 @endphp
                                
                                @foreach($featureDetails as $fDetail)
                                    <li @if(strlen($tabing) > 0)  @if($tabing == $fDetail['id']) class="active" @endif @else @if($xx == 1) class="active" @endif @endif> <a data-toggle="tab" href="#menu{{$fDetail['id']}}">
                                       <span class="educate-icon educate-professor icon-wrap"></span> 
                                    </a></li>
                                    @php $xx++; @endphp
                                @endforeach
                            @endif
                            
                            </ul>
                        
                            <div class="tab-content">
                            @if($featureDetails)
                                @php $xx=1 @endphp
                                
                                @foreach($featureDetails as $fDetail)

                                    <div id="menu{{$fDetail['id']}}" class="tab-pane fade @if(strlen($tabing) > 0)  @if($tabing == $fDetail['id']) in active @endif @else @if($xx == 1) in active @endif @endif" style="padding-top:30px;padding-left:20px;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h3> {{$fDetail['formname']}} </h3>
                                            </div>

                                            <div class="col-md-6 text-right">
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{$fDetail['id']}}"> Add {{$fDetail['formname']}} </button>
                                            </div>

                                        </div>
                                        <div class="row" style="margin-top:20px;">
                                            <div class="col-md-12">
                                                @php $featuresdatas = $fDetail['featuresdatas']; @endphp
                                                
                                                @if(count($featuresdatas) > 0)
                                                   
                                                   @foreach($featuresdatas as $featuresdata)
                                                      
                                                      @if($fDetail['fid'] == 1)
                                                        
                                                        <div class=""> 
                                                           <span style="float:left;width:80%;"><strong>Title :</strong> {{$featuresdata['title']}} </span>
                                                           <span style="float:left;width:80%;"><strong>Description : </strong>{{$featuresdata['content']}} </span>
                                                        </div>

                                                      @elseif($fDetail['fid'] ==2)
                                                        <div class="well well-sm">
                                                          <div class="col-md-10">
                                                            <div>
                                                                <span style="float:left;width:100%;"> {{$featuresdata['name']}} </span>
                                                            </div>
                                                            <div>
                                                                <span style="margin-right:30px;"> <strong>Date :</strong>{{$featuresdata['event_date']}} 

                                                                <span> <strong>Time :</strong>{{$featuresdata['event_from']}} To {{$featuresdata['event_to']}}</span>
                                                                </span>
                                                            </div>
                                                          </div>
                                                          <div class="col-md-2">
                                                              <span class="btn btn-warning" onclick="deletecontentfunction({{$featuresdata['id']}}, '{{$featuresdata['type']}}')"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                          </div>
                                                        </div>
                                                      
                                                      @elseif($fDetail['fid'] ==6)
                                                        <div class="well well-sm" style="height: 99px;">
                                                          <div class="col-md-10">
                                                            <span style="float:left;width:80%;"> 
                                                                <img src="{{ asset('storage/'.$featuresdata['floorimg']) }}" style="width:150px;height:80px;">
                                                            </span>
                                                          </div>
                                                          <div class="col-md-2">
                                                            <span class="btn btn-warning" onclick="deletecontentfunction({{$featuresdata['id']}}, '{{$featuresdata['type']}}')"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                          </div>
                                                        </div>
                                                      @else
                                                        <div class="well well-sm">
                                                          <div class="col-md-10">
                                                           <span style="float:left;width:80%;"> {{$featuresdata['name']}} </span>
                                                          </div>
                                                          <div class="col-md-2">
                                                            <span class="btn btn-warning" onclick="deletecontentfunction({{$featuresdata['id']}}, '{{$featuresdata['type']}}')"><i class="fa fa-trash" aria-hidden="true"></i></span>
                                                          </div>
                                                        </div>
                                                      @endif
                                                   @endforeach
                                                      <div style="clear:both;"></div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    @if($fDetail['fid'] == 1)

                                      <!-- Modal About-->
                                      <div id="myModal{{$fDetail['id']}}" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Add About</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form action="{{route('addabout', $id)}}" method="POST" enctype="multipart/form-data">
                                                          @csrf
                                                          <div class="ftrevents">
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Title</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="title" class="form-control" placeholder="Enter title" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Content</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <textarea name="content" class="form-control" required></textarea>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner text-center">
                                                                <input type="hidden" name="detail" value="{{ $fDetail['id'] }}">
                                                                  <button type="submit" class="btn btn-primary" name="save"> Update </button>
                                                              </div>
                                                          </div>
                                                      </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                      
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                    @elseif($fDetail['fid'] ==2)

                                        <!-- Modal Schedule-->
                                        <div id="myModal{{$fDetail['id']}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Add Schedule</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('addschedule', $id)}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="ftrevents">
                                                                <!--<div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">Event Name</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                         <input type="text" name="name" class="form-control" placeholder="Enter Event Name" required>
                                                                      </div>
                                                                   </div>
                                                                </div>-->
                                                                <input type="hidden" name="name" class="form-control" value="">

                                                                <div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">Event Date</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                        <div class="date-picker-inner">
                                                                            <div class="form-group data-custon-pick data-custom-mg" id="data_5">
                                                                               <div class="input-daterange input-group" id="datepicker">
                                                                                  <input type="text" class="form-control" name="event_date" value="{{ date('m/d/Y') }}" />
                                                                               </div>
                                                                            </div>
                                                                         </div>
                                                                      </div>
                                                                   </div>
                                                                </div>

                                                                <div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">Event From (Time)</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                         <input id="datetimepicker11" type="text" name="event_from" class="form-control" placeholder="Enter Time" required>
                                                                      </div>
                                                                   </div>
                                                                </div>
                                                                
                                                                <div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">Event To (Time)</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                         <input id="datetimepicker12" type="text" name="event_to" class="form-control" placeholder="Enter Time" required>
                                                                      </div>
                                                                   </div>
                                                                </div>
                                                                <!--<div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">Location</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                         <input type="text" name="location" class="form-control" placeholder="Enter Location" required>
                                                                      </div>
                                                                   </div>
                                                                </div>-->
                                                                <input type="hidden" name="location" class="form-control" value="">

                                                                <!--<div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">Speaker</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                         <select class="form-control" name="speaker">
                                                                            @if(count($speakergets) > 0)
                                                                                <option value=""> Select Speaker </option>
                                                                              @foreach($speakergets as $speakerget)
                                                                                <option value="{{$speakerget['name']}}"> {{$speakerget['name']}} </option>
                                                                              @endforeach
                                                                            @else
                                                                              <option value=""> Select Speaker </option>
                                                                            @endif
                                                                         </select>
                                                                      </div>
                                                                   </div>
                                                                </div>-->
                                                                <input type="hidden" name="speaker" class="form-control" value="">

                                                                <div class="form-group-inner">
                                                                   <div class="row">
                                                                      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                         <label class="login2 pull-right pull-right-pro">description</label>
                                                                      </div>
                                                                      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                         <textarea class="form-control" name="desc" placeholder="Enter Description" required></textarea>
                                                                      </div>
                                                                   </div>
                                                                </div>

                                                                <div class="form-group-inner text-center">
                                                                    <input type="hidden" name="detail" value="{{ $fDetail['id'] }}">
                                                                    <button type="submit" class="btn btn-primary" name="save"> Save </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @elseif($fDetail['fid'] ==3)
                                      
                                      <!-- Modal Exhibitor-->
                                      <div id="myModal{{$fDetail['id']}}" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Add Exhibitors</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form action="{{route('addexhibitor', $id)}}" method="POST" enctype="multipart/form-data">
                                                          @csrf
                                                          <div class="ftrevents">
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Company Name</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="name" class="form-control" placeholder="Enter Company Name" required>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Booth</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="booth" class="form-control" placeholder="Enter Booth" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Company Logo Pic</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="file" name="logo" class="form-control" placeholder="Upload logo" required>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Website</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="website" class="form-control" placeholder="Enter Website" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Email</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Phone Number</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="phone" class="form-control" placeholder="Enter Phone number" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Description</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <textarea class="form-control" name="desc" placeholder="Enter Description" required></textarea>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Top Rated</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                      <div class="bt-df-checkbox pull-left">
                                                                        <div class="i-checks pull-left">
                                                                          <label>
                                                                            <input type="checkbox"  name="toprated" value="1"> <i></i></label>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner text-center">
                                                                <input type="hidden" name="detail" value="{{ $fDetail['id'] }}">
                                                                  <button type="submit" class="btn btn-primary" name="save"> Save </button>
                                                              </div>
                                                          </div>
                                                      </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                    @elseif($fDetail['fid'] ==4)
                                      
                                      <!-- Modal sponser-->
                                      <div id="myModal{{$fDetail['id']}}" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Add Sponsers</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form action="{{route('addsponser', $id)}}" method="POST" enctype="multipart/form-data">
                                                          @csrf
                                                          <div class="ftrevents">
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Company Name</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="name" class="form-control" placeholder="Enter Company Name" required>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Level</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="level" class="form-control" placeholder="Enter Level" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Company Logo Pic</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="file" name="logo" class="form-control" placeholder="Upload logo" required>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Website</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="website" class="form-control" placeholder="Enter Website" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Email</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Phone Number</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="phone" class="form-control" placeholder="Enter Phone number" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Description</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <textarea class="form-control" name="desc" placeholder="Enter Description" required></textarea>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Top Rated</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                  
                                   <div class="bt-df-checkbox pull-left">
                                  <div class="i-checks pull-left">
                                                                                <label>
                                    <input type="checkbox"  name="toprated" value="1"> <i></i>  </label>
                                                                    </div>
                                  </div>
                                  
                                                                       
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner text-center">
                                                                <input type="hidden" name="detail" value="{{ $fDetail['id'] }}">
                                                                  <button type="submit" class="btn btn-primary" name="save"> Save </button>
                                                              </div>
                                                          </div>
                                                      </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      

                                    @elseif($fDetail['fid'] ==5)
                                      
                                      <!-- Modal Speaker-->
                                      <div id="myModal{{$fDetail['id']}}" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Add Speaker</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                      <form action="{{route('addspeaker', $id)}}" method="POST" enctype="multipart/form-data">
                                                          @csrf
                                                          <div class="ftrevents">
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Name</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Company Name</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="cname" class="form-control" placeholder="Enter Name" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Image</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="file" name="logo" class="form-control" placeholder="Upload logo" required>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Position</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="position" class="form-control" placeholder="Enter Position" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Email</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="email" class="form-control" placeholder="Enter Email" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Phone Number</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <input type="text" name="phone" class="form-control" placeholder="Enter Phone number" required>
                                                                    </div>
                                                                 </div>
                                                              </div>
                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Description</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <textarea class="form-control" name="desc" placeholder="Enter Description" required></textarea>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner">
                                                                 <div class="row">
                                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                       <label class="login2 pull-right pull-right-pro">Top Rated</label>
                                                                    </div>
                                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                       <div class="bt-df-checkbox pull-left">
                                  <div class="i-checks pull-left">
                                                                                <label>
                                    <input type="checkbox"  name="toprated" value="1"> <i></i>  </label>
                                                                    </div>
                                  </div>
                                                                    </div>
                                                                 </div>
                                                              </div>

                                                              <div class="form-group-inner text-center">
                                                                <input type="hidden" name="detail" value="{{ $fDetail['id'] }}">
                                                                  <button type="submit" class="btn btn-primary" name="save"> Save </button>
                                                              </div>
                                                          </div>
                                                      </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                      

                                    @elseif($fDetail['fid'] ==6)

                                      <!-- Modal floor plan-->
                                      <div id="myModal{{$fDetail['id']}}" class="modal fade" role="dialog">
                                          <div class="modal-dialog">
                                              <!-- Modal content-->
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title">Add Floor plan</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                     <form action="{{ route('savefloorplan', $id) }}" method="post" enctype="multipart/form-data">
                                                     @csrf
                                                        <div class="form-group-inner">
                                                           <div class="row">
                                                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                                                 <label class="login2 pull-right pull-right-pro"> Upload Floor Plan images</label>
                                                              </div>
                                                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                                 <input type="file" name="floorimages[]" class="form-control" placeholder="Upload logo" multiple>
                                                                 ( Upload Max 5 images )
                                                              </div>
                                                           </div>
                                                        </div>

                                                        <div class="gosubbtns">
                                                              <input type="hidden" name="detail" value="{{ $fDetail['id'] }}">
                                                              <button type="submit" class="btn btn-custon-four btn-primary" name="save"> Save </button>
                                                              <a href="{{route('event-management')}}" class="btn btn-custon-four btn-primary" name="save"> Exit </a>
                                                        </div>
                                                     </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>

                                    @endif


                                    @php $xx++; @endphp
                                @endforeach
                            @endif
                            </div>
                        </div>
                    </div>
                </div>

                  <div class="col-md-5">
                     <div class="ftrevents">
                        <div class="evtgenare showcompic">
                           <div class="evtimage">
                              @if($event)
                                @if(strlen($event->banner) > 0)
                                   <img src="{{ asset('storage/'.$event->banner) }}">
                                @else
                                   <img src="{{asset('admin/img/evtpic.png')}}">
                                @endif
                              @else
                                <img src="{{asset('admin/img/evtpic.png')}}">
                              @endif
                           </div>
                           <div class="evtdates">
                              <div class="fromdt">
                                @if($event)
                                  <p>{{ date('d-M-Y', strtotime($event->datefrom)) }}</p>
                                @else
                                  <p> -- </p>
                                @endif
                              </div>
                              <div class="todsn">
                                 <p>to</p>
                              </div>
                              <div class="fromdt todts">
                                @if($event)
                                  <p>{{ date('d-M-Y', strtotime($event->dateto))}}</p>
                                @else
                                  <p> -- </p>
                                @endif
                              </div>
                           </div>
                           <div class="companythumbspic">
                              @if($event)
                                  @if(strlen($event->logo) > 0)
                                     <img src="{{ asset('storage/'.$event->logo) }}">
                                  @else
                                     <img src="{{asset('admin/img/compthumbs.png')}}">
                                  @endif
                              @else
                                <img src="{{asset('admin/img/compthumbs.png')}}">
                              @endif
                           </div>
                        </div>
                        <div class="evtnamedis">
                          @if($event)
                            <p>{{$event->name}}</p>
                          @else
                            <p></p>
                          @endif
                        </div>
                        <div class="manageoptd">
                           <div class="btmng rightmngs">
                              
                           </div>
                        </div>
                     </div>
                     <div class="sparkline9-graph">
                        <div class="google-map-single">
                          @if($event)
                           <iframe width="400" style="border:0" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q={{$event->venu}} ?>&output=embed"></iframe>
                          @endif
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
  <script src="{{asset('admin/js/datapicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('admin/js/datapicker/datepicker-active.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $('#datetimepicker11').datetimepicker();
      $('#datetimepicker12').datetimepicker();
  });

  function deletecontentfunction(id, type) {
    $.ajax({
         type: "POST",
         url: "{{ route('delete_content') }}",
         data: {jid:id,type:type, _token: '{{csrf_token()}}'},
         success: function(response)
         {
            //alert(response);
            location.reload(true);
         },
    });
  }
</script>

  <script src="/admin/js/icheck/icheck.min.js"></script>
    <script src="/admin/js/icheck/icheck-active.js"></script>
  
@endsection