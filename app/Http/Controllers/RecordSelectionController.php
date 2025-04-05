<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordSelectionController extends Controller
{
    /**
     * Display the record creation selection page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('records.create-selection');
    }
} 