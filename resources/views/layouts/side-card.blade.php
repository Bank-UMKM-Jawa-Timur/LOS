<div class="row">
    <div class="col-md-3">
        <div class="box-content side-wizard px-4 py-4 ">
            <ul>
                <li><label>DATA UMUM</label></li>
                <li data-index='0'><a href="#"><span><i>99%</i></span> Data Umum</a></li>
                <li><label>PEMBAHASAN PER ASPEK</label></li>
                <li data-index='1'><a href="#"><span><i class="fa fa-ban"></i></span> Management</a></li>
                <li data-index='2'><a href="#"><span><i class="fa fa-ban"></i></span> Hukum/Jaminan</a></li>
                <li data-index='3'><a href="#"><span><i class="fa fa-ban"></i></span> Teknis & Produksi</a></li>
                <li data-index='4'><a href="#"><span><i class="fa fa-ban"></i></span> Aspek Pemasaran</a></li>
                <li data-index='5'><a href="#"><span><i class="fa fa-ban"></i></span> Aspek Keuangan</a></li>
                {{-- <li><a href="#"><span><i class="fa fa-ban"></i></span> Input Step 5</a></li> --}}
                {{-- <li><a href="#"><span><i class="fa fa-ban"></i></span> Input Step 6</a></li> --}}
                {{-- <li><a href="#"><span><i class="fa fa-ban"></i></span> Input Step 7</a></li> --}}
                {{-- <li><a href="#"><span><i class="fa fa-ban"></i></span> Input Step 8</a></li> --}}
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
