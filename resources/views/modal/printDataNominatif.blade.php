  <div class="modal fade" id="data_nominatif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">FIlter print Data nominatif</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="/print-data-nominatif" id="formhapus" method="POST">
                  @csrf
                  <div class="modal-body">
                      <div class="col-12">
                          <div class="row">

                              <div class="col-sm-6">
                                  <label>Tanggal Awal</label>
                                  <input type="date" name="tAwal" class="form-control" required>
                              </div>
                              <div class="col-sm-6">
                                  <label>Tanggal Akhir</label>
                                  <input type="date" name="tAkhir" class="form-control" required>
                              </div>
                              <div class="col-sm-12 ">
                                  <label>Cabang</label>
                                  <select name="cabang" id="inputGroupSelect01"
                                      class="custom-select select2 selectModal">
                                      <option value="semua" selected>Pilih Semua</option>
                                      @foreach ($cabangs as $c)
                                          <option value="{{ $c->id }}">{{ $c->cabang }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="col-sm-12">
                                  <label for="">Pilih Jenis Export</label>
                                  <select class="custom-select" name="export" id="" required>
                                      <option value="pdf">PDF</option>
                                      <option value="excel">EXCEL</option>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-inverse waves-effect waves-light"
                          data-dismiss="modal">Tutup</button>
                      <button type="submit" class="btn btn-danger">Print</button>
                  </div>
              </form>
          </div>
      </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          // Function to generate the PDF with or without filtering
          function generatePDF() {
              var tAwal = $("input[name='tAwal']").val();
              var tAkhir = $("input[name='tAkhir']").val();
              var pilihCabang = $("select[name='cabang']").val();

              // cek cabang di pilih atau
              if (pilihCabang) {
                  //   jika cabang tidak di pilih
                  window.location.href =
                      `/generate-pdf?tAwal=${tAwal}&tAkhir=${tAkhir}&cabang=${pilihCabang}`;
              } else {
                  // jika cabang tidak di pilih
                  window.location.href = `/generate-pdf?tAwal=${tAwal}&tAkhir=${tAkhir}&cabang=`;
              }
          }

          // Listen for the button click to generate the PDF
          $("#generatePDFButton").on('click', function() {
              generatePDF();
          });
      });
  </script>

  @push('extraScript')
      <script>
          $('#exportExcel').on('click', function() {
              $("#data_nominatif").modal('show');
              $('.SelectModal').select2({
                  dropdownParent: $("#data_nominatif")
              });
          })
      </script>
  @endpush
