@extends('layouts._comman')
@section('title', 'Create User - Knote')
@section('styles')

@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('staff.users.list')}}">Users</a></li>
                                <li class="breadcrumb-item active">Create</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Create New User</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <form action="{{ route('staff.users.store') }}" name="admin/users/create" method="post"
                        onsubmit="return false;" enctype="multipart/form-data">
                        <div class="card-box">


                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="">Full Name<span class="text-danger">*</span></label>
                                        <input type="text" id="" name="fullname" value="{{ old('fullname') }}"
                                            class="form-control" placeholder="Full Name">
                                        @error('fullname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="">Email Address<span class="text-danger">*</span></label>
                                        <input type="text" id="" name="email_address" value="{{ old('email_address') }}"
                                            class="form-control" placeholder="Email Address">
                                        @error('email_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="">Phone<span class="text-danger">*</span></label>
                                        <input type="text" id="" name="phone" value="{{ old('phone') }}"
                                            class="form-control phone-field" placeholder="Phone">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="">Role<span class="text-danger">*</span></label>
                                        <select name="role_id" id="role_id" class="form-control">
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="">Address</label>
                                        <textarea name="address" class="form-control" placeholder="Address" rows="1">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group mb-3">
                                        <label for="">Profile Picture</label>
                                        <input type="file" name="profile_picture" class="form-control" accept="image/*">
                                        @error('profile_picture')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-lg-12 text-right">
                                    <hr>
                                    <button class="btn btn-success mt-3" type="submit" id="user-add">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end card-box -->
                </div>
                <div class="col-lg-4">

                </div>
            </div>
            <!-- container -->

        </div>
        <!-- container -->
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $('#user-add').click(function () {
            var url = $('#user-add').closest('form').attr('action');
            var form = $('#user-add').closest('form')[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.status == 200) {
                        $('#user-add').closest('form')[0].reset();
                        toaserMessage(response.status, response.message);
                        setTimeout(function () { window.location.href = "{{ route('staff.users.list') }}"; }, 2000);
                    }
                },
                error: function (reject) {
                    if (reject.status === 422) {
                        var errors = reject.responseJSON.errors;

                        // Clear previous error messages
                        $('.text-danger').remove();

                        // Loop through the errors and display them below the respective input fields
                        $.each(errors, function (key, message) {
                            var inputField = $('[name=' + key + ']');
                            inputField.after('<span class="text-danger">' + message[0] + '</span>');
                        });
                    }
                }
            });
        });

    </script>
@endsection