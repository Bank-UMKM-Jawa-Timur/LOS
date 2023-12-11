@extends('layouts.tailwind-template')
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
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
        <div class="body-pages">
            <div class="bg-white w-full  rounded mt-5 p-2 border">
                <div class="wrapper-tab-page pt-5">
                    <div class="tab-wrapper flex gap-0 pl-5 ">
                            <button data-tab="pengajuan-kredit" class="tab-button bg-white border px-5 py-2 font-medium tracking-tighter border-b-0">
                            <div class="flex gap-2">
                                <iconify-icon icon="solar:document-linear" class="mt-[3px]"></iconify-icon>
                                <span> Pengajuan Kredit</span>
                            </div>
                        </button>
                        <button data-tab="file-upload"  class="tab-button bg-gray-100 text-gray-600 border px-5 py-2 border-b-0"> 
                            <div class="flex gap-2">
                                <iconify-icon icon="solar:upload-linear" class="mt-[3px]"></iconify-icon>
                                <span> File yang dipuload</span>
                        </div>
                        </button>
                    </div>
                    <div class="border bg-white p-5 w-full">
                        <div id="pengajuan-kredit" class="tab-content ">
                            <h2>Pengajuan Kredit</h2>
                        </div>
                        <div id="file-upload" class="tab-content hidden">
                            <h2>File yang dipuload</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-inject')
<script>
$(".tab-wrapper .tab-button").click(function (e) {
  e.preventDefault();
  var tabId = $(this).data("tab");

  $(".tab-content").addClass("hidden");
  $(".tab-wrapper .tab-button").removeClass(
    "bg-white border-b border-theme-primary"
  );
  $(".tab-wrapper .tab-button").removeClass("text-gray-400");
  $(".tab-wrapper .tab-button").removeClass("text-theme-primary");

  $(".tab-wrapper .tab-button").addClass("text-gray-400");


  $(this).addClass("bg-white");
  $(this).addClass("text-gray-600");

  if (tabId) {
    $(this).removeClass("text-gray-400");
    $(this).removeClass("bg-gray-100");
  }

  $("#" + tabId).removeClass("hidden");
});
</script>
@endpush