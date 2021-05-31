<?php include('header.php'); ?>
<footer id="footer" class="footer" role="footer">
<div class="container">
    <div class="row">
        <div class="col-sm-12">
           <img class="img-fluid" src="images/logo.svg">
            <div class="footerLink">
              <ul>
               <li>
               <a href="#">Home</a>
               </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Faq</a>
                </li>
                <li >
                    <a href="#">Blog</a>
                </li>
                <li >
                    <a href="#">Contact Us</a>
                </li>
              </ul>
            </div>

        <div class="footerSocialIcon mt-4">
        <ul>
            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></li>
            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></li>
            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></li>
        </ul>
        </div>
        <hr>
        <div class="col-sm-12">
            <div class="cptext">
                <ul>
                    <li><span class="footerContact"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                    15, Usol'skaya Str., 614064, Perm, Russia
                    </</li>
                    <li><span class="footerContact"><i class="fa fa-volume-control-phone" aria-hidden="true"></i></span>
                    <a class="phoneControl" href="tel: +7 (342) 249-5509">+7 (342) 249-5509</a>
                    </li>
                    <li><span class="footerContact"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <a class="phoneControl" href="mailto: td_dami@Mail.Ru">td_dami@Mail.Ru</a>

                    </li>
                </ul>
                <p>© 2021 SANDESH</p>
            </div>
        </div>
    </div>
</div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/owl.carousel.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper(".swiper-container", {
        slidesPerView: 1,
        centeredSlides: true,
        freeMode: true,
        grabCursor: true,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        breakpoints: {
            500: {
                slidesPerView: 1
            },
            700: {
                slidesPerView: 1
            }
        }
    });
</script>
</body>
</html>
