@if (session('status'))
    <div class="bg-success text-primary border-t-4 border-primary rounded-b shadow-md mb-6 p-4">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <strong>{{ session('status') }}</strong>
    </div>
@endif

@if (session('error'))
    <div class="bg-danger text-white border-t-4 border-danger rounded-b shadow-md mb-6 p-4">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled text-white"></i>
        </button>
        <strong>{{ session('error') }}</strong>
    </div>
@endif
