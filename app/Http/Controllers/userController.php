<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;


class userController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(user::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(user $user)
    {
        //
        $this->authorize('viewAny', $user);
        $users = user::with('roles')->withCount('permissions')->get();
        return response()->view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(user $user)
    {
        //
        $this->authorize('create', $user);
        $roles = Role::all();
        return response()->view('users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, user $user)
    {
        //
        $this->authorize('create', $user);
        $request->validate([
            'name' => 'required|string|min:5|max:30',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->symbols()
                    ->letters()
                    ->numbers()
                    ->uncompromised()
            ],
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'role-id' => 'nullable|string|exists:roles,id'
        ]);

        $user = new user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->location = $request->input('location');
        $user->email_verified_at =  now(); // <-- مباشرة بتعتبره موثوق

        $user->password = Hash::make($request->input('password'));
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->store('users', ['disk' => 'public']);
            $user->image = $imageName;
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

    public function editUserPermission(Request $request, user $user)
    {
        $this->authorize('editPermission', $user);
        $role = $user->roles->first(); // بافتراض أنه له دور واحد فقط
        if (!$role) {
            return redirect()->back()->with('error', 'المستخدم لا يمتلك دورًا.');
        }

        $rolePermissions = $role->permissions;
        $userPermissions = $user->permissions->pluck('id')->toArray(); // فقط الصلاحيات المباشرة
        if (count($userPermissions)) {
            foreach ($userPermissions as $userPermission) {
                foreach ($rolePermissions as $rolePermission) {
                    if (in_array($rolePermission->id, $userPermissions)) {
                        $rolePermission->setAttribute('assigned', true);
                    } else {
                        $rolePermission->setAttribute('assigned', false);
                    }
                }
            }
        }
        return response()->view('users.userPermission', ['user' => $user, 'role' => $role, 'rolePermission' => $rolePermissions, 'userPermission' => $userPermissions]);
    }
    public function updateUserPermission(Request $request, User $user)
    {
        $this->authorize('updatePermission', $user);
        $validator = Validator($request->all(), [
            'permission_id' => 'required|numeric|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

        $permission = Permission::findById($request->input('permission_id'));

        // نتحقق من الصلاحيات المباشرة فقط
        $hasDirectPermission = $user->permissions->contains('id', $permission->id);

        if ($hasDirectPermission) {
            $user->revokePermissionTo($permission);
        } else {
            $user->givePermissionTo($permission);
        }

        return response()->json(['status' => true, 'message' => 'Permission Updated']);
    }


    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        //
        // $this->authorize('update', $user);
        $roles = Role::all();
        $role = $user->roles()->first();  // الدور الي مختاره
        return response()->view('users.update', [
            'users' => $user,
            'roles' => $roles,
            'current_role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
        // $this->authorize('update', $user);
        $request->validate([
            'name' => 'required|string|min:5|max:30',
            'email' => 'required|email|exists:users,email',
            'mobile' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'role-id' => 'nullable|string|exists:roles,id'
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->location = $request->input('location');
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
            $user->syncRoles($role);
        } else {
            return redirect()->back()->with('error', 'الدور غير موجود');
        }
        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت التعديل بنجاح" : "لم يتم التعديل يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $this->authorize('delete', user::findOrFail($id));
        $user = User::findOrFail($id);
        // حذف الصورة من التخزين إذا كانت موجودة
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        // حذف المستخدم
        $deleted = $user->delete();
        return redirect()->back()->with([ //session بيرحع على نفس الواجهة وبيرجع
            'status' => $deleted,
            'icon' => $deleted ? 'success' : 'error',
            'message' =>  $deleted ? "تم حذف المستخدم بنجاح" : "لم يتم الحذف"
        ]);
    }

    public function showProfile(Request $request)
    {
        $user = Auth::user();
        $articles = article::where('user_id', '=', $user->id)->get();
        return response()->view('profile.profile', ['users' => $user, 'articles' => $articles]);
    }

    public function addUserRegister(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|min:5|max:30',
            'email' => 'required|email|min:5|max:30',
            'mobile' => 'required|string|max:20',
            'location' => 'required|string|max:100',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->symbols()
                    ->letters()
                    ->numbers()
                    ->uncompromised()
            ],
            'image' => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $user = new user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->mobile = $request->input('mobile');
        $user->location = $request->input('location');
        $user->password = Hash::make($request->input('password'));
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->store('users', ['disk' => 'public']);
            $user->image = $imageName;
        }
        $isSaved = $user->save();
        if ($isSaved) {
            // تعيين دور افتراضي بدون صلاحيات (مثلاً: public)
            $defaultRole = Role::where('name', 'users')->first();

            if ($defaultRole) {
                $user->assignRole($defaultRole);
            } else {
                return redirect()->back()->with('error', 'الدور الافتراضي غير موجود. تأكد من وجوده في قاعدة البيانات.');
            }
        }
        return redirect()->route('login')->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت الاضافة بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    public function cropImage(Request $request, User $user)
    {
        if ($request->hasFile('cropped_image')) {
            $image = $request->file('cropped_image');
            $imageName = 'users/' . Str::random(10) . '.jpg';
            Storage::disk('public')->put($imageName, file_get_contents($image));
            $user->image = $imageName;
            $user->save();

            return response()->json([
                'status' => true,
                'image_url' => asset('storage/' . $imageName)
            ]);
        }

        return response()->json(['status' => false], 400);
    }
}
