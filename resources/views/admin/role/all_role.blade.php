@extends('admin.admin_layouts')
@section('admin_content')


<!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Admin Table</h5>
          
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Admin List
          	<a href="{{route('create.admin')}}" class="btn btn-sm btn-warning" style="float: right;">Add New</a>
          </h6>
          <br>    
      
          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Name</th>
                  <th class="wd-15p">Phone</th>
                  <th class="wd-15p">Access</th>
                  <th class="wd-15p">Action</th>

                   
                </tr>
              </thead>
              <tbody>
              	@foreach($user as $row)
                <tr>
                  <td>{{$row->name}}</td>
                  <td>{{$row->phone}}</td>
                  <td>
                  	@if($row->category==1)
                  	<span class="badge badge-dark">Category</span>
                  	@else
                  	@endif

                  	@if($row->coupon==1)
                  	<span class="badge badge-dark">Coupon</span>
                  	@else
                  	@endif

                  	@if($row->product==1)
                  	<span class="badge badge-dark">Product</span>
                  	@else
                  	@endif

                  	@if($row->blog==1)
                  	<span class="badge badge-dark">Blog</span>
                  	@else
                  	@endif

                  	@if($row->order==1)
                  	<span class="badge badge-dark">Order</span>
                  	@else
                  	@endif

                  	@if($row->report==1)
                  	<span class="badge badge-dark">Report</span>
                  	@else
                  	@endif

                  	@if($row->role==1)
                  	<span class="badge badge-dark">Role</span>
                  	@else
                  	@endif

                  	@if($row->return==1)
                  	<span class="badge badge-dark">Return</span>
                  	@else
                  	@endif

                  	@if($row->contact==1)
                  	<span class="badge badge-dark">Contact</span>
                  	@else
                  	@endif

                  	@if($row->comment==1)
                  	<span class="badge badge-dark">Comment</span>
                  	@else
                  	@endif

                  	@if($row->setting==1)
                  	<span class="badge badge-dark">Setting</span>
                  	@else
                  	@endif
                    
                    @if($row->stock==1)
                    <span class="badge badge-dark">Stock</span>
                    @else
                    @endif
                  	
                  </td>
                  <td>
                  	<a href="{{URL::to('edit/admin/'.$row->id)}}" class="btn btn-sm btn-info">edit</a>
                  	<a href="{{URL::to('delete/admin/'.$row->id)}}" class="btn btn-sm btn-danger" id="delete">delete</a>
                  </td>
                  
                </tr>
                @endforeach
       
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->

      </div><!-- sl-pagebody -->




@endsection