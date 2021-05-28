<?php

namespace App\Exports;

use App\Jalan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JalanExport implements WithMapping, ShouldAutoSize, WithStyles, FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jalan::orderBy('id', 'ASC')->get();
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function map($jalan): array
    {
        return [
            $jalan->nama_ruas,
            $jalan->kecamatan->nama,
            $jalan->kelas_jalan,
            $jalan->status_jalan,
            $jalan->panjang,
            $jalan->lebar,
            $jalan->kondisi_jalan,
        ];
    }

    public function headings(): array
    {
        return ["Nama Ruas", "Kecamatan", "Kelas Jalan", "Status Jalan", "Panjang", "Lebar", "Kondisi Jalan"];
    }

}
