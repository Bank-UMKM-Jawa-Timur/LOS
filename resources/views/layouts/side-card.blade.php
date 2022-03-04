<div class="row">
    <div class="col-md-3">
        <div class="box-content side-wizard px-4 py-4 ">
            <ul>
                <li class="active"><a href=""><span><i class="fa fa-check"></i></span> Input Step 1</a></li>
                <li class="active selected"><a href=""><span><i class="fa fa-check"></i></span> Input Step 2</a></li>
                <li><a href=""><span><i class="fa fa-ban"></i></span> Input Step 2</a></li>
                <li><a href=""><span><i class="fa fa-ban"></i></span> Input Step 2</a></li>
                <li><a href=""><span><i class="fa fa-ban"></i></span> Input Step 2</a></li>
                <li><a href=""><span><i class="fa fa-ban"></i></span> Input Step 2</a></li>
                <li><a href=""><span><i class="fa fa-ban"></i></span> Input Step 2</a></li>
                <li><a href=""><span><i class="fa fa-ban"></i></span> Input Step 2</a></li>
            </ul>
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
