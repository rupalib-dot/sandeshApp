<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->orWhere('mobile', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->block_status == config('constant.STATUS.UNBLOCK')) {
                    return $user;
                } else {
                    throw ValidationException::withMessages([
                        Fortify::username() => "Your Account is Blocked. Please Contact Admin",
                    ]);
                }

            }

            // Multi Role Check for future scenario
            //            if ($user && in_array($user->status_id, [1,2,3])) {
            //                if (Hash::check($request->password, $user->password)) {
            //                    return $user;
            //                }
            //            }
            //            else {
            //                throw ValidationException::withMessages([
            //                    Fortify::username() => "Username not found or account is inactive. Please check your username.",
            //                ]);
            //            }

        });

    }
}
