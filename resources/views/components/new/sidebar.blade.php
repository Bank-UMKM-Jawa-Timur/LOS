<nav
    class="sidebar lg:relative z-40 lg:z-10 fixed lg:block hidden font-plus-jakarta-sans w-[250px] border bg-white h-screen">
    <div class="head-sidebar p-3 border-b">
        <img src="{{ asset('img/logo-nav.png') }}" alt="logo" class="w-[200px]" />
        <button class="absolute toggle-menu -right-7 lg:hidden block px-5 py-2 bg-white border rounded-full top-2">
            <iconify-icon icon="fa6-solid:angle-left" class="text-lg mt-2"></iconify-icon>
        </button>
    </div>
    <div class="menu mt-2 p-5 overflow-y-auto h-screen">
        <h2 class="font-semibold text-gray-400">Menu</h2>
        <div class="mt-5 text-sm text-theme-text">
            <ul class="space-y-3">
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}">
                        <button
                            class="item-link @active('dashboard', 'active-menu')  w-full flex gap-3 font-medium text-left px-4 py-3 rounded-md">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M13 9V3h8v6h-8ZM3 13V3h8v10H3Zm10 8V11h8v10h-8ZM3 21v-6h8v6H3Zm2-10h4V5H5v6Zm10 8h4v-6h-4v6Zm0-12h4V5h-4v2ZM5 19h4v-2H5v2Zm4-8Zm6-4Zm0 6Zm-6 4Z" />
                                </svg>
                            </span>
                            <span class="mt-[2px]"> Dashboard </span>
                        </button>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ url('pengajuan-kredit') }}">
                        <button class="item-link @active('pengajuan-kredit,pengajuan-kredit.*', 'active-menu')  w-full flex gap-2 font-medium text-left px-4 py-3 rounded-md">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path
                                            d="M2 12c0-3.771 0-5.657 1.172-6.828C4.343 4 6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172C22 6.343 22 8.229 22 12c0 3.771 0 5.657-1.172 6.828C19.657 20 17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172C2 17.657 2 15.771 2 12Z" />
                                        <path stroke-linecap="round" d="M10 16H6m8 0h-1.5M2 10h20" opacity=".5" />
                                    </g>
                                </svg>
                            </span>
                            <span class="ml-2 mt-[2px]"> Analisis kredit</span>
                        </button>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('dagulir.index') }}">
                        <button class="item-link @active('dagulir,dagulir.*', 'active-menu') w-full flex gap-2 font-medium text-left px-4 py-3 rounded-md">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 14c0-3.771 0-5.657 1.172-6.828C4.343 6 6.229 6 10 6h4c3.771 0 5.657 0 6.828 1.172C22 8.343 22 10.229 22 14c0 3.771 0 5.657-1.172 6.828C19.657 22 17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.172C2 19.657 2 17.771 2 14Zm14-8c0-1.886 0-2.828-.586-3.414C14.828 2 13.886 2 12 2c-1.886 0-2.828 0-3.414.586C8 3.172 8 4.114 8 6"/><path stroke-linecap="round" d="M12 17.333c1.105 0 2-.746 2-1.666c0-.92-.895-1.667-2-1.667s-2-.746-2-1.667c0-.92.895-1.666 2-1.666m0 6.666c-1.105 0-2-.746-2-1.666m2 1.666V18m0-8v.667m0 0c1.105 0 2 .746 2 1.666"/></g></svg>
                            </span>
                            <span class="ml-2 mt-[2px]"> Dagulir</span>
                        </button>
                    </a>
                </li>
                @if (auth()->user()->role == 'Administrator')
                <li class="menu-item">
                    <a href="#" class="toggle-dp-menu">
                        <button class="item-link relative w-full flex gap-2 font-medium text-left px-4 py-3 rounded-md">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5">
                                        <path
                                            d="m15.578 3.382l2 1.05c2.151 1.129 3.227 1.693 3.825 2.708C22 8.154 22 9.417 22 11.94v.117c0 2.525 0 3.788-.597 4.802c-.598 1.015-1.674 1.58-3.825 2.709l-2 1.049C13.822 21.539 12.944 22 12 22s-1.822-.46-3.578-1.382l-2-1.05c-2.151-1.129-3.227-1.693-3.825-2.708C2 15.846 2 14.583 2 12.06v-.117c0-2.525 0-3.788.597-4.802c.598-1.015 1.674-1.58 3.825-2.708l2-1.05C10.178 2.461 11.056 2 12 2s1.822.46 3.578 1.382Z" />
                                        <path
                                            d="m21 7.5l-4 2M12 12L3 7.5m9 4.5v9.5m0-9.5l4.5-2.25l.5-.25m0 0V13m0-3.5l-9.5-5"
                                            opacity=".5" />
                                    </g>
                                </svg>
                            </span>
                            <span class="ml-2 mt-[2px]"> Data Master </span>
                            <span class="absolute right-6">
                                <iconify-icon icon="uil:angle-down" class="text-2xl"></iconify-icon>
                            </span>
                        </button>
                    </a>
                </li>
                <div class="dropdown-menu-link hidden">
                    <ul class="space-y-1 p-2 mt-3 bg-gray-50">
                        <li>
                            <a href="master-cabang.html">
                                <button class="item-dp-link">
                                    Master kantor cabang
                                </button>
                            </a>
                        </li>
                        <li>
                            <a href="master-kabupaten.html">
                                <button class="item-dp-link">Master Kabupaten</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-kecamatan.html">
                                <button class="item-dp-link">Master Kecamatan</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-desa.html">
                                <button class="item-dp-link">Master Desa</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-user.html">
                                <button class="item-dp-link">Master User</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-item.html">
                                <button class="item-dp-link">Master Item</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-merk.html">
                                <button class="item-dp-link">Master Merk</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-tipe.html">
                                <button class="item-dp-link">Master Tipe</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-session.html">
                                <button class="item-dp-link">Master Session</button>
                            </a>
                        </li>
                        <li>
                            <a href="master-api-session.html">
                                <button class="item-dp-link">Master API Session</button>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </ul>
        </div>
    </div>
    <!-- end menu -->
</nav>
