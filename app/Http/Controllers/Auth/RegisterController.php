<?php

namespace App\Http\Controllers\Auth;

use App\Helper\FlashMsg;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\KPBI;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Show the application registration form.
   *
   * @return \Illuminate\View\View
   */
  public function showRegistrationForm()
  {
    return view('home.register');
  }

  public function redirectTo()
  {
    $emailSentTo = session()->getOldInput('email_kaprodi');

    FlashMsg::add('success', __('global.flash.emailSent', ['email' => $emailSentTo]));

    return '/register';
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255', 'unique:users'],
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
      'name' => [
        'unique:users' => ':input sudah didaftarkan untuk akun prodi yang lain',
      ],
    ]);
  }

  /**
   * Create a new user instance and KPBI profile after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
    $newUser = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    $data = $data + ['user_id' => $newUser->id];

    KPBI::save_info($data, KPBI::FIRST_ATTEMPT);

    return $newUser;
  }
}
