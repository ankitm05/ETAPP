@extends('layouts.admin')
@section('content')


<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="sparkline13-list">
               <div class="sparkline13-hd">
                  <div class="main-sparkline13-hd">
                     <h1>Subadmin Management</h1>
                     <div class="add-product">
                        <!--<a href="addusers.html">Add New User</a>-->
                     </div>
                  </div>
               </div>
               <div class="sparkline13-graph">
                  <div class="datatable-dashv1-list custom-datatable-overright">
                     <div id="toolbar">
                        <select class="form-control dt-tb">
                           <option value="">Export Basic</option>
                           <option value="all">Export All</option>
                           <option value="selected">Export Selected</option>
                        </select>
                     </div>
                     <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                        data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                        <thead>
                           <tr>
                              <th data-field="state" data-checkbox="true"></th>
                              <th data-field="id">ID</th>
                              <th data-field="name">User Name</th>
                              <th data-field="email">Email</th>
                              <th data-field="events">Events</th>
                              <th data-field="views">Views</th>
                              <th data-field="phone">Status</th>
                              <th data-field="date">Date Created</th>
                              <th data-field="action">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                        @if($users)
                        @php $x = 1; @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td></td>
                                    <td> {{ $x }} </td>
                                    <td> {{ $user['username'] }} </td>
                                    <td> {{ $user['email'] }} </td>
                                    <td> {{ $user['eventCount'] }} </td>
                                    <td> <a href="{{ route('subadmin-event-management', $user['id']) }}" data-toggle="tooltip" title="" class="pd-setting-ed" data-original-title="Edit"><i class="fa fa-eye" aria-hidden="true"></i></a> </td>
                                    <td> @if($user['status'] == 1) Active @else Inactive @endif </td>
                                    <td> {{ $user['created_at'] }} </td>
                                    <td>
                                        @if($user['status'] == 0)
                                          <a href="{{ route('subadmin-status', $user['id']) }}" data-toggle="tooltip" title="" class="pd-setting-ed" data-original-title="Edit"><i class="fa fa-ban" aria-hidden="true"></i></a>
                                        @else
                                          <a href="{{ route('subadmin-status', $user['id']) }}" data-toggle="tooltip" title="" class="pd-setting-ed" data-original-title="Edit"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        @endif
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

@endsection

@section('scripts')
@endsection