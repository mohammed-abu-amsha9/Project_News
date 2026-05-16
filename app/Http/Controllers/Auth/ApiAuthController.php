<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    //
    public function LoginPT(request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ]);
        if (!$validator->fails()) {
            $user = User::where('email', '=', $request->input('email'))->first();
            if (Hash::check($request->input('password'), $user->password)) {
                $token =  $user->createToken('User-' . $user->id); // توليد token وحفظه في بيانات المسجل
                $user->setAttribute('token', $token->accessToken);
                return response()->json(
                    ['status' => true, 'message' => 'Logged in successfully', 'user' => $user],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    ['status' => false, 'message' => 'Login failed, check credentials'],
                    Response::HTTP_BAD_REQUEST
                );
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function LoginPGCT(request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ]);
        if (!$validator->fails()) {
            try {
                $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'bBxIxye8SBAyYJXjQpSGaGPlmWvtbLAGMvybCYJP',
                    'username' => $request->input('email'),
                    'password' => $request->input('password'),
                    'scope' => '*',
                ]);
                $json = $response->json();
                if (array_key_exists('error', $json)) {
                    return response()->json(['status' => false, 'error' => $json['error'], 'message' => $json['message']], Response::HTTP_BAD_REQUEST);
                } else {
                    $user = User::where('email', '=', $request->input('email'))->first();
                    $user->setAttribute('token', $json['access_token']);
                    return response()->json(['status' => true, 'user' => $user]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    // لتسجيل الدخول اما برقم الجوال وكلمة المرور او الايميل وكلمة المرور
    public function Login(request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'prohibits:mobile|string',
            'mobile' => 'prohibits:email',
            'password' => 'required|string',
        ]);
        if (!$validator->fails()) {
            try {
                $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'bBxIxye8SBAyYJXjQpSGaGPlmWvtbLAGMvybCYJP',
                    'username' => $request->input('email'),
                    'password' => $request->input('password'),
                    'scope' => '*',
                ]);
                $json = $response->json();
                if (array_key_exists('error', $json)) {
                    return response()->json(['status' => false, 'error' => $json['error'], 'message' => $json['message']], Response::HTTP_BAD_REQUEST);
                } else {
                    $user = User::where('email', '=', $request->input('email'))->first();
                    $user->setAttribute('token', $json['access_token']);
                    return response()->json(['status' => true, 'user' => $user]);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function Logout(request $request)
    {
        $revoked = $request->user()->token()->revoke();
        return response()->json(
            ['status' => $revoked, "message" => $revoked ? "Logged out successfully" : "Logout failed"],
            $revoked ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

    public function changePassword(Request $request)
    {
        $validator = validator($request->all(), [
            'password' => 'required|string|current_password:api',
            'new_password' => ['required', 'string', 'confirmed', Password::min(3)
                ->letters()
                ->symbols()
                ->mixedCase()
                ->uncompromised()]
        ]);

        if (!$validator->fails()) {
            $request->user()->forceFill([
                'password' => Hash::make($request->input('new_password'))
            ]);
            $request->user()->save();
            return response()->json(
                ['status' => true, 'message' => 'Password changed successfully'],
                Response::HTTP_OK
            );
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function updateProfile(request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:30',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'role-id' => 'nullable|string|exists:roles,id'
        ]);

        $user = $request->user('api');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->location = $request->input('location');
        $user->email_verified_at =  now(); // <-- مباشرة بتعتبره موثوق
        if ($request->hasFile('image')) {
            if (!is_null($user->image)) {
                if (Storage::disk('public')->exists($user->image)) {
                    Storage::disk('public')->delete($user->image);
                }
            }
            $imageFile = $request->file('image');
            $name = $imageFile->store('users', ['disk' => 'public']);
            $user->image = $name;
        }
        $isSaved = $user->save();
        // بدل ما تستخدم findByName()
        $role = Role::find($request->input('role-id'));
        if ($role) {
            $user->assignRole($role);
        } else {
            return redirect()->back()->with('error', 'الدور غير موجود');
        }


        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت الاضافة بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }
}
