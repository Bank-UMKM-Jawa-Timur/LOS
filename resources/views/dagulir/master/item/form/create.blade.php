@include('dagulir.master.kabupaten.modal.create')
@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@push('script-inject')
    <script>
        $('#page_length').on('change', function() {
            $('#form').submit()
        })
    </script>
@endpush
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Item
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Tambah item
                </h2>
            </div>
        </div>
        <div class="body-pages">
            <div class="p-5 bg-white w-full mt-8 border space-y-8">
                <div class="form-group-4">
                    <div class="input-box">
                        <label for="">Level</label>
                        <select name="" class="form-select" id="">
                            <option value="">-- Pilih Level --</option>
                            <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="">Item Turunan 1</label>
                        <select name="" class="form-select" id="">
                            <option value="">-- Pilih Item --</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="">Item Turunan 2</label>
                        <select name="" class="form-select" id="">
                            <option value="">-- Pilih Item --</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label for="">Item Turunan 3</label>
                        <select name="" class="form-select" id="">
                            <option value="">-- Pilih Item --</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-4">
                    <div class="input-box">
                        <label for="">Nama</label>
                        <input type="text" class="form-input" placeholder="Nama Item" name="" />
                        <div class="flex gap-2">
                            <input type="checkbox" name="" class="form-check" id="is-comment" />
                            <label for="is-comment">Dapat Dikomentari</label>
                        </div>
                    </div>
                    <div class="input-box">
                        <label for="">Opsi Jawaban</label>
                        <select name="" class="form-select" id="">
                            <option value="">-- Pilih Opsi Jawaban--</option>
                        </select>
                        <div class="flex gap-2">
                            <input type="checkbox" name="" class="form-check" id="is-skored" />
                            <label for="is-skored">Perhitungan Skor</label>
                        </div>
                    </div>
                </div>
                <div class="space-y-5">
                    <div class="form-group-4">
                        <div class="input-box">
                            <label for="">Opsi</label>
                            <input type="text" class="form-input" name="" placeholder="Nama Opsi"
                                id="" />
                        </div>
                        <div class="input-box">
                            <label for="">Skor</label>
                            <input type="text" class="form-input" name="" placeholder="Skor" id="" />
                        </div>
                        <div>
                            <button class="btn-add mt-10">
                                <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <div class="form-group-4">
                        <div class="input-box">
                            <label for="">Opsi</label>
                            <input type="text" class="form-input" name="" id=""
                                placeholder="Nama Opsi" />
                        </div>
                        <div class="input-box">
                            <label for="">Skor</label>
                            <input type="text" class="form-input" name="" placeholder="Skor" id="" />
                        </div>
                        <div class="flex gap-2">
                            <button class="btn-add mt-10">
                                <iconify-icon icon="fluent:add-12-filled" class="mt-3"></iconify-icon>
                            </button>
                            <button class="btn-minus mt-10">
                                <iconify-icon icon="tabler:minus" class="mt-3"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="flex gap-5">
                        <a href="{{route('dagulir.master.master-item.index')}}" class="px-5 py-2 bg-white border rounded">
                            Batal
                        </a>
                        <button class="bg-theme-primary px-5 py-2 text-white rounded">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('custom-script')
    <script>
        function resetPassword(name, id) {
            Swal.fire({
                title: 'Perhatian!!',
                text: "Apakah anda yakin mereset password " + name + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#112042',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'ResetPassword',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#resetPasswordForm" + id).submit()
                }
            })
        }
    </script>
@endpush
