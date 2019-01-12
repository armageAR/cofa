<?php
namespace App\Library\Suppliers;

use App\Supplier;
use App\fileHeader;
use App\fileBody;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ImportMovistar
{
    private $discard = ['NRO CPTE  	TIPO DE CPTE   	FEC.CPTE	NRO CTA.  	NRO MOVIL 	Min.Plan	DESCRIPCION                   	     PERIODO        	UNIDADES	PRECIO 	IMPORTE S/IVA	 IMPORTE IVA 	IVA % 	   IMP.TOTAL'];
    private $headerLimit = 'DETALLE DE COMPROBANTE';
    private $headerText = array(
        'CLIENTE NRO' => 'custNumber',
        'DENOMINACION' => 'custName',
        'FECHA FACTURA' => 'invoiceDate'
    );

    public function import(Supplier $supplier, fileHeader $file)
    {
        $isHeader = true;
        $stream = Storage::disk(strtolower($supplier->directory))->readStream($file->fileName);
        while (!feof($stream)) {
            $row = utf8_encode(trim(fgets($stream)));
            if (in_array($row, $this->discard)) {
                continue;
            }
            if ($row == $this->headerLimit) {
                $isHeader = false;
                $file->invoiceDate = Carbon::createFromFormat('d/m/Y', $file->invoiceDate)->format('Y-m-d');
                $file->save();
                continue;
            }
            $cols = explode("\t", $row);
            if ($isHeader) {
                    //encabezado
                $index = preg_replace("/[^a-zA-Z ]+/", "", trim($cols[0]));
                $headerTag = $this->headerText[$index];
                $file->$headerTag = trim($cols[1]);
            } else {
                    //cuerpo
                if (sizeof($cols) != 15) {
                    continue;
                }

                $importBody = new fileBody;
                $importBody->invoiceNumber = trim($cols[0]);
                $importBody->invoiceType = trim($cols[1]);

                $invoiceDate = \DateTime::createFromFormat("dmY", trim($cols[2]));
                $importBody->invoiceDate = date_format($invoiceDate, 'Y-m-d');
                $importBody->accountNumber = trim($cols[3]);
                $importBody->lineNumber = trim($cols[4]);
                $importBody->itemDetail = trim($cols[5]);
                $importBody->itemDescription = mb_convert_encoding(trim($cols[6]), "UTF-8");


                if (trim($cols[7]) != '') {
                    $period = explode("-", $cols[7]);
                    $importBody->startDate = trim($period[0]);
                    $importBody->endDate = Carbon::createFromFormat('d/m/Y', trim($period[1]))->format('Y-m-d');
                }
                $importBody->amountNoVat = (float)trim($cols[10]);
                $importBody->vatAmount = (float)trim($cols[11]);
                $importBody->vatPercent = (float)trim($cols[12]);
                $importBody->totalAmount = (float)trim($cols[13]);
                $importBody->filesHeader_id = $file->id;

                $importBody->save();
                unset($importBody);
            }
        }
        fclose($stream);
        $file->update(['status' => 'Imported']);
    }
}
