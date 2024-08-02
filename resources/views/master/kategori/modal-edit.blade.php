<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Perbarui Data Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="/master/kategori/" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Kategori" value="">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" value="">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" name="proses">Simpan
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    $('body').on('click', 'btn-edit', function() {

        let id = $(this).data('id');

        $.ajax({
            url: `/master/kategori/${id}`,
            method: 'GET',
            success: function(data) {
                $('nama').val(data.nama);
                $('keterangan').val(data.keterangan);
            },
        })
    })

</script>