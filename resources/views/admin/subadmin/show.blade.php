@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">View SubAdmin</h4>
        </div>
    </div>
</div>
<!-- Page Title Header Ends-->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                @if(Session::has('Success'))
                    <div class="alert alert-success">
                        <strong>Success ! </strong> {{Session::get('Success')}}
                    </div>
                @endif
                @if(Session::has('Failed'))
                    <div class="alert alert-danger">
                        <strong>Failed ! </strong> {{Session::get('Failed')}}
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-6 col-lg-6 table-responsive">
                        <table class="parent-details-table tcenter" width="100%">
                            <tbody>
                                <tr>
                                    <td>UserName</td>
                                    <td class="text-right">  {{ $subadmin->fname }}</td>
                                </tr> 
                                <tr>
                                    <td>Email Address</td>
                                    <td class="text-right">  {{ $subadmin->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 col-lg-6 table-responsive">
                        <table class="parent-details-table tcenter" width="100%">
                            <tbody>
                            <tr>
                                <td>Mobile Number</td>
                                <td class="text-right">  {{ $subadmin->mobile }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td class="text-right sub-add"> {{ $subadmin->address }}</td>
                            </tr> 
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{route('admin.subadmin.index')}}" class="btn btn-success btn-fw">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')
