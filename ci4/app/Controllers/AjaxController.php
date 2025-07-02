<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Controller;

class AjaxController extends Controller
{
    protected $artikelModel;

    public function __construct()
    {
        $this->artikelModel = new ArtikelModel();
    }

    /**
     * Menampilkan halaman utama
     */
    public function index()
    {
        $data['title'] = 'Daftar Artikel';
        return view('ajax/index', $data);
    }

    /**
     * Mengambil semua data artikel (untuk tabel)
     */
    public function getData()
    {
        $data = $this->artikelModel->findAll();
        return $this->response->setJSON($data);
    }

    /**
     * Menyimpan data artikel baru
     */
    public function add()
    {
        $data = $this->request->getPost();

        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'isi' => 'required',
            'status' => 'required',
            // 'kategori' => 'required' // kalau kamu pakai kategori
        ]);

        if (!$validation->run($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        // Simpan ke database
        $this->artikelModel->save([
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'status' => $data['status'],
            // 'kategori' => $data['kategori'] ?? null
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Artikel berhasil ditambahkan.'
        ]);
    }

    /**
     * Mengedit data artikel berdasarkan ID
     */
    public function edit($id)
    {
        $data = $this->request->getPost();

        // Validasi
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'isi' => 'required',
            'status' => 'required',
        ]);

        if (!$validation->run($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        // Update ke database
        $this->artikelModel->update($id, [
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'status' => $data['status'],
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Artikel berhasil diperbarui.'
        ]);
    }

    /**
     * Menghapus artikel berdasarkan ID
     */
    public function delete($id)
    {
        $this->artikelModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Artikel berhasil dihapus.'
        ]);
    }
}
