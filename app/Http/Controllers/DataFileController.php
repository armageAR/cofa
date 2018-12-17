<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\import_file;
use App\importHeader;
use App\importBody;

class DataFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Storage::disk('movistar')->listContents('/', false);
        foreach ($files as $file) {
            //Register each file
            $regFile["fileName"] = $file["basename"];
            $regFile["supplier_id"] = '1';
            $regFile["status"] = 'Pending';
            $importFile = import_file::firstorcreate(['fileName' => $regFile["fileName"]], $regFile);
            echo 'Archivo: ' . $file["basename"];
            
            // DB::beginTransaction();
            // try {

            //     DB::commit();
            // } catch (\Exception $e) {
            //     DB::rollBack();
            //     throw $e;
            // }


            if ($importFile->status == "Pending") {
                echo ' Importando...<br>';
                $isHeader = true;
                $header = [];
                $discard = config('cofa.importMovistar.discard');
                $header["file_id"] = $importFile->id;
                $header['fileStatus'] = "Pending";
                $stream = Storage::disk('movistar')->readStream($importFile->fileName);
                while (!feof($stream)) {
                    $row = utf8_encode(trim(fgets($stream)));
                    if (in_array($row, $discard)) {
                        continue;
                    }
                    if ($row == config('cofa.importMovistar.headerLimit')) {
                        $isHeader = false;
                        $header['invoiceDate'] = Carbon::createFromFormat('d/m/Y', $header['invoiceDate'])->format('Y-m-d');

                        $importHeader = importHeader::firstorcreate($header);
                        echo '--Encabezado: OK<br>';
                        continue;
                    }
                    $cols = explode("\t", $row);
                    if ($isHeader) {
                    //encabezado
                        $index = preg_replace("/[^a-zA-Z ]+/", "", trim($cols[0]));
                        $header[config('cofa.importMovistar.' . $index)] = trim($cols[1]);
                    } else {
                    //cuerpo
                        if (sizeof($cols) != 15) {
                            continue;
                        }

                        $importBody = new importBody;
                        $importBody->invoiceNumber = trim($cols[0]);
                        $importBody->invoiceType = trim($cols[1]);

                        $invoiceDate = \DateTime::createFromFormat("dmY", trim($cols[2]));
                        $importBody->invoiceDate = date_format($invoiceDate, 'Y-m-d');
                        $importBody->accountNumber = trim($cols[3]);
                        $importBody->lineNumber = trim($cols[4]);
                        $importBody->itemDetail = trim($cols[5]);
                        //$importBody->itemDescription = trim($cols[6]);
                        $importBody->itemDescription = mb_convert_encoding(trim($cols[6]), "UTF-8");


                        if (trim($cols[7]) != '') {
                            $period = explode("-", $cols[7]);
                            $importBody->startDate = trim($period[0]);//Carbon::createFromFormat('d/m/Y', trim($period[0]))->format('Y-m-d');
                            $importBody->endDate = Carbon::createFromFormat('d/m/Y', trim($period[1]))->format('Y-m-d');
                        }
                        $importBody->amountNoVat = (float)trim($cols[10]);
                        $importBody->vatAmount = (float)trim($cols[11]);
                        $importBody->vatPercent = (float)trim($cols[12]);
                        $importBody->totalAmount = (float)trim($cols[13]);
                        $importBody->importHeader_id = $importHeader->id;

                        //dd($importBody);
                        $importBody->save();
                        unset($importBody);
                        echo $row . ' [IMPORTED]<br>';
                    }
                }
                echo '--Cuerpo: OK<br>';
                fclose($stream);
            } else {
                echo ' No esta Pendiente <br>';
            }
            echo '---------< fin archivo>--------------<br>';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
