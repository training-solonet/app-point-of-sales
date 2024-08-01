 @foreach ($customer as $c)
     <tr>
         <td>{{ $loop->iteration }}</td>
         <td>{{ $c->nama }}</td>
         <td>{{ $c->alamat }}</td>
         <td>{{ $c->no_hp }}</td>
         <td>
             <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                 data-bs-target="#UpModal{{ $c->id }}">
                 Edit
             </button>

             <form action="/master/customer/{{ $c->id }}" method="POST" style="display:inline;">
                 @csrf
                 @method('DELETE')
                 <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
             </form>
         </td>
     </tr>

     <!-- Modal update -->
     <div id="UpModal{{ $c->id }}" class="modal fade" tabindex="-1"
         aria-labelledby="myModalLabel{{ $c->id }}" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="myModalLabel{{ $c->id }}">Perbarui Data Customer</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form action="/master/customer/{{ $c->id }}" method="POST">
                         @csrf
                         @method('PUT')

                         <div class="mb-3">
                             <label for="nama{{ $c->id }}" class="form-label">Nama</label>
                             <input type="text" class="form-control" id="nama{{ $c->id }}" name="nama"
                                 placeholder="Enter Your Name" value="{{ $c->nama }}">
                         </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="alamat{{ $c->id }}" class="form-label">Alamat</label>
                                     <input type="text" class="form-control" id="alamat{{ $c->id }}"
                                         name="alamat" placeholder="Enter Your Address" value="{{ $c->alamat }}">
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="number{{ $c->id }}" class="form-label">No HP</label>
                                     <input type="number" class="form-control" id="number{{ $c->id }}"
                                         name="no_hp" placeholder="Enter Your Number" value="{{ $c->no_hp }}">
                                 </div>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button type="button" class="btn btn-secondary waves-effect"
                                 data-bs-dismiss="modal">Tutup</button>
                             <button type="submit" class="btn btn-primary waves-effect waves-light"
                                 name="proses">Simpan Data</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 @endforeach
