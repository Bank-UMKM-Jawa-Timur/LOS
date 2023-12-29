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
                {{-- <div class="pb-4 space-y-3 p-5">
                    <h2 class="text-4xl font-bold tracking-tighter text-theme-primary">{{ $data ? 'Ubah Konfigurasi' : 'Tambah Konfigurasi' }}</h2>
                </div> --}}
                <form action="{{ route('dagulir.master.konfigurasi-api.store') }}" method="POST">
                    @csrf
                    <div class="p-5 space-y-5">
                        <div class="form-group-1 col-span-2 pl-0">
                            <div>
                                <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                                        HCS :
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="input-box">
                                <label for="">HCS Host</label>
                                <input type="text"name="hcs_host" class="form-input" placeholder="Masukkan disini" value="{{ $data ? $data->hcs_host : 'https://bankumkm.id/hcs' }}">
                                {{-- <textarea name="hcs_host" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->hcs_host : '' }}</textarea> --}}
                            </div>
                        </div>
                        <div class="form-group-1 col-span-2 pl-0">
                            <div>
                                <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                                        DWH :
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-3">
                            <div class="input-box">
                                <label for="">DWH Host</label>
                                <input type="text"name="dwh_host" class="form-input" placeholder="Masukkan disini" value="{{ $data ? $data->dwh_host : 'http://127.0.0.1:8001' }}">
                            </div>
                            <div class="input-box">
                                <label for="">DWH Store Kredit API URL</label>
                                <input type="text"name="dwh_store_kredit_api_url" class="form-input" placeholder="Masukkan disini" value="{{ $data ? $data->dwh_store_kredit_api_url : '/api/v1/store-kredit' }}">
                            </div>
                            <div class="input-box">
                                <label for="">DWH Token</label>
                                <input type="text"name="dwh_token" class="form-input" placeholder="Masukkan disini" value="{{ $data ? $data->dwh_token : '$2y$10$uK7wv2xbmgOFAWOA./7nn.RMkuDfg4FKy64ad4h0AVqKxEpt0Co2u' }}">
                            </div>
                        </div>
                        <div class="form-group-1 col-span-2 pl-0">
                            <div>
                                <div class="w-full p-2 border-l-8 border-theme-primary bg-gray-100">
                                    <h2 class="font-semibold text-sm tracking-tighter text-theme-text">
                                        SIPDE :
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="form-group-2">
                            <div class="input-box">
                                <label for="">SIPDE Username</label>
                                <input type="text"name="sipde_username" class="form-input" placeholder="Masukkan disini" value="{{ $data ? $data->sipde_username : 'bankpusat_bpr' }}">
                            </div>
                            <div class="input-box">
                                <label for="">SIPDE Password</label>
                                <input type="text"name="sipde_password" class="form-input" placeholder="Masukkan disini" value="{{ $data ? $data->sipde_password : 'admin123' }}">
                                {{-- <textarea name="sipde_password" class="form-textarea" placeholder="Masukkan disini">{{ $data ? $data->sipde_password : '' }}</textarea> --}}
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $data ? $data->id : null }}">
                    <div class="flex justify-start items-end ml-4">
                        <button type="submit"
                            class="px-7 py-2 rounded font-semibold flex gap-3 bg-theme-primary border text-white mt-2">
                            <span class="">
                                <iconify-icon class="text-2xl " icon="{{$data ? 'uil:check-circle' : 'ph:plus-bold'}}"></iconify-icon>
                            </span>
                            <span class="ml-1 mt-1 text-sm"> {{ $data ? 'Simpan Perubahan' : 'Simpan' }} </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
