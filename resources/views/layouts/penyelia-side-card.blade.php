<div class="row">
    <div class="col-md-3">
        <div class="box-content side-wizard px-4 py-4 ">
            <ul>
                <li><label>DATA UMUM</label></li>
                <li data-index='0'>
                    <input type="hidden" name="answer" class="answer">
                    <input type="hidden" name="answerFilled" class="answerFilled">
                    <a href="#"><span><i>0%</i></span> Data Umum</a>
                </li>
                <li data-index='1'>
                    <input type="hidden" name="answer" class="answer">
                    <input type="hidden" name="answerFilled" class="answerFilled">
                    <a href="#"><span><i>0%</i></span> Data PO</a>
                </li>
                <li><label>PEMBAHASAN PER ASPEK</label></li>
                @foreach ($dataAspek as $key => $value)
                    @php
                        $key += 1;
                    @endphp
                <li data-index='{{ $key }}' class="{{ request()->routeIs('pengajuan-kredit.edit') == 'pengajuan-kredit' ? 'active' : '' }}">
                    <input type="hidden" name="answer" class="answer">
                    <input type="hidden" name="answerFilled" class="answerFilled">
                    <a href="#"><span><i class="fa fa-ban"></i></span>{{ $value->nama }}</a>
                </li>
                @endforeach

                <li><label> PENDAPAT dan USULAN PENYELIA KREDIT</label></li>
                <li class="last" data-index='{{count($dataAspek) + 1}}'>
                    <input type="hidden" name="answer" class="answer">
                    <input type="hidden" name="answerFilled" class="answerFilled">
                    <a href="#"><span><i class="fa fa-ban"></i></span> Pendapat dan Usulan</a>

                </li>
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
