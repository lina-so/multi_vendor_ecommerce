<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    // public function __construct(StoreService $storeService , SoftDeleteService $softDeleteService)
    // {
    //     $this->storeService = $storeService;
    //     $this->softDeleteService = $softDeleteService;
    // }

    /*****************************************************************************************************/
    public function index()
    {
        //
    }

    /*****************************************************************************************************/

    public function create()
    {
        //
    }
    /*****************************************************************************************************/

    public function store(Request $request)
    {
        //
    }

    /*****************************************************************************************************/

    public function show(string $id)
    {
        //
    }
    /*****************************************************************************************************/

    public function edit(string $id)
    {
        //
    }
    /*****************************************************************************************************/

    public function update(Request $request, string $id)
    {
        //
    }
    /*****************************************************************************************************/

    public function destroy(string $id)
    {
        //
    }
    /*****************************************************************************************************/

    public function getStores($id)
    {
        $stores = Store::where('vendor_id', $id)->pluck('name', 'id');

        return response()->json($stores);
    }
}
