<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Nama Merk Kendaraan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $page = Request::get('page');
                $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                @endphp
            @foreach ($dataMerk as $item)
                <tr class="border-bottom-primary">
                    <td class="text-center text-muted">{{ $no }}</td>
                    <td>
                        {{ $item->merk }}
                    </td>
                    <td>
                        <div class="form-inline btn-action">
                            <a href="{{ route('merk.edit', $item->id) }}" class="mr-2">
                                <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm" data-toggle="tooltip" title="Edit" data-placement="top">
                                    <span class="fa fa-edit fa-sm"></span>
                                </button>
                            </a>
                            <form action="{{ route('merk.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-rgb-danger btn-sm" data-toggle="tooltip"  title="Hapus" data-placement="top" onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                    <span class="fa fa-trash fa-sm"></span>
                                </button>
                            </form>
                        </div>
                    </td>
                    @php
                        $no++;
                    @endphp
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $dataMerk->appends(Request::all())->links('vendor.pagination.custom') }}
    </div>
</div>