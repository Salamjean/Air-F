<?php

namespace App\Exports;

use App\Models\Equipement;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class EquipementExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithCustomStartCell, WithEvents
{
    protected $categoryId;
    protected $siteId;
    protected $lowStock;
    protected $siteName;

    public function __construct($categoryId = null, $siteId = null, $lowStock = false, $siteName = null)
    {
        $this->categoryId = $categoryId;
        $this->siteId = $siteId;
        $this->lowStock = $lowStock;
        $this->siteName = $siteName;
    }

    public function query()
    {
        $query = Equipement::query()->with(['category', 'sites', 'creator']);

        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        if ($this->siteId) {
            $query->whereHas('sites', function ($q) {
                $q->where('site_id', $this->siteId);
            });
        }

        if ($this->lowStock) {
            $query->where('stock_quantity', '<=', 5);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Désignation',
            'Catégorie',
            'Sites',
            'Stock Actuel',
            'Unité',
            'Seuil Alerte',
            'Type/Longueur',
            'Ajouté par',
            'Date création',
        ];
    }

    public function map($equipement): array
    {
        return [
            $equipement->name,
            $equipement->category->name,
            $equipement->sites->pluck('name')->implode(', '),
            $equipement->stock_quantity,
            $equipement->unit,
            $equipement->stock_min_alert,
            ($equipement->type ?? '') . ($equipement->longueur ? ' / ' . $equipement->longueur : ''),
            ($equipement->creator->name ?? 'N/A') . ' ' . ($equipement->creator->prenom ?? ''),
            $equipement->created_at->format('d/m/Y H:i'),
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40, // Désignation
            'B' => 20, // Catégorie
            'C' => 25, // Sites
            'D' => 15, // Stock Actuel
            'E' => 15, // Unité
            'F' => 15, // Seuil Alerte
            'G' => 20, // Type/Longueur
            'H' => 25, // Ajouté par
            'I' => 20, // Date
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style pour la ligne d'entêtes (ligne 3 car startCell est A3)
            3 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'C53030'], // Rouge foncé (type Tailwind red-700)
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $siteSuffix = $this->siteName ? ' - ' . strtoupper($this->siteName) : '';
                $title = 'ETAT DE STOCK' . $siteSuffix;

                // Fusionner les cellules pour le titre (A à I)
                $event->sheet->mergeCells('A1:I1');

                // Définir le contenu et le style du titre
                $event->sheet->getDelegate()->setCellValue('A1', $title);

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                        'color' => ['rgb' => '2D3748'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Ajouter des bordures à tout le tableau (A à I) et tout centrer
                $lastRow = $event->sheet->getHighestRow();
                $event->sheet->getStyle('A3:I' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
