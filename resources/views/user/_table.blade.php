<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Kantor Cabang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $page = Request::get('page');
                $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
            @endphp
            @foreach ($user as $item)
                <tr class="border-bottom-primary">
                    <td class="text-center text-muted">{{ $no }}</td>
                    <td>{{ $item->nip ?? '-' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->role }}</td>
                    <td>{{ $item->cabang->cabang }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="btn-group">
                                <button type="button" data-toggle="dropdown" class="btn btn-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16"
                                        style="color: black">
                                        <path
                                            d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                    </svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('user.edit', $item->id) }}" class="dropdown-item">
                                        Edit
                                    </a>
                                    @if (auth()->user()->id != $item->id)
                                        <form action="{{ route('user.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="dropdown-item"
                                                onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                    <button class="dropdown-item" onclick="resetPassword('{{ $item->name }}')">Reset
                                        Password</button>
                                    <form action="{{ route('reset-password', $item->id) }}" id="resetPasswordForm"
                                        method="post">
                                        @csrf
                                        {{-- <button class="dropdown-item"
                                        onclick="confirm('{{ __('Apakah anda yakin mereset password?') }}') ? this.parentElement.submit() : ''">Reset Password</button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $user->appends(Request::all())->links('vendor.pagination.custom') }}
    </div>
</div>
@push('custom-script')
    <script>
        function resetPassword(name) {
            Swal.fire({
                title: 'Perhatian!!',
                text: "Apakah anda yakin mereset password " + name + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#112042',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'ResetPassword',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#resetPasswordForm").submit()
                }
            })
        }
    </script>
@endpush
