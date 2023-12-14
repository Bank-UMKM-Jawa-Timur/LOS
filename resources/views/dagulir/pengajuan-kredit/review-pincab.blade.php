@extends('layouts.tailwind-template')
@section('content')
<div class="p-3">

    <div class="container mx-auto mt-20 space-y-5">
        <h2 class="text-theme-primary font-bold text-3xl tracking-tighter">Review Pincab</h2>
        <div class="bg-white p-5 border rounded">
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>   
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                <div class="absolute right-5 top-3">
                    <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                </div>
                </div>
                <div class="accordion-content p-3">
                    <p>Content for section 1</p>
                </div>
            </div>
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>   
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                <div class="absolute right-5 top-3">
                    <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                </div>
                </div>
                <div class="accordion-content p-3">
                    <p>Content for section 1</p>
                </div>
            </div>
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>   
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                <div class="absolute right-5 top-3">
                    <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                </div>
                </div>
                <div class="accordion-content p-3">
                    <p>Content for section 1</p>
                </div>
            </div>
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>   
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                <div class="absolute right-5 top-3">
                    <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                </div>
                </div>
                <div class="accordion-content p-3">
                    <p>Content for section 1</p>
                </div>
            </div>
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>   
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                <div class="absolute right-5 top-3">
                    <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                </div>
                </div>
                <div class="accordion-content p-3">
                    <p>Content for section 1</p>
                </div>
            </div>
            <div class="accordion-section">
                <div class="accordion-header rounded pl-3 border border-theme-primary/5 relative">
                <div class="flex justify-start gap-3">
                    <button class="p-2 rounded-full bg-theme-primary w-10 h-10 text-white">
                        <h2 class="text-lg">1</h2>
                    </button>   
                    <h3 class="font-bold text-lg tracking-tighter mt-[6px]">Data Umum</h3>
                </div>
                <div class="absolute right-5 top-3">
                    <iconify-icon icon="uim:angle-down" class="text-3xl"></iconify-icon>
                </div>
                </div>
                <div class="accordion-content p-3">
                    <p>Content for section 1</p>
                </div>
            </div>
    
        </div>
    </div>
</div>
@endsection

@push('script-inject')
 <script>
    $(".accordion-header").click(function() {
    // Toggle the visibility of the next element with class 'accordion-content'
        $(this).next(".accordion-content").slideToggle();
    });
 </script>
@endpush