<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_kategori', 'slug_kategori'];

    public function getKategoriWithCount()
    {
        return $this->select('kategori.*, COUNT(artikel.id) as jumlah_artikel')
            ->join('artikel', 'artikel.id_kategori = kategori.id_kategori', 'left')
            ->groupBy('kategori.id_kategori')
            ->findAll();
    }


    public function getArtikelByKategori($id_kategori)
    {
        return $this->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->where('artikel.id_kategori', $id_kategori)
            ->findAll();
    }
}
