<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;
use Response;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
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
                return response()->json('Data berhasil disimpan!');
            } else {
                return response()->json('error');
            }
        } else {
            // insert data jika sudah adaa dan tidak null tess fosfo
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
                if($counters->reject < 0 || $counters->lolos < 0) {
                    $counters->reject = 0;
                    $counters->lolos=0;
                }
                $counters->total_reject = $request->total_reject;
                $counters->total_lolos = $request->total_lolos;
                $counters->save();
                // if ($counters->save() ) {
                //     return response()->json('Data berhasil simpan baru');
                // } else {
                //     return response()->json('error simpan baru');
                // }
            } else {

                return response()->json('data sudah ada');
            }
        }

    }
}
