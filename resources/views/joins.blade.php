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
                           <a href="{{ route('joined', $id) }}" class="active">
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
                              <h3>Joined Users</h3>
                           </div>
                        </div>
                        
                        <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" data-key-events="true" data-resizable="true">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id">ID</th>
                                        <th data-field="name">Name</th>
                                        <th data-field="phone">Email</th>
                                        <th data-field="complete">Phone</th>
                                        <th data-field="date">Status</th>
                                        <th data-field="view">Event Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($eventData)
                                @php $x = 1; @endphp
                                    @foreach($eventData as $jData)
                                        <tr>
                                            <td></td>
                                            <td> {{ $x }} </td>
                                            <td> {{ $jData['name'] }} </td>
                                            <td> {{ $jData['email'] }} </td>
                                            <td> {{ $jData['phone'] }} </td>
                                            <td> 
                                                @if($jData['status'] == 1)
                                                  Active
                                                @else
                                                  Inactive
                                                @endif
                                            </td>
                                            <td> {{ $jData['eventcode'] }} </td>
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