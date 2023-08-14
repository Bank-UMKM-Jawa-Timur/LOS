<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Email</th>
                <th>Role</th>
                <th>Cabang</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $page = Request::get('page');
                $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
            @endphp
            @foreach ($data as $item)
                @php
                    $cabang = '-';
                    if ($item->id_cabang) {
                        $dataCabang = DB::table('cabang')
                            ->where('id', $item->id_cabang)
                            ->first();
                        $cabang = $dataCabang->cabang;
                    }
                @endphp
                <tr class="border-bottom-primary">
                    <td class="text-center text-muted">{{ $no }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->role }}</td>
                    <td>{{ $cabang }}</td>
                    <td><h5 class="badge badge-info">Aktif</h5></td>
                    <td>
                        @if (auth()->user()->id != $item->tokenable_id)
                            <form action="{{ route('reset-api-session', $item->id) }}" method="post">
                                @csrf
                                <button class="btn btn-danger" onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">Reset</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $data->appends(Request::all())->links('vendor.pagination.custom') }}
    </div>
</div>
