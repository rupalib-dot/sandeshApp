@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Post Details</h4>
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
                                    <td>Person Name</td>
                                    <td class="text-right">  {{ $post->person_name .' '. $post->surname }}</td>
                                </tr>
                                <tr>
                                    <td>Age</td>
                                    <td class="text-right">  {{ $post->age }}</td>
                                </tr>
                                <tr>
                                    <td>Date Of Death</td>
                                    <td class="text-right"> {{ $post->date_of_death }}</td>
                                </tr>

                                <tr>
                                    <td>Number</td>
                                    <td class="text-right">  {{ $post->number }}</td>
                                </tr>
                                <tr>
                                    <td>Relation</td>
                                    <td class="text-right">  {{ $post->relation }}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td class="text-right">  {{ $post->address }}</td>
                                </tr>
                                <tr>
                                    <td>Show Poc</td>
                                    <td class="text-right">  @if($post->show_poc == '') No @else Yes @endif </td>
                                </tr>
                                <tr>
                                    <td>Cause of death</td>
                                    <td class="text-right">  {{$post->death_cause}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 col-lg-6 table-responsive">
                        <table class="parent-details-table tcenter" width="100%">
                            <tbody>
                            <tr>
                                <td>Death Certificate</td>
                                <td class="text-right">  <a target="_blank" href="{{ asset('storage/uploads/'.$post->death_certificate) }}"> Download </a> </td>
                            </tr>
                            <tr>
                                <td>Person Pic</td>
                                <td class="text-right"> <a target="_blank" href="{{ asset('storage/uploads/'.$post->person_pic) }}"> Download </a> </td>
                            </tr>
                            <tr>
                                <td>Garland Flowers on Pic</td>
                                <td class="text-right"> {{ isset($post->flowers) ? 'Yes' : 'No' }} </td>
                            </tr>
                            <tr>
                                <td>Point Of Contact</td>
                                <td class="text-right"> {{ $post->pocontact .' '. $post->lname}} </td>
                            </tr>
                            <tr>
                                <td> Institute </td>
                                <td class="text-right"> {{ $post->institute }} </td>
                            </tr>
                            <tr>
                                <td> Approval Status </td>
                                <td class="text-right"> 
                                    @if($post->approval_status == 409)
                                        Rejected
                                    @elseif($post->approval_status == 410)
                                        Approved
                                    @else
                                        Approval Pending
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td class="text-right">  {{ $post->description }}</td>
                            </tr>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{route('admin.posts.show', $post->user_id)}}" class="btn btn-success btn-fw">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.layouts.footer')
