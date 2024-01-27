@if (session('status'))
<div class="border border-green-500 bg-green-500/5 p-5">
    <strong class="text-green-500">{{ session('status') }}</strong>
</div>
@endif

@if (session('error'))
<div class="border border-theme-primary bg-theme-primary/5 p-5">
    <strong class="text-theme-primary">{{ session('error') }}</strong>
</div>
@endif
