<header
class="sticky top-0 border-b z-30 p-3 font-poppins w-full bg-white"
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
    <div
      class="dropdown-account account-info mr-3 cursor-pointer flex gap-5"
    >
      <div class="avatar text-center">
        <img
          src="{{ asset('img/avatar.png') }}"
          alt=""
          class="w-10 h-10 rounded-full"
        />
      </div>
      <div class="content lg:block hidden">
        <h2
          class="font-poppins font-semibold tracking-tighter text-sm"
        >
          Arsyad Arthan N.
        </h2>
        <p
          class="font-poppins font-semibold text-xs text-gray-400 tracking-tighter"
        >
          administrator
        </p>
      </div>
    </div>
    <div class="dropdown-account-menu hidden">
      <ul class="">
        <li>
          <a href="#">
            <button class="item-dropdown">Profile</button>
          </a>
        </li>
        <li>
          <a href="#">
            <button class="item-dropdown">Reset Password</button>
          </a>
        </li>
        <li>
          <a href="#">
            <button class="item-dropdown border-t flex gap-3">
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