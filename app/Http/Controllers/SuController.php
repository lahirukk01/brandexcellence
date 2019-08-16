<?php

namespace App\Http\Controllers;

use App\BlockedEntry;
use App\Flag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuController extends Controller
{
    public function goToRoundTwo()
    {
        $flag = Flag::whereId(1)->first();
        $flag->current_round = 2;
        $flag->save();

        BlockedEntry::truncate();

        return redirect()->route('admin.index');
    }

    public function goBackToRoundOne()
    {
        $flag = Flag::whereId(1)->first();
        $flag->current_round = 1;
        $flag->save();

        return redirect()->route('admin.index');
    }
}
