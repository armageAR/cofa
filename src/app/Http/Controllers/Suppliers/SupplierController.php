<?php

namespace App\Http\Controllers\Suppliers;

use App\Supplier;
use App\Contact;
use App\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use Illuminate\Support\Facades\DB;

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
    public function store(SupplierRequest $request)
    {
        DB::beginTransaction();
        try {
            DB::commit();

            $supplier = Supplier::create((array)$request->supplier);
            $supplier->contacts()->create((array)$request->contact);
            $supplier->addresses()->create((array)$request->address);

            return $supplier;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        $sup = Supplier::findOrFail($supplier)->first();
        $sup = $sup->load('contacts');
        $sup = $sup->load('addresses');
        return $sup;
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
    public function update(SupplierRequest $request)
    {
        DB::beginTransaction();
        try {

            $supplier = Supplier::find($request->supplier['id']);
            $supplier->update((array)$request->supplier);

            $contact = Contact::find($supplier->contacts->first()->id);
            $contact->update((array)$request->contact);

            $address = Address::find($supplier->addresses->first()->id);
            $address->update((array)$request->address);

            DB::commit();

            return $supplier;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($supplier)
    {
        return Supplier::destroy($supplier);
    }


    public function filter(Request $request)
    {
        $query = Supplier::query()->withCount('contacts', 'addresses');

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $suppliers = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            ->paginate($request->input('pagination.per_page'));

        return json_encode($suppliers);
    }

    public function count()
    {
        return Supplier::count();
    }


}
