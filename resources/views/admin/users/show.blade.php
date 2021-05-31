@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">View User</h4>
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
                                    <td>Acc ID</td>
                                    <td class="text-right">  {{ $user->acc_id }}</td>
                                </tr>
                                <tr>
                                    <td>First Name</td>
                                    <td class="text-right">  {{ $user->fname }}</td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td class="text-right"> {{ $user->lname }}</td>
                                </tr>
                                <tr>
                                    <td>Email Address</td>
                                    <td class="text-right">  {{ $user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 col-lg-6 table-responsive">
                        <table class="parent-details-table tcenter" width="100%">
                            <tbody>
                            <tr>
                                <td>Mobile Number</td>
                                <td class="text-right">  {{ $user->mobile }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td class="text-right"> {{ date('Y-m-d', strtotime($user->dob)) }}</td>
                            </tr>
                            <tr>
                                <td>Adhaar Number</td>
                                <td class="text-right">  {{ $user->adhaar }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td class="text-right sub-add">  {{ $user->address }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{route('admin.users.index')}}" class="btn btn-success btn-fw">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')
