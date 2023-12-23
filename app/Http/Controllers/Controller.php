<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function backToForm(string $message, string $alertType = 'success')
    {
        if(request()->expectsJson()){
            return compact('message', 'type');
        }
        return redirect()->back()->with('form-alert', $message)->with('form-alert-type', $alertType);
    }

    public function redirectToForm(string $route, array $params, string $message, string $alertType = 'success')
    {
        return redirect()->route($route, $params)->with('form-alert', $message)->with('form-alert-type', $alertType);
    }
}
