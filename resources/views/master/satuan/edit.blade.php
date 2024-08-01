@foreach ($satuan as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->nama }}</td>
        <td>{{ $s->keterangan }}</td>

        <td>
            <a href="{{ route('master.satuan.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>
            {{-- <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#UpModal{{$s->id}}">
                        Edit
                </button> --}}
            <form action="/master/satuan/{{ $s->id }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </td>

        <!-- Modal update -->
        <div id="UpModal{{ $s->id }}" class="modal fade" tabindex="-1"
            aria-labelledby="myModalLabel{{ $s->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel{{ $s->id }}">Perbarui Data Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/master/satuan/{{ $s->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nama{{ $s->id }}" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama{{ $s->id }}" name="nama"
                                    placeholder="Enter Name" value="{{ $s->nama }}">
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="keterangan{{ $s->id }}" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan{{ $s->id }}"
                                        name="keterangan" placeholder="Enter Information" value="{{ $s->keterangan }}">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" name="proses">Simpan
                            Data</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </tr>
@endforeach
