<?php

namespace App\Http\Controllers\Suppliers;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SupplierController extends Controller
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
        $this->validate($request, [
            'taxNumber' => 'required|integer|unique:users',
            'bussinesName' => 'required|string',
            'name' => 'required|string'
        ]);

        $user = User::create([
            'taxNumber' => $request->taxNumber,
            'name' => $request->name,
            'bussinesName' => $request->bussinesName,
            'abbreviation' => $request->abbreviation,
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return Supplier::findOrFail($supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
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
    public function update(Request $request)
    {
        $this->validate($request, [
            'taxNumber' => 'required|integer|unique:users',
            'bussinesName' => 'required|string',
            'name' => 'required|string'
        ]);

        $supplier = Supplier::find($request->id);

        if ($supplier->taxNumber != $request->taxNumber) {
            $supplier->taxNumber = $request->taxNumber;
        }
        if ($supplier->bussinesName != $request->bussinesName) {
            $supplier->bussinesName = $request->bussinesName;
        }
        if ($supplier->name != $request->name) {
            $supplier->name = $request->name;
        }
        if ($supplier->abbreviation != $request->abbreviation) {
            $supplier->abbreviation = $request->abbreviation;
        }

        $supplier->save();

        return $supplier;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        return Supplier::destroy($supplier);
    }


    public function filter(Request $request)
    {
        $query = Supplier::query();

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $suppliers = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));



        return $suppliers;
    }

    public function count()
    {
        return Supplier::count();
    }
}
