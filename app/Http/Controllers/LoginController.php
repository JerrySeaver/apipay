<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Login;
class LoginController extends Controller
{
   
    public function login()
    {
        echo 1;
        $Login=new Login;
        $data=Login::get();
        dd($data);
    }
}
