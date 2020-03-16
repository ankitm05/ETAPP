@extends('layouts.admin')
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
                           <a href="{{ route('content', $id) }}">
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
                           <a href="{{ route('polls', $id) }}" class="active">
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="ftrevents" style="min-height: 416px;">
                        <div class="row">
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <h3>Poll</h3>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalpoll"> Add Poll </button>
                           </div>
                        </div>
                        
                        <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" data-key-events="true" data-resizable="true">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="false"></th>
                                        <th data-field="id">ID</th>
                                        <th data-field="name">Question</th>
                                        <th data-field="phone">Option - A</th>
                                        <th data-field="complete">Option - B</th>
                                        <th data-field="date">Option - C</th>
                                        <th data-field="view1">Option - D</th>
                                        <th data-field="view">Votes</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($quesData)
                                @php $x = 1; @endphp
                                    @foreach($quesData as $ques)
                                        <tr>
                                            <td></td>
                                            <td> {{ $x }} </td>
                                            <td> {{ $ques['question'] }} </td>
                                            <td> {{ $ques['optiona'] }} </td>
                                            <td> {{ $ques['optionb'] }} </td>
                                            <td> {{ $ques['optionc'] }} </td>
                                            <td> {{ $ques['optiond'] }} </td>
                                            <td> {{ $ques['votes'] }} </td>
                                            <td>
                                                <a href="{{ route('delete-poll', $ques['id']) }}" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></a>

                                                <button type="button" class="btn" data-toggle="modal" data-target="#myModal{{ $ques['id'] }}"> <i class="fa fa-eye" aria-hidden="true"></i> </button>

                                                <!-- Modal -->
                                                <div id="myModal{{ $ques['id'] }}" class="modal fade" role="dialog">
                                                  <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Results</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                        <p>{{ $ques['question'] }}</p>
                                                        <br>
                                                        
                                                        @php  $quesDataModals = $ques['quesDataModals']; @endphp
                                                        
                                                        @foreach($quesDataModals as $quesDataModal)
                                                          <p>A. {{ $quesDataModal['optiona']['name'] }} <span style="margin-left: 20px;color: cornflowerblue;">{{ $quesDataModal['optiona']['votes'] }} votes</span> </p>
                                                          <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$quesDataModal['optiona']['per']}}"
                                                            aria-valuemin="0" aria-valuemax="100" style="width:{{$quesDataModal['optiona']['per']}}%">
                                                              {{$quesDataModal['optiona']['per']}}%
                                                            </div>
                                                          </div>

                                                          <p>B. {{ $quesDataModal['optionb']['name'] }} <span style="margin-left: 20px;color: cornflowerblue;">{{ $quesDataModal['optionb']['votes'] }} votes</span> </p>
                                                          <div class="progress">
                                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{$quesDataModal['optionb']['per']}}"
                                                            aria-valuemin="0" aria-valuemax="100" style="width:{{$quesDataModal['optionb']['per']}}%">
                                                              {{$quesDataModal['optionb']['per']}}%
                                                            </div>
                                                          </div>

                                                          @if(strlen($quesDataModal['optionc']['name']) > 0)
                                                          <p>C. {{ $quesDataModal['optionc']['name'] }} <span style="margin-left: 20px;color: cornflowerblue;">{{ $quesDataModal['optionc']['votes'] }} votes</span> </p>
                                                          <div class="progress">
                                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$quesDataModal['optionc']['per']}}"
                                                            aria-valuemin="0" aria-valuemax="100" style="width:{{$quesDataModal['optionc']['per']}}%">
                                                              {{$quesDataModal['optionc']['per']}}%
                                                            </div>
                                                          </div>
                                                          @endif

                                                          @if(strlen($quesDataModal['optiond']['name']) > 0)
                                                          <p>D. {{ $quesDataModal['optiond']['name'] }} <span style="margin-left: 20px;color: cornflowerblue;">{{ $quesDataModal['optiond']['votes'] }} votes</span> </p>
                                                          <div class="progress">
                                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{$quesDataModal['optiond']['per']}}"
                                                            aria-valuemin="0" aria-valuemax="100" style="width:{{$quesDataModal['optiond']['per']}}%">
                                                              {{$quesDataModal['optiond']['per']}}%
                                                            </div>
                                                          </div>
                                                        @endif

                                                        @endforeach
                                                      </div>
                                                      <div class="modal-footer">
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @php $x++; @endphp
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal Schedule-->
<div id="myModalpoll" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Poll</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('addpoll', $id)}}" method="POST">
                    @csrf
                    <div class="ftrevents">
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Question</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="ques" class="form-control" placeholder="Enter Question" required>
                              </div>
                           </div>
                        </div>
                        
                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Option - A</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="optiona" class="form-control" placeholder="Enter Option - A" required>
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Option - B</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="optionb" class="form-control" placeholder="Enter Option - B" required>
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Option - C</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="optionc" class="form-control" placeholder="Enter Option - C">
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner">
                           <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                 <label class="login2 pull-right pull-right-pro">Option - D</label>
                              </div>
                              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                 <input type="text" name="optiond" class="form-control" placeholder="Enter Option - D">
                              </div>
                           </div>
                        </div>

                        <div class="form-group-inner text-center">
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

@endsection

@section('scripts')
@endsection