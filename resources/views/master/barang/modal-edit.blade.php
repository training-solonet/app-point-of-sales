<div id="UpModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" name="barangForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode</label>
                        <input type="hidden" class="form-control" id="kode" name="kode" placeholder="Masukkan kode barang">
                    </div>
                    <div class="mb-3">
                        <label for="part_number" class="form-label">Part Number</label>
                        <input type="text" class="form-control" id="part_number" name="part_number" placeholder="Masukkan part number barang">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan part number barang">
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-select" id="satuan" name="id_satuan" required>
                            <option disabled>Pilih Satuan</option>
                            <option value="1">BOX</option>
                            <option value="2">KEPING</option>
                            <option value="3">METER</option>
                            <option value="4">PACK</option>
                            <option value="5">PAKET</option>
                            <option value="6">PCS</option>
                            <option value="7">ROLL</option>
                            <option value="8">SET</option>
                            <option value="9">UNIT</option>
                            <option value="10">HASPEL</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="id_kategori" required>
                            <option disabled>Pilih Kategori</option>
                            <option value="1">Alat Jaringan</option>
                            <option value="2">Asesoris</option>
                            <option value="3">CCTV</option>
                            <option value="4">Komputer</option>
                            <option value="5">Peripheral</option>
                            <option value="6">Photography</option>
                            <option value="7">Lain-lain</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stok" class="form-label">stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan jumlah stok">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light" id="update-simpan" name="proses">Simpan
                    Data</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '.btn-edit', function() {
        let barang_id = $(this).data('id');

        $.ajax({
            url: `/barang/${barang_id}`,
            type: 'GET',
            cache: false,
            success: function(response) {
                console.log(response); // Log the response to check the data
                if (response.success) {
                    $('#kode').val(response.data.kode);
                    $('#part_number').val(response.data.part_number);
                    $('#nama').val(response.data.nama);
                    $('#satuan').val(response.data.id_satuan);
                    $('#kategori').val(response.data.id_kategori);
                    $('#stok').val(response.data.stok);

                    $('#UpModal').modal('show');
                } else {
                    alert('Barang not found');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error fetching data');
            }
        });
    });

    $('#update-simpan').click(function(e) {
        e.preventDefault();

        let kode = $('#kode').val();
        let part_number = $('#part_number').val();
        let nama = $('#nama').val();
        let satuan = $('#satuan').val();
        let kategori = $('#kategori').val();
        let stok = $('#stok').val();
        let _token = $('input[name="_token"]').val();

        $.ajax({
            url: `/barang/${kode}`,
            type: 'PUT',
            data: {
                _token: _token,
                kode: kode,
                part_number: part_number,
                nama: nama,
                id_satuan: satuan,
                id_kategori: kategori,
                stok: stok
            },
            cache: false,
            success: function(response) {
                if (response.success) {
                    $('#UpModal').modal('hide');
                    alert('Data berhasil diupdate');
                    location.reload();
                } else {
                    alert('Error updating data');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error updating data');
            }
        });
    });
</script>