@extends('layouts.tailwind-template')
@section('content')
<section class="p-5 overflow-y-auto mt-5">
    <div class="head space-y-5 w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
               Proses Pembayaran
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                Proses Pembayaran
            </h2>
        </div>
    </div>
    <div class="body-pages">
        <div class="table-wrapper border bg-white mt-3 p-5">
            <form action="{{ route('pembayaran.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group-3">
                    <div class="input-box">
                        <label for="">File Txt</label>
                        <input type="file" name="file_txt" class="form-input" id="">
                    </div>
                    <div class="input-box">
                        <label for="">Dictionary</label>
                        <input type="file" name="file_dic" class="form-input" id="">
                    </div>
                    {{-- <div class="input-box">
                        <label for="">Nomi</label>
                        <input type="file" name="file_nomi" class="form-input" id="">
                    </div> --}}
                </div>
                <div class="flex justify-end my-5 py-4">
                    <button class="px-5 py-2 border rounded bg-theme-primary text-white">Check File</button>
                </div>
            </form>
            @if ($data != null)
            <div class="table-responsive pl-5 pr-5">
                {{-- <form action="{{ route('pembayaran.filter') }}" method="POST">
                    @csrf
                    <div class="flex justify-end my-4">
                        <div class="form-group flex justify-center align-middle items-center" >
                            <div class="input-box">
                                <label for="">Filter</label>
                                <select name="filter" class="form-select" id="">
                                    <option value="0">Pilih Filter</option>
                                    <option value="PYSPI" {{ request('filter') == 'PYSPI' ? 'selected' : ' ' }}>PYSPI</option>
                                    <option value="PDYPI" {{ request('filter') == 'PDYPI' ? 'selected' : ' ' }}>PDYPI</option>
                                    <option value="MRYPI+" {{ request('filter') == 'MRYPI+' ? 'selected' : ' ' }}>MRYPI+</option>
                                </select>
                            </div>
                            <div class="items-center mt-8 mx-2">
                                <button type="submit" class="px-5 py-2 border rounded bg-theme-primary text-white">Filter Data</button>
                            </div>
                        </div>
                    </div>
                </form> --}}

                <table class="tables">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sequence</th>
                            <th>No. Loan</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Nominal</th>
                            <th>Tipe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $key => $item)
                        @php
                            $date = strtotime($item['HLDTVL']);
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item['HLSEQN'] }}</td>
                            <td>{{ $item['HLLNNO'] }}</td>
                            <td>{{ date('d-m-Y',$date) }}</td>
                            <td>{{ number_format((int)$item['HLORMT'] / 100,2,",",".") }}</td>
                            <td>{{ $item['HLACKY'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            @endif

        </div>
    </div>
</section>
@endsection
