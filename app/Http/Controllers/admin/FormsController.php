<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class FormsController extends Controller
{
    public function contact_us(){
        $records = ContactUs::all();
        return Responses::success($records);
    }
}
