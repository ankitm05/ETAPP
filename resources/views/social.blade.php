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
                           <a href="{{ route('social', $id) }}" class="active">
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="ftrevents" style="min-height: 416px;">
                        <div class="row">
                           <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                              <h3>Event Posts</h3>
                           </div>
                        </div>
                        
                        <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" data-key-events="true" data-resizable="true" data-show-toggle="true" data-click-to-select="true"> 
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
                                        <th data-field="id">ID</th>
                                        <th data-field="name">Content</th>
                                        <th data-field="phone">Created at</th>
                                        <th data-field="complete">User</th>
                                        <th data-field="date">Total Comments</th>
                                        <th data-field="view">View Comments</th>
                                        <th data-field="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($postData)
                                @php $x = 1; @endphp
                                    @foreach($postData as $post)
                                        <tr>
                                            <td></td>
                                            <td> {{ $x }} </td>
                                            <td> {{ $post['content'] }} </td>
                                            <td> {{ $post['created'] }} </td>
                                            <td> {{ $post['userName'] }} </td>
                                            <td> {{ $post['totalCount'] }} </td>
                                            <td> <a href="{{ route('comment',['pid'=>$post['id'],'id'=>$id]) }}" class="pd-setting-ed" data-toggle="modal">View Comment</a> </td>
                                            <td>
                                                <a href="{{ route('delete-post', $post['id']) }}" class="pd-setting-ed"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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