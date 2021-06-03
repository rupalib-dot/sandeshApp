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
                <div class="alert alert-success hide500">
                    <strong>Success ! </strong> {{Session::get('Success')}}
                </div>
            @endif
            @if(Session::has('Failed'))
                <div class="alert alert-danger hide500">
                    <strong>Failed ! </strong> {{Session::get('Failed')}}
                </div>
            @endif
            <div class="row">
                @if(count($myposts) >0)
                    @foreach($myposts as $post)
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
                                        <h6>{{ date('d-m-Y', strtotime($post->date_of_death)) }} </h6>
                                        <p class="text-bold">{{ $post->person_name }}</p>
                                        <p class="sub-add"> {{ $post->description }} </p>
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
                                            @if($post->approval_status == 411)
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
                                            @endif
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
                                                <a href="{{ route('editmypost', $post->id) }}" class="btn-primary btn">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                                                </a>
                                            </span>
                                        @endif
                                    @else
                                        <span class="sandeshone"> 
                                            @if($post->approval_status == 409)
                                                Rejected
                                            @elseif($post->approval_status == 410)
                                                Approved
                                            @else
                                                Approval Pending
                                            @endif 
                                        </span>
                                        @if($post->approval_status != 410)
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

@endsection

