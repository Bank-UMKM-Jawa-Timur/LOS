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
                        @if (auth()->user()->id != $item->user_id)
                            <form action="{{ route('reset-session', $item->user_id) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmResetSession{{ $item->user_id }}">
                                    Reset
                                </button>
                                <div class="modal fade" id="confirmResetSession{{ $item->user_id }}" tabindex="-1" role="dialog" aria-labelledby="confirmResetSessionLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin akan mereset sesi ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" id="btn-hapus" class="btn btn-danger">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
