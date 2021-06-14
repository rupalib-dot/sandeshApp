@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Manage Users</h4>
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
                        <th style="width:70px;"> Acc ID </th>
                        <th> Name </th>
                        <th> Mobile </th>
                        <th> Date of Birth </th>
                        <th> Adhaar </th>
                        <th> Location </th>
                        <th  style="width:170px;"> Created On </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($users) >0)
                            @foreach($users as $index => $user)

                                <tr>
                                    <td> {{ $user->acc_id }} </td>
                                    <td class="sub-add"> {{ $user->fname }} {{ $user->lname }} </td>
                                    <td> {{ $user->mobile }} </td>
                                    <td> {{ date('d-m-Y', strtotime($user->dob)) }} </td>
                                    <td>
                                        @if(isset($user->adhaar_file))
                                            <a target="_blank" href="{{asset('storage/uploads/'.$user->adhaar_file) }}">Download</a>
                                        @else
                                            {{ $user->adhaar }}
                                        @endisset
                                    </td>
                                    <td class="sub-add"> {{ $user->address }} </td>
                                    <td> {{ date('d-m-Y, H:i a', strtotime($user->created_at)) }} </td>
                                    <td>
                                        <a href="{{route('admin.users.show', $user->id)}}" class="btn btn-primary mr-3 mb-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if($user->block_status == config('constant.STATUS.UNBLOCK'))
                                            <a onclick="return confirm('Are you sure you want to block this user?')"
                                               href="{{route('admin.users.changeStatus', ['id' => $user->id,'status' => config('constant.STATUS.BLOCK')])}}"
                                               class="btn btn-danger mr-3 mb-1">
                                                <i class="fas fa-lock-open"></i>
                                            </a>
                                        @else
                                            <a onclick="return confirm('Are you sure you want to unblock this user?')"
                                               href="{{route('admin.users.changeStatus', ['id' => $user->id,'status' => config('constant.STATUS.UNBLOCK')])}}"
                                               class="btn btn-info mr-3 mb-1">
                                                <i class="fas fa-lock"></i>
                                            </a>
                                        @endif
                                        <form class="d-inline-block" action="{{route('admin.users.destroy', $user->id)}}"
                                              method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger mr-3 d-none mb-1"> <i class="fas fa-trash-alt"></i></button>
                                        </form>
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
