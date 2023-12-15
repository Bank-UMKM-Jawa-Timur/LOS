@extends('layouts.tailwind-template')
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="container mx-auto mb-5">
            <div class="head space-y-5 w-full font-poppins">
                <div class="heading flex-auto">
                    <p class="text-theme-primary font-semibold font-poppins text-xs">
                        Dagulir
                    </p>
                    <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                        Review
                    </h2>
                </div>
            </div>
        </div>
        <div class="body-pages">
        <div class="container mx-auto p-3 bg-white">
        <div class="accordion-section">
            <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-between gap-3">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                    <div class="transform accordion-icon mr-2 mt-1">
                        <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="accordion-content p-3">
                @include('dagulir.pengajuan-kredit.review.data-umum')
            </div>
        </div>
        <div class="accordion-section">
            <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-between gap-3">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">2</h2>
                    </button>
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Pendapat dan Usulan</h3>
                </div>
                    <div class="transform accordion-icon mr-2 mt-1">
                        <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="accordion-content hidden p-3">
                <div class="divide-y-2 divide-red-800">
                    <div class="p-4 bg-theme-primary text-white">
                        <div class="form-group-2">
                            <div class="field-review">
                                <div class="field-name">
                                    <label for="">Pendapat & Usulan
                                        (Staff)</label>
                                </div>
                                <div class="field-answer">
                                    <p>OKE</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="p-4 bg-theme-primary text-white">
                    <div class="form-group-2">
                        <div class="field-review">
                            <div class="field-name">
                                <label for="">Pendapat & Usulan
                                    (Penyelia)</label>
                            </div>
                            <div class="field-answer">
                                <p>OKE</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-theme-primary text-white">
                    <div class="form-group-2">
                        <div class="field-review">
                            <div class="field-name">
                                <label for="">Pendapat & Usulan
                                    (Penyelia)</label>
                            </div>
                            <div class="field-answer">
                                <p>0864929</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-theme-primary text-white">
                    <div class="form-group-2">
                        <div class="field-review">
                            <div class="field-name">
                                <label for="">Pendapat & Usulan Pimpinan Cabang</label>
                            </div>
                            <div class="field-answer">
                                <textarea class="form-textarea w-full" placeholder="isi pendapat..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-theme-primary text-white">
                    <div class="form-group-2">
                        <div class="field-review">
                            <div class="field-name">
                                <label for="">Pendapat & Usulan Pimpinan Cabang</label>
                            </div>
                            <div class="field-answer">
                                <input type="text" class="form-input" placeholder="isi pendapat dan usulan">
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </section>
@endsection

@push('script-inject')
    <script>
        $(".accordion-header").click(function() {
            // Toggle the visibility of the next element with class 'accordion-content'
            $(this).next(".accordion-content").slideToggle();
            // $(this).find(".accordion-icon").toggleClass("rotate-180");
        });
    </script>
@endpush
