@extends('website.app')

@section('title', 'My Post')

@section('content')
    <section id="postWall" class="postWall" role="post wall"
             style="background: url({{ asset('website/images/backimg2.png') }}) no-repeat center;
                    background-size: cover;">
        <div class="container"> 
            <div class="row" style="margin-bottom:20px">
                <div class="col-md-12">
                    @if($current_url == 'mydraft')
                    <h2 class="addHeading">My Draft</h2>
                    @else
                    <h2 class="addHeading">My Post</h2>
                    @endif
                </div>
            </div>
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
            <form action="@if($current_url == 'mydraft') {{route('showmydraft')}} @else {{route('showmypost')}} @endif" method="get">
                <div class="row">
                <div class="col-md-5 col-sm-6 col-12">
                        <div class="form-group mb-4 showind">
                            <input id="searchTextField" type="text" class="form-control @error('address') redborder @enderror"
                            placeholder="Location *" name="address" value="{{old('address',$request->address)}}"
                            onkeydown="clearoldAddress();" onkeyup="limit(this, 250);" onblur="checkautoClass();">
                            <span class="infoicos" onclick="autoDetectPickup()"><i class="fa fa-location-arrow field-icon" style="top:3px;" aria-hidden="true"></i></span>
                            <span class="infoicos" data-toggle="tooltip" data-placement="top" title="Enter manually or allow GPS to fetch your location">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </span>
                            <input type="hidden" id="ulocationlat" onkeydown="limit(this, 30);" onkeyup="limit(this, 10);"
                                name="lat" value="{{isset($post->lat) ? $post->lat : Request::old('lat')}}">
                            <input type="hidden" id="ulocationlong" onkeydown="limit(this, 30);" onkeyup="limit(this, 10);"
                                name="long" value="{{isset($post->long) ? $post->long : Request::old('long')}}">
                            <span class="infoicos" onclick="autoDetectPickup()"></span>  
                        </div> 
                    </div> 
                    <div class="col-md-2 col-sm-2 col-12 pr-0">
                        <div class="form-group mb-4 showind">
                            <input id="searchTextField filter" style="width: 104%;padding: 22px;margin-top: .5px;" type="date" max="{{date('Y-m-d')}}" class="form-control @error('date') redborder @enderror"
                                    placeholder="Date *" name="date" value="{{old('date',$request->date)}}" > 
                        </div> 
                    </div>
                    <div class="col-md-2 col-sm-2 col-12 pr-0">
                        <div class="form-group mb-4 showind">
                            <input id="searchTextField filter" style="width: 104%;padding: 22px;margin-top: .5px;" type="date" max="{{date('Y-m-d')}}" class="form-control @error('to_date') redborder @enderror"
                                    placeholder="Date *" name="to_date" value="{{old('to_date',$request->to_date)}}" > 
                        </div> 
                    </div>
                    <div class="col-md-3 col-sm-2 col-12"> 
                        <button style="margin-top:0px" type="submit" class="signUp1 btn createpost btn">Filter</button> 
                        <a href="@if($current_url == 'mydraft') {{url('mydraft')}} @else {{url('mypost')}} @endif"><button style="margin-top:0px" type="button" class="signUp1 btn createpost btn">Clear Filter</button></a>
                    </div>
                </div> 
            </form> 
            <div class="row">
                @if(count($myposts) >0)
                    @foreach($myposts as $post)
                    @php $bdate      =   date('m/d/Y',strtotime($post->age));
                        $ddate      =   date('m/d/Y',strtotime($post->date_of_death));
                        $ageyears   =   date_diff(date_create($bdate), date_create($ddate))->y;
                        $agemonths  =   date_diff(date_create($bdate), date_create('now'))->m;
                        $agedays    =   date_diff(date_create($bdate), date_create('now'))->d; @endphp
                        <div class="col-md-6 pb-4">
                            <div class="sandeshBox2 bg-white" >
                                <div class="d-flex">
                                    <div class="imghodl flowerss @if($post->flowers) @if($post->flower_type == 'w') whiteflowersss @elseif($post->flower_type == 'p') pinkflowersss @else  flowersss @endif @endif"
                                         style=" background: url({{  isset($post->person_pic) ?
                                                                    asset('storage/uploads/'.$post->person_pic) :
                                                                    asset('website/images/profile-placeholder.jpg') }}) no-repeat center;
                                             background-size:cover;
                                             min-width: 150px;
                                             min-height: 190px;
                                             width: 150px;
                                             height: 190px;
                                             position: relative;
                                             margin-bottom: 30px;">
                                    </div>
                                    <div class="sandeshpara">
                                        <div style="display: inline-flex;"><h6 style="width: 90px;">{{ date('d-m-Y', strtotime($post->date_of_death)) }} </h6><h6 style="margin-left: 15px;">Age:-  @if($ageyears == 0) {{$agemonths}} Month @else {{$ageyears}} Year @endif</h6></div>
                                        @if(!empty($post->institute)) <br><div style="display: inline-flex;"><h6> {{$post->institute}}</h6></div> @endif <br>
                                        <div style="display: inline-flex;"><p class="text-bold">{{ $post->person_name .' '.$post->surname }}</p> <p style="margin-left: 15px;" class="text-bold"><b>{{strtolower($post->swd).'  '.$post->swdperson }}</b></p>  </div>
                                        <p class="sub-add"> @php echo nl2br($post->description) @endphp </p>
                                        <p class="sub-add">{{$post->address}} </p>
                                        @if($post->show_poc == 1 && $post->show_poc != '') <div style="display: inline-flex;">POC-Contact:- <p class="" style="margin-left:10px">{{ $post->pocontact .' '.$post->lname }}</p> <p style="margin-left: 15px;">{{$post->number}}</p>  </div> @endif                           
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    @if($post->is_draft == 0)
                                        <span class="sandeshone"> 
                                            @if($post->approval_status == 409)
                                                Rejected
                                            @elseif($post->approval_status == 410)
                                                Approved
                                            @else
                                                Approval Pending
                                            @endif
                                            <!-- @if($post->approval_status == 411)
                                                <p style="margin-top: 15px;">
                                                    <a style="margin-right: 8px;" onclick="return confirm('Are you sure you want to Approve this post ?');" href="{{ route('updatepoststatus', ['post'=>$post->id, 'status'=>410, 'created_at' =>strtotime($post->created_at)]) }}"
                                                    class="btn-primary btn">
                                                        Approve Post
                                                    </a>
                                                    <a onclick="return confirm('Are you sure you want to Reject this post ?');" href="{{ route('updatepoststatus', ['post'=>$post->id, 'status'=>409, 'created_at' =>strtotime($post->created_at)]) }}"
                                                    class="btn-primary btn">
                                                        Reject Post
                                                    </a>
                                                </p>
                                            @endif -->
                                        </span>
                                        @if($post->approval_status == 409)
                                            <span style="margin-top: 15px;">
                                                <form class="d-inline-block" action="{{route('mypostdelete')}}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to Delete this post ?');">
                                                    @csrf
                                                    <input type="hidden" name="postid" value="{{$post->id}}">
                                                    <button type="submit" class="btn-danger btn mr-2">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                </form>
                                                @if($post->approval_status == 409)
                                                    <a href="{{ route('editmypost', $post->id) }}" class="btn-primary btn">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                    </a>
                                                @endif
                                            </span>
                                        @elseif($post->approval_status == 411)
                                            <span style="margin-top: 24px;">
                                                <form class="d-inline-block" action="{{route('mypostdelete')}}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to Delete this post ?');">
                                                    @csrf
                                                    <input type="hidden" name="postid" value="{{$post->id}}">
                                                    <button type="submit" class="btn-danger btn mr-2">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                </form>
                                                @if($post->approval_status == 409)
                                                    <a href="{{ route('editmypost', $post->id) }}" class="btn-primary btn">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                    </a>
                                                @endif
                                            </span>
                                        @endif
                                    @else
                                        <!-- <span class="sandeshone"> 
                                            @if($post->approval_status == 409)
                                                Rejected
                                            @elseif($post->approval_status == 410)
                                                Approved
                                            @else
                                                Approval Pending
                                            @endif 
                                        </span> -->
                                        <a onclick="return confirm('Are you sure you want to send this post for approval?');" href="{{ route('changePostStatus', $post->id) }}" class="btn-primary btn">
                                             Send for Approval
                                        </a>
                                        @if($post->approval_status == 409)
                                            <span style="margin-top: 15px;">
                                                <form class="d-inline-block" action="{{route('mypostdelete')}}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to Delete this post ?');">
                                                    @csrf
                                                    <input type="hidden" name="postid" value="{{$post->id}}">
                                                    <button type="submit" class="btn-danger btn mr-2">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                </form>
                                                <a href="{{ route('editmypost', $post->id) }}" class="btn-primary btn">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                </a>
                                            </span>
                                        @elseif($post->approval_status != 410)
                                            <span style="margin-top: 24px;">
                                                <form class="d-inline-block" action="{{route('mypostdelete')}}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to Delete this post ?');">
                                                    @csrf
                                                    <input type="hidden" name="postid" value="{{$post->id}}">
                                                    <button type="submit" class="btn-danger btn mr-2">
                                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                                    </button>
                                                </form>
                                                <a href="{{ route('editmypost', $post->id) }}" class="btn-primary btn">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                </a>
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>No Posts Found </h4>
                @endif
            </div>
        </div>
    </section>
    <section id="paginationPage">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="paginationPara">
                        {{ $myposts->links('website.defaultpagination') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    function clearoldAddress(){
     var ulocationlat = document.getElementById('ulocationlat').value = null;
        var ulocationlong = document.getElementById('ulocationlong').value = null;
    }
    function checkautoClass(){
        var ulocationlat = document.getElementById('ulocationlat').value;
        var ulocationlong = document.getElementById('ulocationlong').value;
        if(ulocationlat != '' && ulocationlong != ''){
             return true;
        }
        else{
            document.getElementById('searchTextField').value= '';
            
        }
    }
</script>
@endsection

