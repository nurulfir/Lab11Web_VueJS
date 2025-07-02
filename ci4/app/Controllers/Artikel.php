<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';

        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $artikel = $artikelModel->getArtikelDenganKategori();
        $kategori = $kategoriModel->getKategoriWithCount(); // kamu perlu buat method ini

        return view('artikel/index', compact('artikel', 'kategori', 'title'));
    }


    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();

        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = $this->request->getVar('page') ?? 1;

        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $sort = $this->request->getVar('sort') ?? '';

        if ($sort == 'judul_asc') {
            $builder->orderBy('artikel.judul', 'ASC');
        } elseif ($sort == 'judul_desc') {
            $builder->orderBy('artikel.judul', 'DESC');
        }

        $artikel = $builder->paginate(5, 'default', $page);
        $pager = $model->pager;

        $pager_links = [];
        $total_pages = $pager->getPageCount();
        $current_page = $pager->getCurrentPage();

        for ($i = 1; $i <= $total_pages; $i++) {
            $pager_links[] = [
                'page' => $i,
                'isCurrent' => $i == $current_page
            ];
        }

        $data = [
            'title' => $title,
            'q' => $q,
            'kategori_id' => $kategori_id,
            'artikel' => $artikel,
            'sort' => $sort,
            'pager' => $pager_links // <- ini yang dikirim ke JavaScript
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        } else {
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll();
            return view('artikel/admin_index', $data);
        }
    }

    public function kategori($slug_kategori)
    {
        $artikelModel = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        // Cari data kategori berdasarkan slug
        $kategoriData = $kategoriModel->where('slug_kategori', $slug_kategori)->first();

        // Kalau tidak ditemukan
        if (!$kategoriData) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Kategori tidak ditemukan.");
        }

        $artikel = $artikelModel->getArtikelByKategori($kategoriData['id_kategori']);
        $kategori = $kategoriModel->getKategoriWithCount(); // untuk sidebar
        $title = "Kategori: " . $kategoriData['nama_kategori'];

        return view('artikel/index', compact('artikel', 'kategori', 'title'));
    }


    // ... (methods add, edit, delete remain largely the same, but update to handle id_kategori)
    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required'
        ]);

        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            $file = $this->request->getFile('gambar');
            $namaGambar = '';

            if ($file && $file->isValid()) {
                // Pindahkan file gambar ke folder gambar
                $file->move(ROOTPATH . 'public/gambar');
                $namaGambar = $file->getName();
            }

            $artikel = new ArtikelModel();
            // Pastikan slug unik
            $slug = url_title($this->request->getPost('judul'), '-', true);

            // Insert data artikel
            $artikel->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'slug'        => $slug,
                'gambar'      => $namaGambar,
            ]);
            return redirect()->to('/admin/artikel');
        }

        $title = "Tambah Artikel";
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->findAll();
        return view('artikel/form_add', compact('title', 'kategori'));
    }

    public function edit($id)
    {
        $model = new ArtikelModel();
        if ($this->request->getMethod() == 'POST' && $this->validate([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ])) {
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            $data['artikel'] = $model->find($id);
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll(); // Fetch categories for the form

            $data['title'] = "Edit Artikel";
            return view('artikel/form_edit', $data);
        }
    }
    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }
    public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('slug', $slug)->first();
        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the article.');
        }
        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }
}
