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
                           <a href="{{ route('reports', $id) }}" class="active">
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
                              <h3>Reports</h3>
                           </div>
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              
                           </div>
                        </div>
                        
                        <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" data-key-events="true" data-resizable="true">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="false"></th>
                                        <th data-field="id">ID</th>
                                        <th data-field="post">Post</th>
                                        <th data-field="postimage">Post Image</th>
                                        <th data-field="postby">Posted By</th>
                                        <th data-field="reportby">Report By</th>
                                        <th data-field="reason">Reason</th>
                                        <th data-field="desc">Description</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($reportData)
                                @php $x = 1; @endphp
                                    @foreach($reportData as $report)
                                        <tr>
                                            <td></td>
                                            <td> {{ $x }} </td>
                                            <td> {{ $report['content'] }} </td>
                                            <td>
                                              @if(strlen($report['postimage']) > 0)
                                              <img src="{{ $report['postimage'] }}" style="width:50px;height:50px;">
                                              @endif
                                            </td>
                                            <td> {{ $report['postby'] }} <BR/> {{ $report['postbyemail'] }} </td>
                                            <td> {{ $report['reportby'] }} <BR/> {{ $report['reportbyemail'] }} </td>
                                            <td> {{ $report['reason'] }} </td>
                                            <td> {{ $report['desc'] }} </td>
                                            <td>
                                                <a href="{{ route('delete-report', [$report['id'],$report['postid']]) }}" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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


@endsection

@section('scripts')
@endsection