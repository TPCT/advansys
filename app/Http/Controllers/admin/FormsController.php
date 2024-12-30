<?php

namespace App\Http\Controllers\admin;

use App\Helpers\Responses;
use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class FormsController extends Controller
{
    public function contact_us(){
        $record = ContactUs::paginate(10)->withQueryString();
        return Responses::success([
            'current_page' => $record->currentPage(),
            'per_page' => $record->perPage(),
            'total' => $record->total(),
            'records' => $record->getCollection()
        ]);
    }
}
