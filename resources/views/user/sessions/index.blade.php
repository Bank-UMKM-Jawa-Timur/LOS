@extends('layouts.template')
<script>
    function currentTime(h, m, s, widget_id) {
        let date = new Date(); 
        //let hh = date.getHours();
        //let mm = date.getMinutes();
        //let ss = date.getSeconds();
        let hh = parseInt(h);
        let mm = parseInt(m);
        let ss = parseInt(s);
        let session = "AM";

        console.log(`date:${date}`)
        console.log(`h:${hh}`)
        console.log(`m:${mm}`)
        console.log(`s:${ss}`)

        if(hh > 12){
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;
        
        let time = hh + ":" + mm + ":" + ss + " " + session;
    
        document.getElementById("clock").innerText = time; 
        var t = setTimeout(function(){ currentTime(hh, mm, ss, "clock") }, 1000); 
    }
</script>

@section('content')
    @include('components.notification')
    <div class="row justify-content-between">
        <div class="col-md-6"></div>

        <div class="col-md-4">

            <form action="" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="keyword" placeholder="Cari Berdasarkan Email"
                        aria-label="Cati item" aria-describedby="basic-addon2" value="{{ Request::get('keyword') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    @include('user.sessions._table')
    </div>
@endsection
@push('custom-script')
    
@endpush
