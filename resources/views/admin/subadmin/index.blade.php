@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Manage SubAdmin</h4>
        </div>
    </div>
</div>
<!-- Page Title Header Ends-->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                @if(Session::has('Success'))
                    <div class="alert alert-success hide800">
                        <strong>Success ! </strong> {{Session::get('Success')}}
                    </div>
                @endif
                @if(Session::has('Failed'))
                    <div class="alert alert-danger hide800">
                        <strong>Failed ! </strong> {{Session::get('Failed')}}
                    </div>
                @endif
                <div class="text-right mb-4">
                    <a href="{{route('admin.subadmin.create')}}" class="btn btn-primary btn-fw">Add New</a>
                </div>
                <table class="table table-striped table-responsive mt-3 ctable datatableinit">
                    <thead>
                    <tr>
                        <!-- <th> ID </th> -->
                        <th  style="width:70px;"> Acc-Id </th>
                        <th> Name </th>
                        <th> Email ID </th>
                        <th> Mobile </th>
                        <th> Location </th>
                        <th style="width:170px;"> Created On </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($subadmin) >0)
                            @foreach($subadmin as $index => $subAdmin)
                                <tr>
                                    <!-- <td> {{ $index + 1 }} </td> -->
                                    <td> {{ $subAdmin->acc_id }} </td>
                                    <td class="sub-add"> {{ $subAdmin->fname }} </td>
                                    <td> {{ $subAdmin->email }} </td>
                                    <td> {{ $subAdmin->mobile }} </td>
                                    <td class="sub-add"> {{ $subAdmin->address }} </td>
                                    <td> {{ date('d-m-Y, H:i a', strtotime($subAdmin->created_at)) }} </td>
                                    <td>
                                        <a href="{{route('admin.subadmin.show', $subAdmin->id)}}" class="btn btn-primary mr-3 mb-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if($subAdmin->block_status == config('constant.STATUS.UNBLOCK'))
                                            <a onclick="return confirm('Are you sure you want to block this user?')" href="{{route('admin.subadmin.changeStatus', ['id' => $subAdmin->id,'status' => config('constant.STATUS.BLOCK')])}}" class="btn btn-danger mr-3 mb-1">
                                                <i class="fas fa-lock-open"></i>
                                            </a>
                                        @else
                                            <a onclick="return confirm('Are you sure you want to unblock this user?')" href="{{route('admin.subadmin.changeStatus', ['id' => $subAdmin->id,'status' => config('constant.STATUS.UNBLOCK')])}}" class="btn btn-info mr-3 mb-1">
                                                <i class="fas fa-lock"></i>
                                            </a>
                                        @endif
                                        <a href="{{route('admin.subadmin.edit', $subAdmin->id)}}" class="btn btn-success mr-3 mb-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    No Users Found
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')
