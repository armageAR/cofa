<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\fileHeader;
//use App\fileBody;
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
        $filesTable = fileHeader::status('Pending')->supplier($supplier->id)->get();
        foreach ($filesTable as $file) {
            $readFile = strtolower($supplier->directory) . "/" . $file["fileName"];
            $exist = Storage::disk('source')->exists($readFile);
            if (!$exist) {
                $file->delete();
            }
        }

        //Verify that all the files are in the table
        $regfiles = array();
        $dir = strtolower($supplier->directory);
        $files = Storage::disk('source')->listContents('/' . $dir, false);
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
        $supplierImportClass = 'App\Library\Suppliers\Import' . $supplier->directory;
        $import = new $supplierImportClass();
        $files = fileHeader::status('Pending')->supplier($supplier->id)->get();
        foreach ($files as $file) {
            $import->import($supplier, $file);

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
