@extends('layouts.admin')
@section('content')

<div class="product-status mg-b-15">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="sparkline13-list">
               <div class="sparkline13-hd">
                  <div class="main-sparkline13-hd">
                     <h1>Pages</h1>
                     <div class="add-product">
                     </div>
                  </div>
               </div>
               <div class="sparkline13-graph">
                  <div class="datatable-dashv1-list custom-datatable-overright">
                     <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-pagination-switch="true" data-resizable="true" data-cookie="true"
                        data-cookie-id-table="saveId" data-toolbar="#toolbar">
                        <thead>
                           <tr>
                              <th data-field="state" data-checkbox="true"></th>
                              <th data-field="id">ID</th>
                              <th data-field="name">Page Name</th>
                              <th data-field="email">Status</th>
                              <th data-field="action">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td></td>
                              <td>1</td>
                              <td>About Us</td>
                              <td>published</td>
                              <td>
                                 <a href="{{ route('view-static-page',1) }}" data-toggle="tooltip" title="" class="pd-setting-ed" data-original-title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                              </td>
                           </tr>
                           <tr>
                              <td></td>
                              <td>2</td>
                              <td>Terms and Condition</td>
                              <td>published</td>
                              <td>
                                 <a href="{{ route('view-static-page',2) }}" data-toggle="tooltip" title="" class="pd-setting-ed" data-original-title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                              </td>
                           </tr>
                           <tr>
                              <td></td>
                              <td>3</td>
                              <td>Privacy Policy</td>
                              <td>published</td>
                              <td>
                                 <a href="{{ route('view-static-page',3) }}" data-toggle="tooltip" title="" class="pd-setting-ed" data-original-title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                              </td>
                           </tr>
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