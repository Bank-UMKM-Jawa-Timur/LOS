@extends('layouts.tailwind-template')

@section('content')
<section class="p-5 overflow-y-auto">
    <div class="lg:flex grid grid-cols-1 justify-between w-full font-poppins">
        <div class="heading flex-auto">
            <p class="text-theme-primary font-semibold font-poppins text-xs">
                Change Password
            </p>
            <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                Change Password
            </h2>
        </div>
    </div>
    <div class="body-pages">
        <div class="mt-4">
            @include('components.notification')
        </div>
        <form action="{{ route('update_password', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
        <div class="bg-white mt-8 border p-5 space-y-5">
            <div class="form-group-2">
                <div class="input-box">
                    <label for="old-password">Password Lama <span class="text-theme-primary">*</span></label>
                    <input type="password" id="old-password" name="old-pass" class="form-input @error('old_pass') alert @endif " value="{{ old('old_pass') }}" placeholder="" />
                    @error('old_pass')
                    <small class="text-red-500">
                        {{ $message }}
                    </small>
                @enderror
                </div>
                <div class="input-box">
                    <label for="new-password">Password Baru <span class="text-theme-primary">*</span></label>
                    <input type="password" id="new-password" name="password" class="form-input  @error('password') alert @endif " value="{{ old('password') }}" placeholder="" />
                    @error('password')
                    <small class="text-red-500">
                        {{ $message }}
                    </small>
                @enderror
                </div>
                <div class="input-box">
                    <label for="confirm-password">Konfirmasi Baru <span class="text-theme-primary">*</span></label>
                    <input type="password" id="confirmation" name="confirm-password" value="{{ old('confirmation') }}" class="form-input @error('confirmation') alert @endif" placeholder="" />
                    @error('confirmation')
                    <small class="text-red-500">
                        {{ $message }}
                    </small>
                @enderror
                </div>
            </div>
            <button type="submit" class="btn bg-theme-primary text-white">Simpan Perubahan</button>
        </div>
        </form>
    </div>
</section>
@endsection