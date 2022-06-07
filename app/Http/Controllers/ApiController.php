<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use Response;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hasil = Counter::all();
        // dd($hasil);


        return Response::json($hasil);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $counter = new Counter;
        $counter->snfg = $request->snfg;
        $counter->line = $request->line;
        $counter->lolos = $request->lolos;
        $counter->reject = $request->reject;

        if ($counter->save()) {
            return response()->json('Data berhasil disimpan!');
        } else {
            return response()->json('Data gagal disimpan');
        }
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
    }

    public function upstore(Request $request)
    {
        $snfg = $request->snfg;

        $counter = Counter::where('snfg', '=', $snfg)->first();

        /// kondisi ketika snfg sudah ada di tabel
        if ($counter == null) {
            $counters = New Counter;
            $counters->snfg = $request->snfg;
            $counters->line = $request->line;
            $counters->lolos = $request->lolos;
            $counters->reject = $request->reject;
            if ($counters->save()){
                return response()->json('Data berhasil ditambahkan!');
            }
        } else {
            // kondisi ketika snfg belum ada ditabel
            $counter = DB::table('counters')
                ->select('id')
                ->where('snfg', $snfg)
                ->get();
            foreach ($counter as $counters) {
            }

            $counters = Counter::find($counters->id);
            $counters->snfg = $request->snfg;
            $counters->line = $request->line;
            $counters->lolos = $request->lolos;
            $counters->reject = $request->reject;
            if ($counters->save()) {
                return response()->json('Data berhasil diupdate!');

            }

        }
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
