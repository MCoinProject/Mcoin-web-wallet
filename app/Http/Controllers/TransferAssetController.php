<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use stdClass;
use Validator;
use JWTAuth;

use App\TransferAsset;
use App\Jobs\SendEmail;

class TransferAssetController extends Controller
{   
    public function getTransactionHistories(Request $request)
    {
        $response = new stdClass();

        $user = JWTAuth::parseToken()->authenticate();
        $dashboardCtrl = new DashboardController();

        $transfers = TransferAsset::orWhere('sender_address', $user->wallet->address)
        ->orWhere('receiver_address', $user->wallet->address)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        foreach ($transfers as $key => $transfer) {
            if($user->wallet->address == $transfer->receiver_address){
                $transfer->type = "receive";
            } else {
                $transfer->type = "transfer";
            }
        }

        $response->success = true;
        $response->transaction = $transfers;

        return response()->json($response);
    }

    /*
     *  Transfer Asset Function
     */
    public function transferAset(Request $request)
    {
    	$response = new stdClass();

        if(Auth::user()) {
            $user = Auth::user();
        } else {
            $user = JWTAuth::parseToken()->authenticate();
        }

    	///validate received data according to necessity
    	$validator = Validator::make($request->all(), [ 
    	    'address' => 'required|max:255',
    	    'amount' => 'required|numeric|min:0.001',
    	    'email' => 'required|email',
    	]);

    	// If fails, throws error message
    	if ($validator->fails()) 
    	{
    	    $message = $validator->errors();
    	    $success = false;
    	} 
    	else 
    	{  
            // If Balance is not sufficient
            if($user->max_transfer > 0 && $user->max_transfer > $request->amount) {
                
                // Create random code to be append to email
                $code = str_random(20);

                $newTransferAsset = TransferAsset::create([
                    'user_id' => $user->id,
                    'sender_address' => $user->wallet->address,
                    'receiver_address' => $request->address,
                    'amount' => $request->amount,
                    'target_email' => $request->email,
                    'code' => $code,
                    'status' => 'pending',
                ]);

                // If transfer success
                if($newTransferAsset) {
                    $message = "A confirmation link was sent to your email. Please click on the link to proceed.";
                    $success = true;

                    // Send email accordint to parameter passed
                    // dispatch(new SendEmail($user, $request->amount, $request->address, $code, null, 'transfer'));

                } else {
                    $message = "Transfer asset failed";
                    $success = false;
                }
            } else {
                $message = "Insufficient Balance! </br> Your current balance is <strong>".$user->getTotalBalance()." ETP</strong>";
                $success = false;
            }        
    	}

        // Return response value
    	$response->message = $message;
    	$response->success = $success;

    	return response()->json($response);
    }

    /*
     * Validate Transfer Function
     */
    public function validateTransfer(Request $request)
    {
        // Assign user's transfer code into variable
        $transfer = TransferAsset::where('code', $request->txn)->first();

        $res = 0;
        $message = "Invalid code!";
        $success = false;

        // If transfer exist and not yet succeed
        if($transfer && $transfer->status != 'success'){
            $res = TransferAsset::where('id', $transfer->id)->update(['status' => 'success']);
        } else {
            $res = 2;
        }

        if($res == 1){
            $success = true;
            $message = "Transfer successful!";

            // Send email accordint to parameter passed
            dispatch(new SendEmail($transfer->user, $transfer->amount, null, null, $transfer->target_email, 'receive'));

        } else if ($res == 2) {
            $message = "Transfer have been validated!";
        }

        // Return data and display to the page
        $page_settings = array(
            'success' => $success,
            'message' => $message,
        );

        return view('results.transfer')->with($page_settings);
    }
}
