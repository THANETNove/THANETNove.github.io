<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DurableArticlesRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("durable_articles_requisition.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("durable_articles_requisition.create");
    }

    public function durableRequisition($id) {


        $data = DB::table('durable_articles');
        $data = $data->where(function ($query) use ($id) {

            $components = explode('-', $id);

            $components = explode('-', $id);
                if (count($components) == 3) {
                    // Full value like "7115-005-0003"

                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->where('description', 'LIKE', "%$components[2]%")
                        ->orWhere('durableArticles_name', 'LIKE', "%$id%");
                } elseif (count($components) == 2) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$components[0]%")
                        ->where('type_durableArticles', 'LIKE', "%$components[1]%")
                        ->orWhere('description', 'LIKE', "%$id%")
                        ->orWhere('durableArticles_name', 'LIKE', "%$id%");

                } elseif (count($components) == 1) {
                    // Partial value like "715" or "005"
                    $query->where('group_class', 'LIKE', "%$id%")
                        ->orWhere('type_durableArticles', 'LIKE', "%$id%")
                        ->orWhere('description', 'LIKE', "%$id%")
                        ->orWhere('durableArticles_name', 'LIKE', "%$id%");
                }
            });
            $data = $data->get();


        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
