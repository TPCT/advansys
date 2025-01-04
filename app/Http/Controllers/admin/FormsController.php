<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Newsletter;

class FormsController extends Controller
{
    public function contact_us(){
        $records = ContactUs::all();
        return Responses::success($records);
    }

    public function newsletter(){
        $records = Newsletter::all();
        return Responses::success($records);
    }
}
