@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Users with Posts List </h4>
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
                <table class="table table-striped table-responsive mt-3 ctable datatableinit">
                    <thead>
                    <tr>
                        <th> Acc Id </th>
                        <th> Name </th>
                        <th class="text-center"> Total Posts </th>
                        <th> Adhaar </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($users) >0)
                        @foreach($users as $user)
                            <tr>
                                <td> {{ $user->acc_id }} </td>
                                <td class="sub-add"> {{ $user->fname }} {{ $user->lname }} </td>
                                <td class="text-center"> {{ $user->posts_count }} </td>
                                <td> {{ $user->adhaar }} </td>
                                <td>
                                    <a href="{{route('admin.posts.show', $user->id)}}" class="btn btn-primary mr-3">
                                        <i class="fa fa-eye"></i>
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
