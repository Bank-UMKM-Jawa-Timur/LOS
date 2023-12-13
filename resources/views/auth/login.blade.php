<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    />
    <title>Login - Pincetar</title>
    <link
      rel="preconnect"
      href="https://fonts.googleapis.com"
    />
    <link
      rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="{{asset('css/app.css')}}"
    />
  </head>
  <body>
    <section
    style="background-image: url('{{ asset('img/background.jpg')}} ')"
      class="w-full font-poppins h-screen  bg-center bg-cover"
    >
      <div class="overlay bg-theme-secondary/90 w-full h-screen">
        <br />
        <div class="container max-w-2xl mx-auto mt-20 lg:p-0 p-10">
          <form
            method="post" id="login" action="{{ route('login') }}"
          >
            @csrf
            <div class="form-wrapping space-y-12">
              <div class="flex justify-center">
                <img
                  src="{{asset('img/logo.svg')}}"
                  alt="logo bank umkm"
                  class=""
                />
              </div>
              <div class="bg-white w-full p-8 rounded-[10px]">
                <div class="head text-center">
                  <h2
                    class="font-semibold text-theme-secondary tracking-tighter text-xl"
                  >
                    Login Pincetar
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            <strong><span class="fa fa-exclamation-triangle"></span> Gagal login.</strong> {{session('error')}}
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="icofont icofont-close-line-circled text-white"></i>
                        </button>
                        <strong><span class="fa fa-exclamation-triangle"></span> Gagal login.</strong> {{$errors}}
                    </div>
                    @endif
                    <div class="mt-5 space-y-5 text-left">
                      <div class="input-box space-y-4">
                        <label
                          for="emailnip"
                          class="block tracking-tighter text-lg text-gray-500 font-semibold"
                        >
                          Email atau NIP
                        </label>
                        <div
                          class="form-input focus:ring-0 ring-offset-transparent border-2 rounded-md bg-gray-50 focus-within:bg-gray-100 flex"
                        >
                          <!-- icon -->
                          <div class="text-center ml-0 mt-0 p-2 text-gray-400">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="w-8"
                              viewBox="0 0 24 24"
                            >
                              <path
                                fill="currentColor"
                                d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5l-8-5h16zm0 12H4V8l8 5l8-5v10z"
                              />
                            </svg>
                          </div>
                          <input
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="off"
                            class="w-full p-2 bg-gray-50 font-medium rounded-md focus:bg-gray-100 outline-none"
                          />
                        </div>
                      </div>
                      <div class="input-box space-y-4">
                        <label
                          for="password"
                          class="block tracking-tighter text-lg text-gray-500 font-semibold"
                        >
                          Password
                        </label>
                        <div
                          class="form-input focus:ring-0 ring-offset-transparent  border-2 rounded-md bg-gray-50 focus-within:bg-gray-100 flex gap-2"
                        >
                          <!-- icon -->
                          <div class="text-center ml-0 mt-0 p-2 text-gray-400">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="w-8"
                              viewBox="0 0 24 24"
                            >
                              <path
                                fill="currentColor"
                                d="M6 22q-.825 0-1.413-.588T4 20V10q0-.825.588-1.413T6 8h1V6q0-2.075 1.463-3.538T12 1q2.075 0 3.538 1.463T17 6v2h1q.825 0 1.413.588T20 10v10q0 .825-.588 1.413T18 22H6Zm0-2h12V10H6v10Zm6-3q.825 0 1.413-.588T14 15q0-.825-.588-1.413T12 13q-.825 0-1.413.588T10 15q0 .825.588 1.413T12 17ZM9 8h6V6q0-1.25-.875-2.125T12 3q-1.25 0-2.125.875T9 6v2ZM6 20V10v10Z"
                              />
                            </svg>
                          </div>
                          <input
                            type="password"
                            autocomplete="off"
                            name="password"
                            value="{{ old('password') }}"
                            class="w-full p-2 bg-gray-50 rounded-md font-medium focus:bg-gray-100 outline-none"
                          />
                          <div class="text-center mr-2 mt-0 p-2 text-gray-400">
                            <svg
                              xmlns="http://www.w3.org/2000/svg"
                              class="w-8"
                              viewBox="0 0 256 256"
                            >
                              <path
                                fill="currentColor"
                                d="M53.92 34.62a8 8 0 1 0-11.84 10.76l19.24 21.17C25 88.84 9.38 123.2 8.69 124.76a8 8 0 0 0 0 6.5c.35.79 8.82 19.57 27.65 38.4C61.43 194.74 93.12 208 128 208a127.11 127.11 0 0 0 52.07-10.83l22 24.21a8 8 0 1 0 11.84-10.76Zm47.33 75.84l41.67 45.85a32 32 0 0 1-41.67-45.85ZM128 192c-30.78 0-57.67-11.19-79.93-33.25A133.16 133.16 0 0 1 25 128c4.69-8.79 19.66-33.39 47.35-49.38l18 19.75a48 48 0 0 0 63.66 70l14.73 16.2A112 112 0 0 1 128 192Zm6-95.43a8 8 0 0 1 3-15.72a48.16 48.16 0 0 1 38.77 42.64a8 8 0 0 1-7.22 8.71a6.39 6.39 0 0 1-.75 0a8 8 0 0 1-8-7.26A32.09 32.09 0 0 0 134 96.57Zm113.28 34.69c-.42.94-10.55 23.37-33.36 43.8a8 8 0 1 1-10.67-11.92a132.77 132.77 0 0 0 27.8-35.14a133.15 133.15 0 0 0-23.12-30.77C185.67 75.19 158.78 64 128 64a118.37 118.37 0 0 0-19.36 1.57A8 8 0 1 1 106 49.79A134 134 0 0 1 128 48c34.88 0 66.57 13.26 91.66 38.35c18.83 18.83 27.3 37.62 27.65 38.41a8 8 0 0 1 0 6.5Z"
                              />
                            </svg>
                          </div>
                        </div>
                      </div>
                      <button
                        type="submit"
                        class="bg-theme-primary py-5 rounded-md font-semibold tracking-tighter text-white w-full"
                      >
                        Masuk
                      </button>
                    </div>
                  </h2>
                </div>
              </div>
              <div class="copyright text-center font-semibold text-white">
                Copyright 2022 PT. BPR Jatim
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</html>
