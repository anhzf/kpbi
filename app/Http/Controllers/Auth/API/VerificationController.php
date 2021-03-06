<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Email Verification Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling email verification for any
  | user that recently registered with the application. Emails may also
  | be re-sent if the user didn't receive the original email message.
  |
  */

  /**
   * Where to redirect users after verification.
   *
   * @var string
   */
  protected $redirectTo = '/profil-saya';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:api');
    $this->middleware('signed')->only('verify');
    $this->middleware('throttle:6,1')->only('verify', 'resend');
  }

  /**
   * Mark the authenticated user's email address as verified.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   *
   * @throws \Illuminate\Auth\Access\AuthorizationException
   */
  public function verify(Request $request)
  {
    if (!hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
      throw new AuthorizationException;
    }

    if (!hash_equals((string) $request->get('hash'), sha1($request->user()->getEmailForVerification()))) {
      throw new AuthorizationException;
    }

    if ($request->user()->hasVerifiedEmail()) {
      return $request->wantsJson()
        ? new Response('', 204)
        : redirect($this->redirectPath());
    }

    if ($request->user()->markEmailAsVerified()) {
      event(new Verified($request->user()));
    }

    if ($response = $this->verified($request)) {
      return $response;
    }

    return response()->json(['success' => true, 'message' => 'Akun anda telah berhasil diverifikasi!'], 202);
  }

  /**
   * The user has been verified.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return mixed
   */
  protected function verified(Request $request)
  {
    //
  }

  /**
   * Resend the email verification notification.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function resend(Request $request)
  {
    if ($request->user()->hasVerifiedEmail()) {
      return response()->json([
        'success' => true,
        'message' => 'Akun anda sudah terverifikasi'
      ], 202);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json([
        'success' => true,
        'message' => "Email telah dikirim ke {$request->user()->getEmailForVerification()}"
      ], 202);
  }
}
