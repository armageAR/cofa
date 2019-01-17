<?php

namespace App\Http\Controllers\Files;

use App\fileBody;
use App\fileHeader;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\fileHeader  $file
     * @return \Illuminate\Http\Response
     */
    public function show(fileHeader $file)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fileHeader  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(fileHeader $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    $file
     * @return \Illuminate\Http\Response
     */
    public function destroy($file)
    {
        //return fileHeader::destroy($file);
    }


    public function filter(Request $request)
    {
        $query = fileHeader::query()->with('supplier')->withCount('bodies');

        if ($request->search) {
            $query->where('fileName', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->supplier_id) {
            $query->where('supplier_id', '=', $request->supplier_id);
        }
        $files = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return json_encode($files);
    }

    public function count()
    {
        return fileHeader::count();
    }


}
