<div class="box-content px-3 py-4 ">
    <div class="container cusutom">
        <div class="row row-breadcrumbs align-items-center">
            <div class="col-md-6">
                <h5>
                    <a @if(Request::segment(1)!='dashboard') onclick="window.history.back()" @endif>
                        @if(Request::segment(1)!='dashboard') <span class="fa fa-arrow-left mr-3 btn-rgb-primary fa-sm p-2 "></span> @endif </span>
                </a>
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
