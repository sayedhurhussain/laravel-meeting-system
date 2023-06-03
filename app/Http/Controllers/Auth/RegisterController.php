<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Interfaces\RegisterRepositoryInterface;

class RegisterController extends Controller
{
    protected $userRepository;

    public function __construct(RegisterRepositoryInterface $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }
    /**
     * Show the registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->registerRepository->register($request);
        return redirect()->route('login')
            ->with('success', 'Registration successful. You can now log in.');
    }
}
