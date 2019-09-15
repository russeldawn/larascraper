<?php

namespace App\Http\Controllers;

use App\Http\Requests\urlTargetRequest;
use App\Models\Scraper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ScrapersImport;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Exports\ScrapersExport;

class ScraperController extends Controller
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
        return view('scraper');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(urlTargetRequest $request)
    {
        if (isset($request['urlTarget'])) {
            $parsed_url = parse_url($request['urlTarget']);
            $pattern = '/([^?&=#]+)=([^&#]*)/';
            $regex = preg_match_all($pattern, $request['urlTarget'], $urlSplit);
            // $request->referenceList->store();
            Excel::import(new ScrapersImport, storage_path('app/import/folio_list.xlsx'));

            // return [
            //     $parsed_url,
            //     $urlSplit
            // ];
            return Excel::download(new ScrapersExport, 'scraped_data.xlsx');
        }

        // Excel::download()
        // return view('scraper')->with('data', $request->all());
        // return response()->json($request, 200);
        return Excel::download(new ScrapersExport, 'scraped_data.xlsx');
        // return view('scraper')->with('data', $request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Scraper  $scraper
     * @return \Illuminate\Http\Response
     */
    public function show(Scraper $scraper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Scraper  $scraper
     * @return \Illuminate\Http\Response
     */
    public function edit(Scraper $scraper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scraper  $scraper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scraper $scraper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Scraper  $scraper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scraper $scraper)
    {
        //
    }
}
