@include('admin.layouts.head')
<style>
    .card-head{
        text-align: center;
        margin-top: 20px;
    }
    .card-body
    {
        text-align: center;
        padding-top: 5px !important; 
    }
</style>
    <div class="row page-title-header">
        <div class="col-12">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- Page Title Header Ends-->
    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4>Subadmin Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($subadmin)}}</b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4> User Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($users)}}</b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4>Post Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($posts)}}</b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4>Last Seven Day Post Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($lastSevenDayPosts)}}</b></h4>
                </div>
            </div>
        </div> 
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4>Todays Post Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($todaysPosts)}}</b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4>Last One Month Post Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($lastOneMonthPosts)}}</b></h4>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-head">
                    <h4>Today Users Registered Count</h4>
                </div>
                <div class="card-body">
                    <h4><b>{{count($userCreatedToday)}}</b></h4>
                </div>
            </div>
        </div> 
    </div>
@include('admin.layouts.footer')
