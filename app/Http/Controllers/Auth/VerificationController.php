<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user)
    {
        // check url signatured
        if (!URL::hasValidSignature($request)) {
            return response()->json([
                "errors" => [
                    "message" => "Invalid verification link or signature",
                ],
            ], 422);
        }

        // check if already verified
        $this->verifiedUser($user);

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json([
            "message" => "Email successfully verified",
        ], 200);

    }

    public function resend(Request $request)
    {
        $this->validate($request, [
            'email' => ['email', 'required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                "errors" => [
                    "email" => "No user could be found with this email address",
                ],
            ], 422);
        }

        // check if already verified
        $this->verifiedUser($user);

        $user->sendEmailVerificationNotification();

        return response()->json([
            "status" => "Verification link resent",
        ]);
    }

    private function verifiedUser($user)
    {
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                "errors" => [
                    "message" => "Email address already verified",
                ],
            ], 422);
        }
    }
}
