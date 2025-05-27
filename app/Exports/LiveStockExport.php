<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LiveStockExport implements FromCollection, WithHeadings, WithMapping
{
    protected $stock;
    protected $no = 1;
    public function __construct()
    {   
        $this->stock = Stock::select('item_id', 'warehouse_id')
        ->groupBy('item_id', 'warehouse_id');
    }

    public function collection()
    {
        return $this->stock->get();
    }

    public function headings(): array
    {
        return ['No', 'Item', 'Lokasi Item', 'Jumlah', 'Satuan / Unit'];
    }

    public function map($stock): array
    {
        return [
            $this->no++,
            $stock->item->name,
            $stock->warehouse->name,
            (string) Stock::liveStock($stock->item_id, $stock->warehouse_id),
            $stock->item->unit
        ];
    }
}
