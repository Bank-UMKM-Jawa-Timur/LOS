<div class="row">
    <div class="col-md-3">
        <div class="sidebox-content px-3 py-4 ">
        </div>
    </div>
    <div class="col-md-9">
        <div class="box-content px-3 py-4 ">
            <div class="container cusutom">
                <div class="row row-breadcrumbs align-items-center">
                    <div class="col-md-6">
                        <h5>
                        {{ ucwords(str_replace('-',' ',Request::segment(1))) }}</h5>
                    </div>
                    <div class="col-md-6 text-right">
                        <h6>{{ ucwords(str_replace('-',' ',Request::segment(1))) }} / {{$pageTitle}}</h6>
                    </div>
                </div>
                <hr class="mt-4">
                @yield('content')
            </div>
        </div>   
    </div>
</div>
