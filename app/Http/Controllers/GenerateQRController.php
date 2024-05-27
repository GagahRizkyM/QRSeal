<?php

namespace App\Http\Controllers;

use App\Models\GenerateQR;
use App\Http\Requests\StoreGenerateQRRequest;
use App\Http\Requests\UpdateGenerateQRRequest;
use Illuminate\Support\Facades\Request;

class GenerateQRController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        return view('generate', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function handleUpload(Request $request)
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGenerateQRRequest $request)
    {
        if($request->hasFile('file')) {
            $file = $request->file('file');
            // $path = $file->store('uploads', 'public');
            $path = 'oke path';
            return response()->json(['path' => $path], 200);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(GenerateQR $generateQR)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenerateQR $generateQR)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGenerateQRRequest $request, GenerateQR $generateQR)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenerateQR $generateQR)
    {
        //
    }
}
