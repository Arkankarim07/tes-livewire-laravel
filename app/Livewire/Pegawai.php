<?php

namespace App\Livewire;

use App\Models\Pegawai as ModelsPegawai;
use Livewire\Component;
use Livewire\WithPagination;

class Pegawai extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama;
    public $email;
    public $alamat;
    public $pegawai_id;
    public $updatePegawai = false;
    public $searchKey;
    public $pegawai_selected = [];

    public function store() {
       $rules = [
           'nama' => 'required',
           'email' => 'required|email',
           'alamat' => 'required'
       ];

       $pesanError = [
        'nama.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Email tidak valid',
        'alamat.required' => 'Alamat wajib diisi'
       ];

       $validate = $this->validate($rules, $pesanError);

       ModelsPegawai::create($validate);
       session()->flash('message', 'Data Berhasil Masuk');

       $this->clear();
    }

    public function edit($id) {
        $data = ModelsPegawai::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->alamat = $data->alamat;
        
        $this->pegawai_id = $id;
        $this->updatePegawai = true;
    }

    public function update() {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required'
        ];
 
        $pesanError = [
         'nama.required' => 'Nama wajib diisi',
         'email.required' => 'Email wajib diisi',
         'email.email' => 'Email tidak valid',
         'alamat.required' => 'Alamat wajib diisi'
        ];
 
        $validate = $this->validate($rules, $pesanError);
        $data = ModelsPegawai::find($this->pegawai_id);
        $data->update($validate);
        session()->flash('message', 'Data Berhasil Update');

        $this->clear();
    }

    public function delete() {

        if($this->pegawai_id != null) {
            $id = $this->pegawai_id;
            $data = ModelsPegawai::find($id);
            $data->delete();
        }

        if(count($this->pegawai_selected)) {
            for ($x = 0; $x < count($this->pegawai_selected); $x++) {
                ModelsPegawai::find($this->pegawai_selected[$x])->delete();
            }
        }

        session()->flash('message', 'Data Berhasil Hapus');

        $this->clear();
    }

    public function deleteConfirm($id) {
        if ($id != null) {
            $this->pegawai_id = $id;
        }
    }

    public function clear() {
        $this->nama = null;
        $this->email = null;
        $this->alamat = null;
        $this->pegawai_id = null;
        $this->updatePegawai = false;
        $this->pegawai_selected = [];
    }
    public function render()
    {

        if ($this->searchKey != null) {
            $data = ModelsPegawai::
            where('nama', 'like', '%'.$this->searchKey.'%' )->
            orWhere('email', 'like', '%'.$this->searchKey.'%' )->
            orWhere('alamat', 'like', '%'.$this->searchKey.'%' )->
            orderBy('nama', 'asc')->paginate(2);
        } else {
            $data = ModelsPegawai::orderBy('nama', 'asc')->paginate(2);
        }
        return view('livewire.pegawai', [
            'dataPegawai' => $data
        ]);
    }
}
