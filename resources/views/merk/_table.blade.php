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
            <tr class="border-bottom-primary">
                <td class="text-center text-muted">1</td>
                <td>Honda</td>
                <td>
                    <div class="form-inline btn-action">
                        <a href="z" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm" data-toggle="tooltip" title="Edit" data-placement="top">
                                <span class="fa fa-edit fa-sm"></span>
                            </button>
                        </a>
                        <form action="" method="POST">
                            <button type="button" class="btn btn-rgb-danger btn-sm" data-toggle="tooltip"  title="Hapus" data-placement="top" onclick="confirm('{{ __('Apakah anda yakin ingin menghapus?') }}') ? this.parentElement.submit() : ''">
                                <span class="fa fa-trash fa-sm"></span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="pull-right">
        // pagination here
    </div>
</div>