
<header
class="sticky top-0 border-b z-50 p-3 font-poppins w-full bg-white"
>
<div class="flex justify-between items-center flex-wrap">
  <div>
    <button class="lg:hidden block toggle-menu">
      <iconify-icon
        icon="radix-icons:hamburger-menu"
        class="text-2xl ml-3 mt-1"
      ></iconify-icon>
    </button>
  </div>
  <div class="flex">
    <div>
      <button class="fullscreen">
        <iconify-icon
          icon="ic:round-fullscreen"
          class="text-2xl text-gray-500 mr-5 mt-[8px]"
        ></iconify-icon>
      </button>
    </div>
    <button class="toggle-notification">
      @if (count($notification) > 0)
          <span class="p-2 absolute -mt-1 rounded-full bg-theme-primary"></span>
      @endif
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 36 36">
          <path fill="currentColor"
              d="M32.51 27.83A14.4 14.4 0 0 1 30 24.9a12.63 12.63 0 0 1-1.35-4.81v-4.94A10.81 10.81 0 0 0 19.21 4.4V3.11a1.33 1.33 0 1 0-2.67 0v1.31a10.81 10.81 0 0 0-9.33 10.73v4.94a12.63 12.63 0 0 1-1.35 4.81a14.4 14.4 0 0 1-2.47 2.93a1 1 0 0 0-.34.75v1.36a1 1 0 0 0 1 1h27.8a1 1 0 0 0 1-1v-1.36a1 1 0 0 0-.34-.75ZM5.13 28.94a16.17 16.17 0 0 0 2.44-3a14.24 14.24 0 0 0 1.65-5.85v-4.94a8.74 8.74 0 1 1 17.47 0v4.94a14.24 14.24 0 0 0 1.65 5.85a16.17 16.17 0 0 0 2.44 3Z"
              class="clr-i-outline clr-i-outline-path-1" />
          <path fill="currentColor" d="M18 34.28A2.67 2.67 0 0 0 20.58 32h-5.26A2.67 2.67 0 0 0 18 34.28Z"
              class="clr-i-outline clr-i-outline-path-2" />
          <path fill="none" d="M0 0h36v36H0z" />
      </svg>
  </button>
  <div class="notification-list hidden border lg:w-96 w-80 bg-white absolute top-10 lg:right-20 right-0">
      <div class="head border-b w-full text-center p-3">
          Notification
          <span class="ml-3 py-1.5 px-3 text-white rounded-full bg-theme-primary">
              {{count($notification)}}</span>
      </div>
      @forelse ($notification as $item)
          <div class="notif-list grid grid-cols-1 bg-white">
              <button class="w-full text-left border-b p-3">
                  <p class="text-xs text-theme-primary">{{$item->read ? 'Sudah dibaca' : 'Belum dibaca'}}</p>
                  <p class="font-bold">{{$item->title}}</p>
                  <p class="text-xs text-theme-text">{{ date('Y-m-d H:i', strtotime($item->created_at)) }}</p>
              </button>
          </div>
      @empty
          <div class="p-4 border-b">
              <p>Belum ada notifikasi.</p>
          </div>
      @endforelse
      <div class="footer-notif text-center p-3">
          <button>Lihat semua</button>
      </div>
  </div>
    <div
      class="dropdown-account account-info mr-3 cursor-pointer flex gap-5"
    >
    @php
      $name_karyawan = App\Http\Controllers\DashboardController::getKaryawan();
    @endphp
      <div class="avatar text-center">
        <img
          src="https://ui-avatars.com/api/?background=dc3545&name={{ $name_karyawan ? $name_karyawan : auth()->user()->name }}&bold=true&length=2&color=fff"
          alt=""
          class="w-10 h-10 rounded-full"
        />
      </div>
      <div class="content lg:block hidden">
        <h2
          class="font-poppins font-semibold tracking-tighter text-sm"
        >
      
          @if (auth()->user()->nip)
            {{ $name_karyawan ? $name_karyawan : auth()->user()->name }}
          @else
            {{auth()->user()->name}}
          @endif
        </h2>
        <p
          class="font-poppins font-semibold text-xs text-gray-400 tracking-tighter"
        >
          {{auth()->user()->role}}
        </p>
      </div>
    </div>
    <div class="dropdown-account-menu hidden">
      <ul class="">
        <li>
          <a href="{{ route('change_password') }}">
            <button class="item-dropdown">Ganti Password</button>
          </a>
        </li>
        <li>
          <a href="#">
            <button  data-modal-id="modal-logout" class="open-modal item-dropdown border-t flex gap-3">
              <span class="mt-[2px]"
                ><iconify-icon icon="tabler:logout"></iconify-icon
              ></span>
              <span>Logout</span>
            </button>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
</header>
