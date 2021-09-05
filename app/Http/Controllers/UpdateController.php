<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Artisan;
use Schema;

class UpdateController extends Controller
{
    public function step0() {
        return view('update.step0');
    }

    public function step1() {
        if(get_setting('current_version') == '3.1'){
            $sql_path = base_path('sqlupdates/v32.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        if(get_setting('current_version') == '3.0'){
            $sql_path = base_path('sqlupdates/v31.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v32.sql');
            DB::unprepared(file_get_contents($sql_path));
        }

        return redirect()->route('update.step2');
    }

    public function step2() {
        Artisan::call('view:clear');
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }
}
