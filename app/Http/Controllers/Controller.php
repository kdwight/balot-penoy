<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Toggles the row's status true or false
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    protected function status($id)
    {
        $model = str_replace('Controller', '', class_basename($this));
        $table = "App\Models\\$model";

        $row = $table::findOrFail($id);

        $row->update(['status' => request('status')]);

        return response(['success' => 'Status has been updated.'], 200);
    }
}
