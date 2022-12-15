@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tabel Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
      <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transaksi Panding</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Total</th>
                      <th>Bank</th>
                      <th>Status</th>
                      <th style="width: 140px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($listPending as $data)
                    <tr>
                      <td>{{$data->id}}</td>
                      <td>{{$data->nama}}</td>
                      <td>{{"Rp.".number_format($data->total_transfer)}}</td>
                      <td>{{$data->bank}}</td>
                      <td>{{$data->status}}</td>
                      <td>
                      <td>
                          <a href="{{ route('transaksiBatal', $data->id) }}">
                            <button type="button" class="btn btn btn-danger  btn-xs">Batal</button></a>
                            /
                            <a href="{{ route('transaksiConfirm', $data->id) }}">
                            <button type="button" class="btn btn btn-success btn-xs">Proses</button></a>

                          </td>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            
            <br>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form method="POST" action="{{ route('produk.store') }}" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama" name="name">
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" placeholder="Harga ..." name="harga">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Pilih C
                          Kategory</label>
                        <select class="form-control" name="kategori_id">
                          <option value="1">option 1</option>
                          <option value="1">option 2</option>
                          <option value="1">option 3</option>
                          <option value="1">option 4</option>
                          <option value="1">option 5</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" rows="3" placeholder="Deskripsi ..." name="deskripsi"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">File Gambar</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
        

        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Transaksi Selesai</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Alamat</th>
                      <th>Total + Ongkir</th>
                      <th>Kurir</th>
                      <th>Kode Unik</th>
                      <th>Bank</th>
                      <th>Status</th>
                      <th>Bukti Transfer</th>
                      <th>Tanggal Buat</th>
                      <th>Tanggal Selesai</th>
                      <th>Kirim Sebelum</th>
                      <th style="width: 140px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($listDone as $data)
                    <tr>
                      <td>{{$data->id}}</td>
                      <td>{{$data->name}}</td>
                      <td>{{$data->detail_lokasi}}</td>
                      <td>{{"Rp.".number_format($data->total_transfer)}}</td>
                      <td>{{$data->jasa_pengiriman}}</td>
                      <td>{{$data->kode_unik}}</td>
                      <td>{{$data->bank}}</td>
                      <td>{{$data->status}}</td>
                      <td><a href="{{ asset('storage/transfer/'.$data->buktiTransfer) }}
                      " target="_blank">Lihat Bukti Transfer</a></td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->updated_at}}</td>
                      <td>{{$data->expired_at}}</td>
                      <td>
                            @if($data->status == "DIKIRIM")
                            <a href="{{ route('transaksiSelesai', $data->id) }}">
                            <button type="button" class="btn btn-block btn-success btn-xs">Selesai</button>
                          </a>
                          @elseif($data->status == "DIBAYAR")
                          <a href="{{ route('transaksiConfirm', $data->id) }}">
                            <button type="button" class="btn btn-block btn-info btn-xs">Proses</button>
                          </a>
                          @elseif($data->status == "PROSES")
                          <a href="{{ route('transaksiKirim', $data->id) }}">
                            <button type="button" class="btn btn-block btn-success btn-xs">Kirim</button>
                          </a>
                          @elseif($data->status == "SELESAI" || $data->status == "BATAL")
                          <a href="#">
                            <button type="button" class="btn btn-block btn-info btn-xs">Detail</button>
                          </a>
                          @endif
                          </td>
                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>     

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form method="POST" action="{{ route('produk.store') }}" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama" name="name">
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control" placeholder="Harga ..." name="harga">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Pilih C
                          Kategory</label>
                        <select class="form-control" name="kategori_id">
                          <option value="1">option 1</option>
                          <option value="1">option 2</option>
                          <option value="1">option 3</option>
                          <option value="1">option 4</option>
                          <option value="1">option 5</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" rows="3" placeholder="Deskripsi ..." name="deskripsi"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">File Gambar</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
              </form>
            </div>
          </div>
        </div>


      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
