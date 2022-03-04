<div class="table-responsive">
  <table class="table table-hover table-custom">
      <thead>
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Desa</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th></th>
            </tr>
        </thead>
      </thead>
      <tbody>
          @php
              $page = Request::get('page');
              $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
          @endphp
          @foreach ($desa as $item)
              <tr class="border-bottom-primary">
                <td class="text-center text-muted">{{ $no }}</td>
                    <td>{{ $item->desa }}</td>
                    <td>{{ $item->kecamatan->kecamatan }}</td>
                    <td>{{ $item->kabupaten->kabupaten }}</td>
                <td>
                    <div class="form-inline btn-action">
                        <a href="{{ route('desa.edit', $item->id) }}" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm"
                                data-toggle="tooltip" title="Edit" data-placement="top"><span
                                    class="fa fa-edit fa-sm"></span></button>
                        </a>
                        <form action="{{ route('desa.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="button" class="btn btn-rgb-danger btn-sm" data-toggle="tooltip"
                                title="Hapus" data-placement="top"
                                onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                <span class="fa fa-trash fa-sm"></span>
                            </button>
                        </form>
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
    {{$desa->appends(Request::all())->links('vendor.pagination.custom')}}
  </div>
</div>