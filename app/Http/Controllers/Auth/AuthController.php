<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\changePassword;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password as FacadesPassword;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //
    public function showLogin()
    {
        return response()->view('auth.login');
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'remember_me' => 'nullable|in:on,off'
        ]);
        if ($validation) {
            Auth::guard()->attempt($request->only(['email', 'password']), $request->has('remember'));
            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $guard = session('guard');
        auth($guard)->logout();
        $request->session()->invalidate();
        session()->remove('session');
        return redirect()->route('login');
    }

    public function editPassword()
    {
        $user = auth()->user();
        return response()->view('auth.changePassword',['user', $user]);
    }

    public function updatePassword(Request $request)
    {
        $validation = $request->validate([
            'old-password' => ['required', 'string', 'current_password'], // لاني بستخدم role
            'new-password' => [
                'required', 'string' ,'confirmed',
                Password::min(8)
                ->symbols()
                ->letters()
                ->numbers()
                ->uncompromised()
            ],
        ]);

        if($validation){
            $request->user()->update([
                $request->user()->password = Hash::make($request->input('new-password')),
                $request->user()->password_changed_at = now(),
            ]);
            Mail::to($request->user())->send(new changePassword($request->user()));
            return redirect()->route('home')->with([
                'status'=> true,
                'icon' => true ? 'success' : 'error',
                'message' => true ? 'تم تغيير كلمة المرور' : ''
            ]);
        }else{
            return redirect()->back()->with([
                'status' => false,
                'icon' => false ? 'error' : '',
                'message' => false ? 'لم يتم تغيير كلمة المرور يرجى التحقق من البيانات' : ''
            ]);
        }
    }

    // فتح واجهة نسيان كلمة المرور
    public function forgotPassword()
    {
        return response()->view('auth.forgotPassword');
    }

    // ارسال ايميلك
    public function sendResetEamil(request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validation) {
            $status = FacadesPassword::sendResetLink($request->only('email'));
            return $status == FacadesPassword::RESET_LINK_SENT
            ? redirect()->back()->with([
                'status' => true,
                'icon' => true ? 'success' : '',
                'message' => true ? __($status) : ''
            ])
            : redirect()->back()->with([
                'status' => false,
                'icon' => false ? 'error' : '',
                'message' => false ? __($status) : ''
            ]);
        }
    }

    //  في الايميل المرسل في زر في هاد الدالة بتحولني على واجهة تغيير كلمة المرور
    public function showResetPassword(Request $request , $token)
    {
        return response()->view('auth.recoverPassword', [
            'token' => $token,
            'email' => $request->input('email'),
        ]);
    }

    // تغيير كلمة المرور
    public function resetPassword(Request $request)
    {
        $validation = $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:password_reset_tokens,email',
            'password' => ['required','string','confirmed',
                Password::min(8)
                ->symbols() // على الاقل رمز واحد
                ->letters() // حرف واحد
                ->numbers() // رقم واحد
                ->mixedCase() // حرف صغير وحرف كبير
                ->uncompromised() // ابعد عن الكلمات الضعيفة
            ],
        ]);

        if($validation){
            $status = FacadesPassword::reset($request->only(['email','token','password','password_confirmation']),function($user, $password) {
                $user->forceFill(['password' => Hash::make($password)]);
                $user->save();
                event(new PasswordReset($user));
            });
            return $status == FacadesPassword::PASSWORD_RESET
            ? redirect()->route('login')->with([
            'status'=> true,
            'icon' => true ? 'success' : 'error',
            'message' =>  true ? "تمت تعيين كلمة مرور بنجاح قم بتسجيل الدخول" : "لم يتم التعديل يرجى التحقق من البيانات"
            ])
            : redirect()->back()->with([
                'status' => false,
                'icon' => false ? 'error' : 'success',
                'message' => false ? __($status) : ''
            ]);
        } else {
            return redirect()->back()->with([
                'status' => false,
                'icon' => false ? 'error' : 'success',
                'message' => false ? '-----' : ''
            ]);
        }
    }

    public function registerUser()
    {
        return response()->view('auth.register');
    }

    // توجيه على صفحة ارسال تفعيل الايميل
    public function verificationNotice()
    {
        return response()->view('auth.emailverification');
    }

     // ارسال تفعيل الايميل
    public function verificationRequest(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return redirect()->back()->with([
            'status' => true,
            'icon' => true ? 'success' : '',
            'message' => true ? "Verification email sent successfully" : ''
        ]);
    }

    // بقيمة email_verified_at تعبئة عمود
    public function verificationVerify(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();
        return redirect()->route('home')->with([
            'status' => true,
            'icon' => true ? 'success' : '',
            'message' => true ? "تم تفعيل الايميل" : ''
        ]);;
    }
}
