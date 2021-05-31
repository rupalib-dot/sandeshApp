<?php include('header.php'); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#"><img class="img-fluid" src="images/logo.svg"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto justify-content-end">
                <li class="nav-item">
                    <a class="nav-item nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="#">Faq</a>
                </li>
                <li class="nav-item">
                    <a class="nav-item nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item navbar-dropdown">
                    <a class="nav-item nav-link" href="#">My Account<span class="down-caret"></span></a>
                
                    <div class="dropdown">
                        <a href="#">My profile</a>
                        <a href="#">My post</a>
                        <a href="#">Change password</a>
                        <a href="#">Logout</a>
                    </div>
                </li>




                <li class="nav-item last">
                    <a class="nav-item nav-link last" href="#">Add/Create/Post</a>
                </li>
            </ul>
        </div>
</nav>