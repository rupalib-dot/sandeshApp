@include('admin.layouts.head')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header">
            <h4 class="page-title">Manage Templates</h4>
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
                    <a  class="btn btn-primary btn-fw openModal">Add New</a>
                </div>
                <table class="table table-striped table-responsive mt-3 ctable datatableinit">
                    <thead>
                        <tr>
                            <th> S.No </th> 
                            <th>Message  </th>
                            <th>Created On  </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($templates) >0)
                            @foreach($templates as $index => $template)
                                <tr>
                                    <td> {{ $index + 1 }} </td>
                                    <td id="message_{{ $template->id }}" class="sub-add"> {{ $template->message }} </td> 
                                    <td> {{ date('d-m-Y, H:i a', strtotime($template->created_at)) }} </td>
                                    <td> 
                                        @if($template->block_status == config('constant.STATUS.UNBLOCK'))
                                            <a onclick="return confirm('Are you sure you want to block this template?')" href="{{route('admin.template.changeStatus', ['id' => $template->id,'status' => config('constant.STATUS.BLOCK')])}}" class="btn btn-danger mr-3 mb-1">
                                                <i class="fas fa-lock-open"></i>
                                            </a>
                                        @else
                                            <a onclick="return confirm('Are you sure you want to unblock this template?')" href="{{route('admin.template.changeStatus', ['id' => $template->id,'status' => config('constant.STATUS.UNBLOCK')])}}" class="btn btn-info mr-3 mb-1">
                                                <i class="fas fa-lock"></i>
                                            </a>
                                        @endif

                                        <form class="d-inline-block" action="{{route('admin.template.destroy', $template->id)}}"
                                              method="POST" onsubmit="return confirm('Are you sure you want to delete this template?');">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger mr-3 mb-1"> <i class="fas fa-trash-alt"></i></button>
                                        </form> 

                                        <a onclick="editTemplate('{{$template->id}}')" class="btn btn-success mr-3 mb-1">
                                            <i style="color: white;" class="fas fa-edit"></i>
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
<!-- Modal -->
<div class="modal fade" id="templateModal" tabindex="-1" role="dialog" aria-labelledby="templateModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add template</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-4">
                <form class="form-sample js-form"  action="{{route('admin.template.store')}}"
                      method="POST" data-validate>
                    @csrf
                    <input type="hidden" name="id" class="modalinput" value="">
                    <div class="row" style="margin-bottom:30px">
                        <div class="col-12">
                            <textarea  class="form-control @error('fname') redborder @enderror message" placeholder="Write a Template" name="message" minlength="4" maxlength="750" required
                              value="{{Request::old('fname')}}" style="height: 150px;" required></textarea>
                            @error('fname')
                            <div class="rederror">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary button">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        console.log('sdsd');
        $('.openModal').on('click', function(){
            $('#templateModal').modal('show');
        });
    });
    function editTemplate(id){
        var msg = $("#message_"+id).text(); 
        $('#templateModal #exampleModalLongTitle').text('Edit Template');
        $('#templateModal .button').text('Update');
        $('#templateModal .message').val(msg);
        $('#templateModal .modalinput').val(id);
        $('#templateModal').modal('show');
    }
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
