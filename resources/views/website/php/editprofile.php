<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<section id="editProfile" class="editProfile" role="edit profile">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="forgotPage">
                    <button class="close1"><i class="flaticon-cancel"></i></button>
                    <h4>Edit Profile</h4>
                    <form action="/action_page.php" class="formForgot">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="User Name"
                                        aria-label="User Name" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" placeholder="Email" aria-label="Email"
                                        aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-4">
                                    <input type="number" class="form-control" placeholder="Phone" aria-label="Phone"
                                        aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-4">
                                        <select class="form-control" id="exampleFormControlSelect1" placeholder="Gender"
                                            aria-label="Gender" aria-describedby="basic-addon2">
                                            <option>Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                
                                <div class="input-group mb-4">
                                    <input type="date" class="form-control" placeholder="Date of Birth" aria-label="Date of Birth"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <button class="Loginbtn">Update Profile</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>