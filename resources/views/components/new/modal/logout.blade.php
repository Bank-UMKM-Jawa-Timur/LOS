<div class="modal-layout hidden" id="modal-logout">
  <div class="modal modal-sm bg-white">
      <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <div class="modal-head">
              <div class="title">
                  <h2 class="font-bold text-2xl tracking-tighter text-theme-text">
                      Logout
                  </h2>
              </div>
              <button type="button" data-dismiss-id="modal-logout">
                  <iconify-icon icon="iconamoon:close-bold" class="text-2xl"></iconify-icon>
              </button>
          </div>
          <div class="modal-body space-y-5">
              <div class="space-y-3">
                  <p>Anda yakin akan keluar?</p>
              </div>
          </div>
          <div class="modal-footer justify-end">
              <button class="btn-cancel" type="button" data-dismiss-id="modal-logout">
                  Batal
              </button>
              <button type="submit" class="btn-submit">Logout</button>
          </div>
      </form>
  </div>
</div>
