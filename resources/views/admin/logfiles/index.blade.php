@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Manage Log Files</h4>
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
                <table class="table table-striped mt-3">
                    <thead>
                    <tr>
                        <th> S.No </th>
                        <th> Files  </th>
                         <th> File Name  </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($files) > 0)
                    @php $i = 1; @endphp
                        @foreach ($files as $nKey =>$fileinfo)
                            <tr>
                                <td>{{ $i }} </td>
                                <td><a  style="color:#00fffe" download href="{{url('assets/logfiles')}}/{{$fileinfo}}"><i class="fa fa-file-alt"></i></a></td>
                                <td>{{$fileinfo}} </td>
                                <td>
                                    <a download href="{{url('assets/logfiles')}}/{{$fileinfo}}" class="btn btn-success btn-sm mr-2" title="Download File" alt="Download File"><i class="pl-1 fas fa-download"></i></a>
                                    <a  class="btn btn-danger btn-sm"  onclick="return confirm('Are you sure you want to delete this log file ?')" title="Delete File" alt="Delete File" href="{{Route('admin.logfiles.delete',$fileinfo)}}"class="btn btn-danger mr-3"> <i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @php $i++ ; @endphp
                        @endforeach
                     @else
                        <tr>
                            <td colspan="6" class="text-center">
                                No Log Files Found
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
