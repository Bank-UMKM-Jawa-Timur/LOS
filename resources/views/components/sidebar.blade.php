        <!-- sidebar -->
        <nav
          class="sidebar lg:relative z-40 lg:z-10 fixed lg:block hidden font-plus-jakarta-sans w-[100px] border bg-white h-screen"
        >
          <div class="head-sidebar p-3 border-b">
            <img
              src="{{ asset('img/favicon.png') }}"
              alt="logo"
              class="w-[40px] mx-auto"
            />
            <button
              class="absolute toggle-menu -right-7 lg:hidden block px-5 py-2 bg-white border rounded-full top-2"
            >
              <iconify-icon
                icon="fa6-solid:angle-left"
                class="text-lg mt-2"
              ></iconify-icon>
            </button>
          </div>
          <div class="menu mt-2 p-5 overflow-y-auto h-screen">
            <h2 class="font-semibold text-gray-400">Menu</h2>
            <div class="mt-5 text-sm text-theme-text">
              <ul class="space-y-3">
                <li class="menu-item">
                  <a href="{{ url('/dashboard') }}"">
                    <button
                      class="item-link active-menu w-full flex gap-3 font-medium text-left px-4 py-3 rounded-md"
                    >
                      <span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                        >
                          <path
                            fill="currentColor"
                            d="M13 9V3h8v6h-8ZM3 13V3h8v10H3Zm10 8V11h8v10h-8ZM3 21v-6h8v6H3Zm2-10h4V5H5v6Zm10 8h4v-6h-4v6Zm0-12h4V5h-4v2ZM5 19h4v-2H5v2Zm4-8Zm6-4Zm0 6Zm-6 4Z"
                          />
                        </svg>
                      </span>
                    </button>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="{{ url('pengajuan-kredit') }}">
                    <button
                      class="item-link w-full flex gap-2 font-medium text-left px-4 py-3 rounded-md"
                    >
                      <span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                        >
                          <g
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                          >
                            <path
                              d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12c0 3.771 0 5.657-1.172 6.828C19.657 20 17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172C2 17.657 2 15.771 2 12Z"
                            />
                            <path
                              stroke-linecap="round"
                              d="M10 16H6m8 0h-1.5M2 10h20"
                              opacity=".5"
                            />
                          </g>
                        </svg>
                      </span>

                    </button>
                  </a>
                </li>
                <li class="menu-item">
                  <a
                    href="#"
                    class="toggle-dp-menu"
                  >
                    <button
                      class="item-link relative w-full flex gap-2 font-medium text-left px-4 py-3 rounded-md"
                    >
                      <span>
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                        >
                          <g
                            fill="none"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-width="1.5"
                          >
                            <path
                              d="m15.578 3.382l2 1.05c2.151 1.129 3.227 1.693 3.825 2.708C22 8.154 22 9.417 22 11.94v.117c0 2.525 0 3.788-.597 4.802c-.598 1.015-1.674 1.58-3.825 2.709l-2 1.049C13.822 21.539 12.944 22 12 22s-1.822-.46-3.578-1.382l-2-1.05c-2.151-1.129-3.227-1.693-3.825-2.708C2 15.846 2 14.583 2 12.06v-.117c0-2.525 0-3.788.597-4.802c.598-1.015 1.674-1.58 3.825-2.708l2-1.05C10.178 2.461 11.056 2 12 2s1.822.46 3.578 1.382Z"
                            />
                            <path
                              d="m21 7.5l-4 2M12 12L3 7.5m9 4.5v9.5m0-9.5l4.5-2.25l.5-.25m0 0V13m0-3.5l-9.5-5"
                              opacity=".5"
                            />
                          </g>
                        </svg>
                      </span>
                    </button>
                  </a>
                </li>
                <div class="dropdown-menu-link hidden absolute z-40 w-[240px]">
                  <ul class="space-y-1 p-2 mt-3 bg-gray-50">
                    <li>
                      <a href="{{ route('cabang.index') }}"">
                        <button class="item-dp-link">
                          Master kantor cabang
                        </button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('kabupaten.index') }}">
                        <button class="item-dp-link">Master Kabupaten</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('kecamatan.index') }}">
                        <button class="item-dp-link">Master Kecamatan</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('desa.index') }}">
                        <button class="item-dp-link">Master Desa</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('user.index') }}">
                        <button class="item-dp-link">Master User</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('master-item.index') }}">
                        <button class="item-dp-link">Master Item</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('merk.index') }}l">
                        <button class="item-dp-link">Master Merk</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('tipe.index') }}l">
                        <button class="item-dp-link">Master Tipe</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('index-session') }}">
                        <button class="item-dp-link">Master Session</button>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('index-api-session') }}">
                        <button class="item-dp-link">Master API Session</button>
                      </a>
                    </li>
                  </ul>
                </div>
              </ul>
            </div>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
            <ul class="absolute bottom-5">
              <li class="menu-item">
                <a
                href="{{route('logout')}}"
                onclick="event.preventDefault();
                        this.closest('form').submit();"
                >
                  <button
                    class="item-link relative   w-full flex gap-2 font-medium text-left px-4 py-3 rounded-md"
                  >
                    <span>
                      <iconify-icon icon="solar:logout-outline" class="text-2xl mt-1"></iconify-icon>
                    </span>
                  </button>
                </a>
              </li>
            </ul>
            </form>
          </div>
          <!-- end menu -->
        </nav>
        <!-- end sidebar -->