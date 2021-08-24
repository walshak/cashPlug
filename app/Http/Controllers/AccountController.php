<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    //
    /**
     * retrive a list of banks from the payment api
     * @return json array
     *
     */
    public function get_banks(){
        $response = Http::withToken(env('PAYSTACK_SK_KEY'))->get('https://api.paystack.co/bank',[
            'country' => 'nigeria',
            'currency' => 'NGN'
        ]);
        if($response->status()==200){
            return response($response->body());
        }else{
            abort(404,'failed to fetch banks');
        }

    }

    public function verify_account(){
        $bank_code = $_GET['bank_code'];
        $account_number = $_GET['account_number'];
        $account_name = Auth::user()->name;
        $response = Http::withToken(env('PAYSTACK_SK_KEY'))->post('https://api.paystack.co/transferrecipient',[
            'type' => 'nuban',
            'name' => $account_name,
            'account_number' => $account_number,
            'bank_code' => $bank_code,
            'currency' => 'NGN'
        ]);

        if($response->status()==200 || $response->status() == 201){
            return response($response->body());
        }else{
            // dd($response->body());
            abort(500,'failed to verify account');
        }
    }

    public function create(Request $request){
        $input = $request->validate([
            'account_number' => 'required|min:10',
            'recipient_code' => 'required',
            'account_name' => 'required',
            'bank' => 'required',
            'bank_code' => 'required'
        ]);

        if($request->user()->account()->create($input)){
            return back()->with('msg','Bank Details Added successfully');
        }else{
            return back()->with('err',"Failed to Update bank details, please refresh this page and try again");
        }
    }
}
