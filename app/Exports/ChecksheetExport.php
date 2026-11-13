<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


use PHPExcel_Worksheet_PageSetup;



class ChecksheetExport implements  FromView, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;


    protected $date;

    
    function __construct($claim_info)
    {
        $this->claim_info = $claim_info;

        
    }

    public function view(): View {
       
            return view('exports.checksheet', ['claim_info' => $this->claim_info]);
        
	}

    public function title(): string
    {
        return 'checksheet';
    }

     //for designs
     public function registerEvents(): array
     {
         
        $fontArial = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  9,
            )
        );

        $font2 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  12,
                'bold'      =>  true
            )
        );

        $font3 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  8,
                'bold'      =>  true,
                'italic'    => true,
            )
        );

        $font4 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  10,
                'bold'      =>  true,
                // 'italic'    => true,
            )
        );
        
        $font5 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  10,
                'bold'      =>  true,
                // 'italic'    => true,
            )
        );
        $font6 = array(
            'font' => array(
                'name'      =>  'Arial',
                'size'      =>  8,
                'bold'      =>  true,
                'italic'    => true,
            )
        );
        $styleBorderThin = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ]
            ]
        ];

        $styleBorder1 = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => '000000']

                ],
            ]
        ];
        $styleBorderAll = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleBorderBottomThick= [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],
        ];
        $styleBorderBottomThin= [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $styleBorderBottomMedium= [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                ],
            ],
        ];
      
      
        $styleBorderTopBottomThick= [
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],
        ];

        $center = array(
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ]
        );

        $top = array(
            'alignment' => [
                'vertical' => Alignment::VERTICAL_TOP,
            ]
        );
       
        
        
       
         return [
             AfterSheet::class => function(AfterSheet $event) use ($fontArial, $font2, $font3,$font4,$font5, $font6, $styleBorderThin,$styleBorder1,$styleBorderAll,$styleBorderTopBottomThick,$styleBorderBottomThick,$styleBorderBottomThin,$styleBorderBottomMedium,$center,$top)  {

                $event->sheet ->getPageMargins()->setBottom(0);
                $event->sheet ->getPageMargins()->setTop(0);
                $event->sheet ->getPageMargins()->setRight(0);
                $event->sheet ->getPageMargins()->setLeft(0);
                $event->sheet->getPageSetup()->setFitToPage(true);

                $event->sheet ->setShowGridlines(false);
               
                $event->sheet->getDelegate()->getStyle('J1')->applyFromArray($fontArial);
                $event->sheet->getDelegate()->getStyle('A2')->applyFromArray($font2);
               
                $event->sheet->getDelegate()->getStyle('A3')->applyFromArray($font3);
                $event->sheet->getDelegate()->getStyle('A4:K4')->applyFromArray($fontArial);
                $event->sheet->getDelegate()->getStyle('A5')->applyFromArray($font4);
                $event->sheet->getDelegate()->getStyle('A6:K6')->applyFromArray($fontArial);
                $event->sheet->getDelegate()->getStyle('A7:K7')->applyFromArray($fontArial);


                $event->sheet->getDelegate()->getStyle('A10:K10')->applyFromArray($center);
                $event->sheet->getDelegate()->getStyle('A12')->applyFromArray($font4);
                $event->sheet->getDelegate()->getStyle('C12')->applyFromArray($fontArial);
                $event->sheet->getDelegate()->getStyle('A13:K13')->applyFromArray($font5);
                $event->sheet->getDelegate()->getStyle('A14:K22')->applyFromArray($fontArial);


                $event->sheet->getDelegate()->getStyle('A23')->applyFromArray($font4);
                $event->sheet->getDelegate()->getStyle('C23')->applyFromArray($fontArial);
                $event->sheet->getDelegate()->getStyle('A24:K24')->applyFromArray($font5);
                $event->sheet->getDelegate()->getStyle('A25:K28')->applyFromArray($fontArial);



                $event->sheet->getDelegate()->getStyle('A30')->applyFromArray($font4);
                $event->sheet->getDelegate()->getStyle('C30')->applyFromArray($fontArial);
                $event->sheet->getDelegate()->getStyle('A31:K31')->applyFromArray($font5);
                $event->sheet->getDelegate()->getStyle('A32:K36')->applyFromArray($fontArial);


                $event->sheet->getDelegate()->getStyle('A38')->applyFromArray($font4);

                $event->sheet->getDelegate()->getStyle('A42')->applyFromArray($fontArial);




                $event->sheet->getDelegate()->getStyle('A2:K2')->applyFromArray($styleBorder1);
                
               
                $event->sheet ->getDelegate()->getStyle('A3:K3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $event->sheet ->getDelegate()->getStyle('C4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet ->getDelegate()->getStyle('H4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet->getDelegate()->getStyle('A5:K5')->applyFromArray($styleBorder1);
                $event->sheet ->getDelegate()->getStyle('A6:K6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet ->getDelegate()->getStyle('A7:K7')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $event->sheet ->getDelegate()->getStyle('A8:K8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                $event->sheet->getDelegate()->getStyle('A9:K9')->applyFromArray($styleBorderAll);


                $event->sheet->getDelegate()->getStyle('A10:K10')->applyFromArray($styleBorderAll);

                $event->sheet->getDelegate()->getStyle('A12:K12')->applyFromArray($styleBorderTopBottomThick);

                $event->sheet->getDelegate()->getStyle('A13:K13')->applyFromArray($styleBorderAll);
                $event->sheet ->getDelegate()->getStyle('A13:K13')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                
                $event->sheet->getDelegate()->getStyle('A14:K22')->applyFromArray($styleBorderAll);

                $event->sheet->getDelegate()->getStyle('A23:K23')->applyFromArray($styleBorderTopBottomThick);
                $event->sheet->getDelegate()->getStyle('A24:K24')->applyFromArray($styleBorderAll);
                $event->sheet ->getDelegate()->getStyle('A24:K24')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $event->sheet->getDelegate()->getStyle('A25:K28')->applyFromArray($styleBorderAll);

                $event->sheet->getDelegate()->getStyle('A29:K29')->applyFromArray($styleBorderTopBottomThick);
                $event->sheet->getDelegate()->getStyle('A30:K30')->applyFromArray($styleBorderTopBottomThick);
                $event->sheet->getDelegate()->getStyle('A31:K31')->applyFromArray($styleBorderAll);
                $event->sheet ->getDelegate()->getStyle('A31:K31')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                $event->sheet->getDelegate()->getStyle('A32:K36')->applyFromArray($styleBorderAll);

                $event->sheet->getDelegate()->getStyle('A38:K38')->applyFromArray($styleBorderTopBottomThick);

                $event->sheet->getDelegate()->getStyle('A39:K39')->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getStyle('A40:K40')->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getStyle('A41:K41')->applyFromArray($styleBorderBottomThin);


                $event->sheet->getDelegate()->getStyle('A42')->applyFromArray($top);

                $event->sheet->getDelegate()->getStyle('B43:C43')->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getStyle('E43:H43')->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getStyle('J43:K43')->applyFromArray($styleBorderBottomThin);

                $event->sheet->getDelegate()->getStyle('B45:D45')->applyFromArray($styleBorderBottomThin);
                $event->sheet->getDelegate()->getStyle('J45:K45')->applyFromArray($styleBorderBottomThin);


                




                // $event->sheet->getDelegate()->getStyle('A11:K11')->applyFromArray($styleBorderBottomThick);
                // $event->sheet->getDelegate()->getStyle('A12:K21')->applyFromArray($styleBorderAll);
                // $event->sheet ->getDelegate()->getStyle('A12:K12')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                // $event->sheet->getDelegate()->getStyle('A22:K22')->applyFromArray($styleBorderTopBottomThick);

                // $event->sheet->getDelegate()->getStyle('A23:K27')->applyFromArray($styleBorderAll);
                // $event->sheet ->getDelegate()->getStyle('A23:K23')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                // $event->sheet->getDelegate()->getStyle('A28:K28')->applyFromArray($styleBorderTopBottomThick);
                // $event->sheet->getDelegate()->getStyle('A29:K29')->applyFromArray($styleBorderTopBottomThick);

                // $event->sheet->getDelegate()->getStyle('A30:K35')->applyFromArray($styleBorderAll);
                // $event->sheet ->getDelegate()->getStyle('A30:K30')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                // $event->sheet->getDelegate()->getStyle('A37:K37')->applyFromArray($styleBorderTopBottomThick);

                // $event->sheet->getDelegate()->getStyle('A38:K38')->applyFromArray($styleBorderBottomThin);
                // $event->sheet->getDelegate()->getStyle('A39:K39')->applyFromArray($styleBorderBottomThin);

                // $event->sheet->getDelegate()->getStyle('A40:K40')->applyFromArray($styleBorderBottomMedium);

                // $event->sheet->getDelegate()->getStyle('A40:K40')->applyFromArray($styleBorderBottomMedium);
                


                // $event->sheet->getDelegate()->getStyle('B42:C42')->applyFromArray($styleBorderBottomThin);
                // $event->sheet->getDelegate()->getStyle('E42:H42')->applyFromArray($styleBorderBottomThin);
                // $event->sheet->getDelegate()->getStyle('J42:K42')->applyFromArray($styleBorderBottomThin);

                // $event->sheet->getDelegate()->getStyle('B44:D44')->applyFromArray($styleBorderBottomThin);
                // $event->sheet->getDelegate()->getStyle('J44:K44')->applyFromArray($styleBorderBottomThin);





                $event->sheet->getDelegate()->getStyle('A1:K46')->applyFromArray($styleBorder1);
                
                 $event->sheet->getDelegate()->getRowDimension('27')->setRowHeight(24);
                 $event->sheet->getDelegate()->getRowDimension('28')->setRowHeight(24);
                 $event->sheet->getDelegate()->getRowDimension('34')->setRowHeight(25);

                 $event->sheet->getDelegate()->getRowDimension('10')->setRowHeight(68);

                 $event->sheet->getDelegate()->getRowDimension('42')->setRowHeight(20);
                
                $event->sheet->getColumnDimension('A')->setWidth(15);
                 $event->sheet->getColumnDimension('B')->setWidth(9.5);
                 $event->sheet->getColumnDimension('C')->setWidth(10);
                 $event->sheet->getColumnDimension('D')->setWidth(12);
                 $event->sheet->getColumnDimension('E')->setWidth(7);
                 $event->sheet->getColumnDimension('F')->setWidth(4);
                 $event->sheet->getColumnDimension('G')->setWidth(4);
                 $event->sheet->getColumnDimension('H')->setWidth(10.5);
                 $event->sheet->getColumnDimension('I')->setWidth(16);
                 $event->sheet->getColumnDimension('J')->setWidth(15);
                 $event->sheet->getColumnDimension('K')->setWidth(19);


                //  $event->sheet->getDelegate()->getStyle('A2')->applyFromArray($style1);
                //  $event->sheet->getDelegate()->getStyle('B2')->applyFromArray($style1);
                //  $event->sheet->getDelegate()->getStyle('C2')->applyFromArray($style1);
                //  $event->sheet->getDelegate()->getStyle('D2')->applyFromArray($style1);

                //  $event->sheet->getDelegate()->getStyle('A2:X2')->getFont()->setSize(13);
               
             },
         ];
     }

  

    
    

 
}
