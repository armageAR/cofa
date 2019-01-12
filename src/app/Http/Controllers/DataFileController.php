<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

use App\fileHeader;
use App\fileBody;
use App\Supplier;
use Illuminate\Support\Facades\Response;

class DataFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return 
     */
    public function index($id)
    {
        // try {
        $supplier = Supplier::findorfail($id);
        $this->register($supplier);

        $this->import($supplier);

        $response = Response::make($supplier, '200');
        $response->header('Content-Type', 'application/json');
        return $response;


    }

    /**
     * Register files to import
     * Save in table import_files the new files to import for a Supplier
     * 
     * @param App\Supplier $supplier
     */
    public function register(Supplier $supplier)
    {
        //Check that the pending files in the table are in the directory
        $filesTable = fileHeader::where('status', 'Pending')->where('supplier_id', $supplier->id)->get();
        foreach ($filesTable as $file) {
            $exist = Storage::disk($supplier->directory)->exists($file["fileName"]);
            if (!$exist) {
                $file->delete();
            }
        }

        //Verify that all the files are in the table
        $regfiles = array();
        $files = Storage::disk($supplier->directory)->listContents('/', false);
        foreach ($files as $file) {
            $regFile["fileName"] = $file["basename"];
            $regFile["supplier_id"] = $supplier->id;
            $regFile["status"] = 'Pending';
            $importFile = fileHeader::firstorcreate(['fileName' => $regFile["fileName"]], $regFile);
        }


        return true;
    }

    /**
     * Import the data in the files registered in the Table
     *
     * @param Supplier $supplier
     * @return void
     */
    public function import(Supplier $supplier)
    {
        $function = "import" . $supplier->directory;
        $files = fileHeader::where('status', 'Pending')->where('supplier_id', $supplier->id)->get();
        foreach ($files as $file) {
            $this->$function($supplier, $file);

        }
    }

    public function importmovistar(Supplier $supplier, fileHeader $file)
    {
        $isHeader = true;
        $discard = config('cofa.importMovistar.discard');
        $stream = Storage::disk($supplier->directory)->readStream($file->fileName);
        while (!feof($stream)) {
            $row = utf8_encode(trim(fgets($stream)));
            if (in_array($row, $discard)) {
                continue;
            }
            if ($row == config('cofa.importMovistar.headerLimit')) {
                $isHeader = false;
                $file->invoiceDate = Carbon::createFromFormat('d/m/Y', $file->invoiceDate)->format('Y-m-d');
                $file->save();
                continue;
            }
            $cols = explode("\t", $row);
            if ($isHeader) {
                    //encabezado
                $index = preg_replace("/[^a-zA-Z ]+/", "", trim($cols[0]));
                $bla = (config('cofa.importMovistar.' . $index));
                $file->$bla = trim($cols[1]);
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
