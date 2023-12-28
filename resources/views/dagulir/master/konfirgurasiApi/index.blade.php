@extends('layouts.tailwind-template')
@include('components.new.modal.loading')
@section('content')
    <section class="p-5 overflow-y-auto mt-5">
        <div class="head lg:flex grid grid-cols-1 justify-between w-full font-poppins">
            <div class="heading flex-auto">
                <p class="text-theme-primary font-semibold font-poppins text-xs">
                    Master Konfigurasi API
                </p>
                <h2 class="font-bold tracking-tighter text-2xl text-theme-text">
                    Konfigurasi API
                </h2>
            </div>
        </div>
        <div class="body-pages">
            <div class="border bg-white mt-8">
                <div class="pb-4 space-y-3 p-5">
                    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">{{ $data ? 'Ubah Konfigurasi' : 'Tambah Konfigurasi' }}</h2>
                </div>
                <form action="{{ route('dagulir.master.konfigurasi-api.store') }}" method="POST">
                    @csrf
                    <div class="p-5 space-y-5">
                        <div class="form-group-4">
                            <div class="input-box">
                                <label for="">HCS Host</label>
                                <textarea name="hcs_host" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->hcs_host : '' }}</textarea>
                            </div>
                            <div class="input-box">
                                <label for="">DWH Host</label>
                                <textarea name="dwh_host" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->dwh_host : '' }}</textarea>
                            </div>
                            <div class="input-box">
                                <label for="">DWH Store Kredit API URL</label>
                                <textarea name="dwh_store_kredit_api_url" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->dwh_store_kredit_api_url : '' }}</textarea>
                            </div>
                            <div class="input-box">
                                <label for="">DWH Token</label>
                                <textarea name="dwh_token" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->dwh_token : '' }}</textarea>
                            </div>
                            <div class="input-box">
                                <label for="">SIPDE Host</label>
                                <textarea name="sipde_host" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->sipde_host : '' }}</textarea>
                            </div>
                            <div class="input-box">
                                <label for="">SIPDE Username</label>
                                <textarea name="sipde_username" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->sipde_username : '' }}</textarea>
                            </div>
                            <div class="input-box">
                                <label for="">SIPDE Password</label>
                                <textarea name="sipde_password" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->sipde_password : '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $data ? $data->id : null }}">
                    <div class="flex justify-end items-end m-2">
                        <button type="submit"
                            class="px-7 py-2 rounded font-semibold bg-theme-primary border text-white mt-2">
                            <span class="mt-1 mr-3">
                                <iconify-icon icon="{{$data ? 'uil:edit' : 'ph:plus-bold'}}"></iconify-icon>
                            </span>
                            <span class="ml-1 text-sm"> {{ $data ? 'Simpan Perubahan' : 'Simpan' }} </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
