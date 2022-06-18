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
        $totalreject = $request->total_reject;
        $totallolos = $request->total_lolos;

        $last = Counter::latest()->first();
        //  dd($last);

        // pertama kali sistem dijalankan
        if ($last == null) {
            $counters = new Counter;
            $counters->snfg = $request->snfg;
            $counters->line = $request->line;
            $counters->reject = 0;
            $counters->lolos = 0;
            $counters->total_reject = 0;
            $counters->total_lolos = 0;
            if ($counters->save()) {
                return response()->json('Data berhasil disimpancukkk!');
            } else {
                return response()->json('error');
            }
        } else {
            // insert data jika sudah adaa dan tidak null
            // coba 1 22
            $snfg_last = $last->snfg;
            $tot_reject = $last->total_reject;
            $tot_lolos = $last->total_lolos;
            if ($snfg_last != "null" && ($totalreject != $tot_reject || $totallolos != $tot_lolos)) {
                $counters = new Counter;
                $counters->snfg = $request->snfg;
                $counters->line = $request->line;
                $counters->reject = ($request->total_reject) - $tot_reject;
                $counters->lolos = ($request->total_lolos) - $tot_lolos;
                $counters->total_reject = $request->total_reject;
                $counters->total_lolos = $request->total_lolos;
                if ($counters->save()) {
                    return response()->json('Data berhasil simpan baru');
                } else {
                    return response()->json('error simpan baru');
                }
            } else {
                return response()->json('data sudah ada');
            }
        }










        // if($snfg == 'null'){
        //     return response()->json('data null tidak disimpan di database');
        // } else {
        //     $counter = Counter::where('snfg', '=', $snfg)->first();

        //     /// kondisi ketika snfg sudah ada di tabel
        //     if ($counter == null) {
        //         $counters = New Counter;
        //         $counters->snfg = $request->snfg;
        //         $counters->line = $request->line;
        //         $counters->lolos = $request->lolos;
        //         $counters->reject = $request->reject;
        //         if ($counters->save()){
        //             return response()->json('Data berhasil ditambahkan!');
        //         }
        //     } else {
        //         // kondisi ketika snfg belum ada ditabel
        //         $counter = DB::table('counters')
        //             ->select('id')
        //             ->where('snfg', $snfg)
        //             ->get();
        //         foreach ($counter as $counters) {
        //         }

        //         $counters = Counter::find($counters->id);
        //         $counters->snfg = $request->snfg;
        //         $counters->line = $request->line;
        //         $counters->lolos = $request->lolos;
        //         $counters->reject = $request->reject;
        //         if ($counters->save()) {
        //             return response()->json('Data berhasil diupdate!');

        //         }

        //     }

        // }


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
