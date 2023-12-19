{{-- @include('dagulir.master-dana.dana.modal.update',['data' => $update_data]) --}}
{{-- @include('dagulir.master-dana.dana.modal.update-cabang',['cabang' => $getCabang]) --}}
@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script>
        $('#page_length').on('change', function() {
            $('#form').submit()
        })
        $('.rupiah').keyup(function(e) {
            var input = $(this).val()
            $(this).val(formatrupiah(input))
        });

        // formatrupiah();

        function formatrupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }
    </script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Dana Dagulir
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Pelimpahan Dana Dagulir
                </h2>
            </div>
            <div class="layout lg:flex grid grid-cols-1 lg:mt-0 mt-5 justify-end gap-5">

            </div>
        </div>
        <div class="body-pages">
            <div class="table-wrapper border bg-white mt-8">
                <form action="{{ route('master-dana.update',$update_data->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group-2 mb-4">
                            <div class="input-box">
                                <label for="">Dana Idle</label>
                                <input type="text" name="dana_idle"
                                    class="form-input @error('dana_idle') is-invalid @enderror rupiah" placeholder="Dana Idle"
                                    id="dana_idle"
                                    value="{{ old('dana_idle',$update_data->dana_idle) }}">
                                @error('dana_idle')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-box">
                                <label for="">Dana Modal</label>
                                <input type="text" name="dana_modal"
                                    class="form-input @error('dana_modal') is-invalid @enderror rupiah" placeholder="Dana Modal"
                                    id="dana_modal"
                                    value="{{ old('dana_modal',$update_data->dana_modal) }}">
                                @error('dana_modal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-end">
                        <button type="reset" class="btn-cancel" >
                            Batal
                        </button>
                        <button type="submit" class="btn-submit">update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
