<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Validator; //use Validator class 
use Hash;     //encryption
use App\Shop\Entity\User; //User Eloquent ORM Model
use Mail;

class UserAuthController extends Controller{
   
    //signUpPage
    public function signUpPage(){
        $binding = [
            'title' => 'SignUp',
        ];
        return view('auth.signUp', $binding);
    }

    //signUpProcess
    public function signUpProcess(){
        $input = request()->all(); //get all data
        var_dump($input); //依序輸出變數值與變數種類

        //validate-rule-array
        $rules = [
            'nickname'=> [
                'required',
                'max:50',
            ],

            'email'=> [
                'required',
                'max:150',
                'email', //email-format
            ],

            'password'=> [
                'required',
                'same:password_confirmation',
                'min:6',
            ],

            'password_confirmation'=> [
                'required',
                'min:6',
            ],

            'type'=> [
                'required',
                'in:G,A', //limit range
            ],
        ];

        $validator = Validator::make($input, $rules);
        if($validator->fails()){ //identify whether fail
            return redirect('/user/auth/sign-up')
                ->withErrors($validator)
                ->withInput(); //data remain
        }
        $input['password'] = Hash::make($input['password']);
        
        $Users = User::create($input); //use ORM create user
        
        //send mail
        $mail_binding = [
            'nickname' => $input['nickname']
        ];

        Mail::send('email.signUpEmailNotification', $mail_binding,
        function($mail) use ($input){
            $mail->to($input['email']);
            $mail->from('inky11308@gmail.com');
            $mail->subject('regist success! Welcome to shop-laravel!');
        });

        return redirect('/user/auth/sign-in'); //redirect to sign-in page
        
        exit;
    }

    //signInPage
    public function signInPage(){
        $binding = [
            'title' => 'SignIn',
        ];
        return view('auth.signIn', $binding);
    }

    //signInProcess
    public function signInProcess(){
        $input = request()->all();

        $rules = [
            'email'=> [
                'required',
                'max:150',
                'email',
            ],

            'password'=> [
                'required',
                'min:6',
            ],
        ];

        $validator = Validator::make($input, $rules);
        if($validator->fails()){
            return redirect('/user/auth/sign-in')
                ->withErrors($validator)
                ->withInput();
        }

        //retrieve user
        $User = User::where('email', $input['email'])->firstOrFail();
        //verify password
        $is_password_correct = Hash::check($input['password'], $User->password);

        if(!$is_password_correct){
            $error_message = [
                'msg' => [
                    'password not correct',
                ],
            ];
            return redirect('user/auth/sign-in')
                ->withErrors($error_message)
                ->withInput();
        }

        //session
        session()->put('user_id', $User->id);
        session()->put('type', $User->type);

        //導向原造訪頁/首頁
        return redirect()->intended('/');
    }

    //signOut
    public function signOut(){
        //remove session
        session()->forget('user_id');
        return redirect('/');
    }
}
?>