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
        <div class="container max-w-2xl mx-auto mt-[5vh] lg:p-0 p-10">
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
                    <div class="p-2">
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled text-white"></i>
                            </button>
                            <strong><span class="fa fa-exclamation-triangle"></span> Gagal login.</strong> {{session('error')}}
                        </div>
                      </div>
                    @endif
                    @if ($errors->any())
                    <div class="p-2">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="icofont icofont-close-line-circled text-white"></i>
                        </button>
                        @foreach ($errors->all() as $error)
                        <strong><span class="fa fa-exclamation-triangle"></span> Gagal login.</strong> {{$error}}
                        @endforeach
                    </div>
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
                          class=" focus:ring-0 ring-offset-transparent border-2 rounded-md bg-gray-50 focus-within:bg-gray-100 flex"
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
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="off"
                            class="w-full p-2 bg-gray-50 font-medium text-sm rounded-md focus:bg-gray-100 outline-none"
                          />
                          <small class="alert-message text-red-500 hidden">Isi email atau NIP terlebih dahulu.</small>
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
                          class="focus:ring-0 ring-offset-transparent  border-2 rounded-md bg-gray-50 focus-within:bg-gray-100 flex gap-2"
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
                            id="password"
                            value="{{ old('password') }}"
                            class="w-full p-2 bg-gray-50 text-sm rounded-md font-medium focus:bg-gray-100 outline-none"
                          />
                          <small class="alert-message text-red-500 hidden">Isi password terlebih dahulu.</small>
                        </div>
                      </div>
                      <button
                        type="submit"
                        id="login-button"
                        class="bg-theme-primary hover:bg-red-700 py-5 rounded-md font-semibold tracking-tighter text-white w-full"
                      >
                        Masuk
                      </button>
                    </div>
                  </h2>
                </div>
              </div>
              <div class="copyright text-center font-semibold text-white">
                Copyright 2022 - {{ date('Y') }} PT. BPR Jatim
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
  {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
  <script>

  $("#login").on('submit', function(e){
    isLoading();
  });

  $("#login-button").on("click", function (e) {
    isLoading();
  });

  function isLoading() {
    $('#login-button').addClass('cursor-not-allowed');
      $('#login-button').html(`
          <span class="inline-flex items-center">
              <svg aria-hidden="true" role="status" class="inline w-5 h-5 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                  <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
              </svg>
              Logging in...
          </span>
      `);
  }
  </script>
</html>
