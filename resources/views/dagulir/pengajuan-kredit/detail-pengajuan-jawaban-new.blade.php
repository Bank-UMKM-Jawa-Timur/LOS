@extends('layouts.tailwind-template')
@section('content')
<nav class="w-full bg-white p-3  top-[4rem] border sticky">
    <div class="tab-wrapper form-group-5 justify-center gap-2">
        <button data-toggle="tab" data-tab="dagulir" class="btn btn-tab active-tab font-semibold"><span class="percentage">0%</span> Data Umum </button>
        <button data-toggle="tab" data-tab="aspek-management" class="btn btn-tab font-semibold"><span class="percentage">0%</span> Aspek Management</button>
        <button data-toggle="tab" data-tab="aspek-hukum" class="btn btn-tab font-semibold"><span class="percentage">0%</span> Aspek Hukum</button>
        <button data-toggle="tab" data-tab="aspek-jaminan" class="btn btn-tab font-semibold"><span class="percentage">0%</span> Aspek Jaminan</button>
        <button data-toggle="tab" data-tab="aspek-pemasaran" class="btn btn-tab font-semibold"><span class="percentage">0%</span> Aspek Pemasaran</button>
        <button data-toggle="tab" data-tab="aspek-keuangan" class="btn btn-tab font-semibold"><span class="percentage">0%</span> Aspek Keuangan</button>
        <button data-toggle="tab" data-tab="pendapat-dan-usulan" class="btn btn-tab font-semibold"><span class="percentage">0%</span> Pendapat dan Usulan</button>
    </div>
</nav>
<div class="p-3">
    <div class="body-pages review-pengajuan">
        <div class="mt-3 container mx-auto">
            <div id="dagulir-tab" class="is-tab-content active">
                <div class="pb-10 space-y-3">
                    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">Dagulir</h2>
                    <p class="font-semibold text-gray-400">Review Pengajuan</p>
                </div>
                <div class="self-start bg-white w-full border">
                    <div class="p-5 border-b">
                        <h2 class="font-bold text-lg tracking-tighter">
                            Pengajuan Masuk
                        </h2>
                    </div>
                    {{-- data umum --}}
                    <div class="p-5 w-full space-y-5" id="data-umum">
                        {{-- two columns --}}
                        <div class="form-group-2">
                            {{-- Nama Lengkap --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Nama Lengkap</label>
                                </div>
                                <div class="field-answer">
                                    <p>Mohammad Sahrullah</p>
                                </div>
                            </div>
                            {{-- Email --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Email</label>
                                </div>
                                <div class="field-answer">
                                    <p>mohammadsahrullah894@mail.com</p>
                                </div>
                            </div>
                            {{-- Tempat Lahir --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Tempat Lahir</label>
                                </div>
                                <div class="field-answer">
                                    <p>Probolinggo</p>
                                </div>
                            </div>
                            {{-- Tanggal lahir --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Tempat Lahir</label>
                                </div>
                                <div class="field-answer">
                                    <p>07-Agustus-2002</p>
                                </div>
                            </div>
                            {{-- Telp--}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Telp</label>
                                </div>
                                <div class="field-answer">
                                    <p>07-Agustus-2002</p>
                                </div>
                            </div>
                            {{-- Telp--}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Jenis Usaha</label>
                                </div>
                                <div class="field-answer">
                                    <p>Sektor Kelautan dan Perikanan</p>
                                </div>
                            </div>
                            {{-- Foto nasabah--}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Foto nasabah</label>
                                </div>
                                <div class="field-answer">
                                    <p>Tidak ada file foto</p>
                                </div>
                            </div>
                            {{-- Status --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Status</label>
                                </div>
                                <div class="field-answer">
                                    <p>Sektor Kelautan dan Perikanan</p>
                                </div>
                            </div>
                            {{-- NIK --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">NIK</label>
                                </div>
                                <div class="field-answer">
                                    <p>Sektor Kelautan dan Perikanan</p>
                                </div>
                            </div>
                            {{-- Foto KTP Nasabah --}}
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Foto KTP Nasabah</label>
                                </div>
                                <div class="field-answer">
                                    <p>Tidak ada file foto.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Kota / Kabupaten KTP</label>
                                </div>
                                <div class="field-answer">
                                    <p>PONOROGO</p>
                                </div>
                            </div>
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Kecamatan KTP</label>
                                </div>
                                <div class="field-answer">
                                    <p>NGRAYUN</p>
                                </div>
                            </div>
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Desa KTP</label>
                                </div>
                                <div class="field-answer">
                                    <p>-</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Alamat KTP</label>
                                </div>
                                <div class="field-answer">
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, modi nam, quo ipsa ratione eius voluptates cum quasi vel dolore facere eveniet ullam aspernatur consectetur labore molestias pariatur nesciunt quod?</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">SLIK</label>
                                </div>
                                <div class="field-answer ">
                                    <p>-</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group-2 w-full">
                            <div class="input-box w-full flex-none">
                                <label for="" class="mt-2">Komentar:</label>
                                <input type="text" class="border-b px-4 py-2 w-full bg-gray-500/5 outline-none" placeholder="Masukan komentar">
                            </div>
                            <div class="input-box w-[14%] flex-auto">
                                <label for="" class="mt-2">SKOR:</label>
                                <input type="text"  value="4" class="border-b px-4 py-2 w-full bg-gray-500/5 outline-none" placeholder="">
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <button type="button"
                                class="px-5 py-2 border rounded bg-white text-gray-500">
                                Kembali
                            </button>
                            <button type="button"
                                class="px-5 py-2 next-tab border rounded bg-theme-primary text-white">
                                Selanjutnya
                            </button>
                        </div>
                    </div>
                    {{-- end data umum --}}
                </div>
            </div>
            <div id="aspek-management-tab" class="is-tab-content">
                <h2>Hello world</h2>
            </div>
            <div id="aspek-hukum-tab" class="is-tab-content"></div>
            <div id="aspek-jaminan-tab" class="is-tab-content">
            </div>
            <div id="aspek-pemasaran-tab" class="is-tab-content">
            </div>
            <div id="aspek-keuangan-tab" class="is-tab-content">
            </div>
            <div id="pendapat-dan-usulan-tab" class="is-tab-content">
            </div>
        </div>
    </div>
</div>
@endsection


@push('script-inject')
<script>
    
    // tab
    $(".tab-wrapper .btn-tab").click(function(e) {
        console.log(e);
        e.preventDefault();
        var tabId = $(this).data("tab");
        // countFormPercentage()

        $(".is-tab-content").removeClass("active");
        $(".tab-wrapper .btn-tab").removeClass("active-tab");
        $(".tab-wrapper .btn-tab").removeClass("active-tab");
        $(".tab-wrapper .btn-tab").removeClass("active-tab");
        $(".tab-wrapper .btn-tab").addClass("disable-tab");

        $(this).addClass("active-tab");

        if (tabId) {
            $(this).removeClass("disable-tab");
            $(this).removeClass("disable-tab");
        }

        $("#" + tabId + "-tab").addClass("active");
    });

    $(".next-tab").on("click", function(e) {
        const $activeContent = $(".is-tab-content.active");
        const $nextContent = $activeContent.next();
        // const tabId = $activeContent.attr("id")
        // const dataTab = tabId.replaceAll('-tab', '')
        // Set percentage
        // var percentage = formPercentage(tabId)
        // $('.tab-wrapper').find(`[data-tab=${dataTab}]`).find('.percentage').html(`${percentage}%`)
        // // Remove class active current nav tab
        // $('.tab-wrapper').find(`[data-tab=${dataTab}]`).removeClass('active-tab')

        if ($nextContent.length) {
            // const dataNavTab = $nextContent.attr("id") ? $nextContent.attr("id").replaceAll('-tab', '') : null
            // if (dataNavTab)
            //     $('.tab-wrapper').find(`[data-tab=${dataNavTab}]`).addClass('active-tab')
            $activeContent.removeClass("active");
            $nextContent.addClass("active");
        }else{
            $(".next-tab").addClass('hidden');
            $('.btn-simpan').removeClass('hidden')
        }

    });

    $(".prev-tab").on("click", function() {
        const $activeContent = $(".is-tab-content.active");
        const $prevContent = $activeContent.prev();
        // const tabId = $activeContent.attr("id")
        // var percentage = formPercentage(tabId)
        // const dataTab = tabId.replaceAll('-tab', '')
        // Set percentage
        // var percentage = formPercentage(tabId)
        // $('.tab-wrapper').find(`[data-tab=${dataTab}]`).find('.percentage').html(`${percentage}%`)
        // // Remove class active current nav tab
        // $('.tab-wrapper').find(`[data-tab=${dataTab}]`).removeClass('active-tab')

        if ($prevContent.length) {
            // const dataNavTab = $prevContent.attr("id") ? $prevContent.attr("id").replaceAll('-tab', '') : null
            // if (dataNavTab)
            //     $('.tab-wrapper').find(`[data-tab=${dataNavTab}]`).addClass('active-tab')
            $activeContent.removeClass("active");
            $prevContent.addClass("active");
            $(".next-tab").removeClass('hidden');
            $('.btn-simpan').addClass('hidden')
        }
    });

</script>
@endpush