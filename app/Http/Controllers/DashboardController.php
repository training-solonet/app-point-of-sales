<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrintService;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Membuat instance PrintService
        $printService = new PrintService();

        // Menggunakan service untuk mencetak
        $text = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non felis eu est pretium pretium sit amet quis tellus. Aenean dignissim tortor a magna aliquet vulputate. Pellentesque hendrerit pharetra tempor. Maecenas ipsum ex, venenatis vitae arcu quis, convallis fringilla felis. Etiam sed cursus nibh. Praesent vel dolor accumsan, sodales risus at, tincidunt ex. Vestibulum vitae metus laoreet, venenatis tortor vel, aliquam lectus. Sed iaculis, lectus id porta tincidunt, erat elit eleifend ante, at varius mauris dolor at risus. Pellentesque ut sapien id nibh finibus semper consectetur a est. Nam elementum vel turpis eget dignissim.";
        $printService->printText($text);

        return response()->json(['status' => 'success']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
