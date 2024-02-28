<div class="container-sm ">

    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $item)
            <li>{{ $item }}</li>
        @endforeach
      </div>
    @endif

    @if (session()->has('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
      </div>
    @endif
    <!-- START FORM -->
    @if ($updatePegawai)
    <h1 class="my-3 text-center text-primary ">Form Update</h1>
    @else
    <h1 class="my-3 text-center text-primary ">Form Data</h1>
    @endif
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="alamat">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($updatePegawai === false)
                    <button type="button" class="btn btn-primary" name="submit" wire:click="store()">Submit</button>
                    @else
                    <button type="button" class="btn btn-primary" name="submit" wire:click="update()">Update</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        @if (count($pegawai_selected) > 1)
            <a wire:click="deleteConfirm('')" class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#exampleModal">Delete {{ count($pegawai_selected) }}</a>
        @endif
        <div class="pb-3">
            <p>Cari</p>
            <input type="text" class="form-control w-25" wire:model.live="searchKey">
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4">Nama</th>
                    <th class="col-md-3">Email</th>
                    <th class="col-md-2">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPegawai as $key => $item)
                    
                <tr>
                    <td><input type="checkbox" wire:key="{{ $item->id }}" value="{{ $item->id }}" wire:model.live="pegawai_selected"></td>
                    <td>{{ $dataPegawai->firstItem() + $key }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        <a wire:click="edit({{ $item->id }})" class="btn btn-warning btn-sm">Edit</a>
                        <a wire:click="deleteConfirm({{ $item->id }})" class="btn btn-danger btn-sm " data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataPegawai->links() }}

    </div>
    <!-- AKHIR DATA -->

    <!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah anda yakin ingin menghapus {{ count($pegawai_selected) }} data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-success" wire:click="delete()" data-bs-dismiss="modal">Ya</button>
        </div>
      </div>
    </div>
  </div>
</div>
