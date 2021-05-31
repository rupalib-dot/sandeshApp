
</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="container-fluid clearfix">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © @php echo date('Y'); @endphp Sandesh </span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>

<script src="{{asset('assets/js/shared/off-canvas.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/cferdinandi/bouncer@1/dist/bouncer.polyfills.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCCNdiZ-QFwFBld5GxQAs0XiDQF5G8NE0U&libraries=places" async></script>
<script src="{{asset('assets/js/shared/misc.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{asset('assets/js/demo_1/dashboard.js') }}"></script>
<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();

        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('.datepkr').attr('max', maxDate);
    });
</script>


</body>
</html>
