<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Item;
use App\Http\Controllers\Admin\ItemController;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class ItemImport implements ToCollection, WithHeadingRow 
{
    use Importable;
    
    private $errors = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $rowIndex => $row) {
            $row = $row->only(['nama_kategori', 'nama_barang', 'unit', 'harga']);
            try {
                // Validasi field tidak boleh kosong
                if (empty($row['nama_kategori'])) {
                    $this->errors[] = "Nama Kategori tidak boleh kosong pada baris " . ($rowIndex + 2);
                    continue;
                }

                if (empty($row['nama_barang'])) {
                    $this->errors[] = "Nama Barang tidak boleh kosong pada baris " . ($rowIndex + 2); 
                    continue;
                }

                if (empty($row['unit'])) {
                    $this->errors[] = "Unit tidak boleh kosong pada baris " . ($rowIndex + 2);
                    continue;
                }

                if (empty($row['harga'])) {
                    $this->errors[] = "Harga tidak boleh kosong pada baris " . ($rowIndex + 2);
                    continue;
                }

                if (empty($row['harga'])) {
                    $this->errors[] = "Harga tidak boleh kosong pada baris " . ($rowIndex + 2);
                    continue;
                }
                
                if (str_contains($row['harga'], '.') || str_contains($row['harga'], ',')) {
                    $this->errors[] = "Harga tidak boleh ada titik atau koma pada baris " . ($rowIndex + 2);
                    continue;
                }

                $category = Category::whereRaw('LOWER(name) = ?', [strtolower($row['nama_kategori'])])->first();

                if (!$category) {
                    $this->errors[] = "Kategori <b>{$row['nama_kategori']}</b> tidak ditemukan pada baris " . ($rowIndex + 2);
                    continue;
                }

                $itemController = new ItemController();
                $code = $itemController->generateKode($category->code);

                Item::create([
                    'category_id' => $category->id,
                    'code' => $code,
                    'name' => $row['nama_barang'],
                    'unit' => $row['unit'],
                    'price' => $row['harga'],
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                

            } catch (\Exception $e) {
                $this->errors[] = "Error pada baris " . ($rowIndex + 2) . ": " . $e->getMessage();
            }
        }

        if (count($this->errors) > 0) {
            throw new \Exception(implode("\n", $this->errors));
        }
    }
}
