<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Khoa;
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
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('tvu.email')->only('register');
    }

    /**
     * Show the application registration form with extra data
     */
    public function showRegistrationForm()
    {
        $khoas = Khoa::orderBy('ten_khoa')->get();
        return view('auth.register', compact('khoas'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[^@]+@st\\.tvu\\.edu\\.vn$/i', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ma_sv' => ['required', 'string', 'max:50'],
            'khoa' => ['nullable', 'string', 'max:255'],
            'ma_lop' => ['nullable', 'string', 'max:50'],
            'nganh' => ['nullable', 'string', 'max:255'],
            'anh_the' => ['nullable', 'file', 'image', 'max:2048'],
            'terms' => ['nullable', 'accepted'],
        ], [
            'email.regex' => 'Chỉ chấp nhận email sinh viên có đuôi @st.tvu.edu.vn',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Lưu ảnh thẻ nếu có tải lên
        $anhThePath = null;
        if (request()->hasFile('anh_the')) {
            $anhThePath = request()->file('anh_the')->store('avatars', 'public');
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'ma_sv' => $data['ma_sv'] ?? null,
            'ma_lop' => $data['ma_lop'] ?? null,
            'khoa' => $data['khoa'] ?? null,
            'nganh' => $data['nganh'] ?? null,
            'anh_the' => $anhThePath,
            'role' => 'student',
        ]);
    }
}
