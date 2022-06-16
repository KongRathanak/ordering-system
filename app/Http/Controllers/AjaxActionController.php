<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MatchModelTrait;

class AjaxActionController extends Controller
{
    use MatchModelTrait;

    public function webAjaxCall(Request $request)
    {
        $page = $request->page ?? 10;
        $table = $request->table ?? '';
        $value = $request->q ?? '';
        $type = $request->type ?? 'ajax';

        $query = $this->actionType($table, $value, $type);
        return $query->paginate($page);
    }


}
