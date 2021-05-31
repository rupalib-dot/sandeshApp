@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">User Posts List </h4>
        </div>
    </div>
</div>
<!-- Page Title Header Ends-->
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
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
                <table class="table table-striped table-responsive mt-3 ctable datatableinit">
                    <thead>
                        <tr>
                            <th> Post ID </th>
                            <th> Name </th>
                            <th> Date of Death </th>
                            <th> Relation </th>
                            <th> Contact Number </th>
                            <th> Status </th>
                            <th> Action </th>
                            <!-- <th> Note </th> -->
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($posts) >0)
                        @foreach($posts as $post)
                            <tr>
                                <td class="idinput"> {{ $post->id }} </td>
                                <td> {{ $post->person_name }} </td>
                                <td> {{ $post->date_of_death }} </td>
                                <td> {{ $post->relation }} </td>
                                <td> {{ $post->number }} </td>
                                <td>
                                    @if($post->approval_status == config('constant.APPROVAL_STATUS.UNKNOWN'))
                                        <form class="d-inline-block" action="{{route('admin.posts.postStatusUpdate')}}"
                                              method="POST" onclick="return confirm('Are you sure you want to Approve this post ?');">
                                            @csrf
                                            <input type="hidden" name="approval_status" value="{{ config('constant.APPROVAL_STATUS.APPROVED') }}">
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit" class="btn btn-primary mr-3 mb-1">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </form>
                                        <form class="d-inline-block" action="{{route('admin.posts.postStatusUpdate')}}"
                                              method="POST" onclick="return confirm('Are you sure you want to Reject this post ?');">
                                            @csrf
                                            <input type="hidden" name="approval_status" value="{{ config('constant.APPROVAL_STATUS.REJECTED') }}">
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button type="submit" class="btn btn-danger mr-3 mb-1" style="    width: 49px;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @elseif($post->approval_status == config('constant.APPROVAL_STATUS.REJECTED'))
                                        <button type="button" class="btn btn-danger" style="    width: 49px;">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-success" style="    width: 49px;">
                                            <i class="fa fa-check-circle"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.posts.showpost', $post->id) }}" class="btn btn-primary mr-3">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <form class="d-inline-block"
                                          action="{{route('admin.posts.destroy',$post->id)}}"
                                          method="POST" onclick="return confirm('Are you sure you want to Delete this post ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <!-- <td style="    min-width: 130px;">
                                    <button type="button" class="btn btn-primary openModal">
                                        <i class="fa fa-plus pr-2"></i> Send Note
                                    </button>
                                </td> -->
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">
                                No Posts Found
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{route('admin.posts.index')}}" class="btn btn-success btn-fw">Go Back</a>
        </div>
    </div>
</div>
@include('admin.layouts.footer')

<!-- Modal -->
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Send Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4">
                <form class="form-sample js-form"  action="{{route('admin.posts.sendMessage',$post->id)}}"
                      method="POST" onsubmit="return confirm('Are you sure you want to Send this Note to User ?');"  data-validate>
                    @csrf
                    <input type="hidden" name="id" class="modalinput" value="{{ $post->id }}">
                    <div class="row">
                        <div class="col-12">
                            <textarea  class="form-control @error('fname') redborder @enderror" name="addnote" minlength="4" maxlength="300" required
                              value="{{Request::old('fname')}}" style="height: 240px;" required></textarea>
                            @error('fname')
                            <div class="rederror">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Note</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        console.log('sdsd');
        $('.openModal').on('click', function(){
            // console.log($(this).parent().parent().find('.idinput').html().trim());
            $('#noteModal .modalinput').val($(this).parent().parent().find('.idinput').html().trim());
            $('#noteModal').modal('show');
        });
    });
</script>

<script>
    var bouncer = new Bouncer('[data-validate]', {
        disableSubmit: false,
        customValidations: {
            valueMismatch: function (field) {

                // Look for a selector for a field to compare
                // If there isn't one, return false (no error)
                var selector = field.getAttribute('data-bouncer-match');
                if (!selector) return false;

                // Get the field to compare
                var otherField = field.form.querySelector(selector);
                if (!otherField) return false;

                // Compare the two field values
                // We use a negative comparison here because if they do match, the field validates
                // We want to return true for failures, which can be confusing
                return otherField.value !== field.value;

            }
        },
        messages: {
            valueMismatch: function (field) {
                var customMessage = field.getAttribute('data-bouncer-mismatch-message');
                return customMessage ? customMessage : 'Please make sure the fields match.'
            }
        }
    });

    document.addEventListener('bouncerFormInvalid', function (event) {
        console.log(event.detail.errors);
        console.log(event.detail.errors[0].offsetTop);
        window.scrollTo(0, event.detail.errors[0].offsetTop);
    }, false);

    document.addEventListener('bouncerFormValid', function () {
        // alert('Form submitted successfully!');
        // window.location.reload();
    }, false);

</script>
