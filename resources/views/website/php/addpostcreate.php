<?php include('header.php'); ?>
<?php include('nav.php'); ?>
<section id="registrationPage" class="registrationPage" role="registration">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="registForm">
                    <h3 class="addHeading">Add/Post/Create</h3>
                    <form action="/action_page.php" class="formContactregi">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Name*" aria-label="Name*"
                                aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-4">
                            <input type="date" class="form-control" placeholder="Date of Birth*/approx* Age*"
                                aria-label="Date of Birth*/approx* Age*" aria-describedby="basic-addon1">
                            <span class="checkright2"> <i class="flaticon-calendar-interface-symbol-tool"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Death Certificate*" aria-label="Death Certificate*"
                                aria-describedby="basic-addon1">
                                <span class="checkright2"><i class="flaticon-upload"></i></span>
                        </div>


                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Social Identification*" aria-label="Social Identification*"
                                aria-describedby="basic-addon1">
                            <span class="checkright2"><i class="flaticon-upload"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Location*"
                                aria-label="Location*" aria-describedby="basic-addon1">
                            <span class="checkrightlocation"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Institute/Org/Ms*" aria-label="Institute/Org/Ms*    "
                                aria-describedby="basic-addon1">
                        </div>
                        <button class="createpost btn">Create Post</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 register2">
                <div class="registForm">
                    <form action="/action_page.php" class="formContactregi">
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Surname*" aria-label="Surname*"
                                aria-describedby="basic-addon1">

                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Date of Demise*" aria-label="Date of Demise*"
                                aria-describedby="basic-addon1">

                        </div>

                        <div class="input-group mb-4">
                            <input type="date" class="form-control" placeholder="Contact Number of Deceased*"
                                aria-label="Contact Number of Deceased*" aria-describedby="basic-addon1">
                            <span class="checkright2"> <i class="flaticon-calendar-interface-symbol-tool"></i></span>
                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Point of Contact Name & Mobile*" aria-label="Point of Contact Name & Mobile*"
                                aria-describedby="basic-addon1">

                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="S/o - W/o - D/o*"
                                aria-label="S/o - W/o - D/o*" aria-describedby="basic-addon1">

                        </div>
                        <div class="input-group mb-4">
                            <input type="text" class="form-control" placeholder="Relation With Deceased Dropdown*" aria-label="Relation With Deceased Dropdown*"
                                aria-describedby="basic-addon1">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>
