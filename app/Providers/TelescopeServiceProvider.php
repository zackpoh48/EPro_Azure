<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();

        Telescope::filter(function (IncomingEntry $entry) {
            if ($this->app->environment("local")) {
                return true;
            }

            return $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment("local")) {
            return;
        }

        Telescope::hideRequestParameters(["_token"]);

        Telescope::hideRequestHeaders([
            "cookie",
            "x-csrf-token",
            "x-xsrf-token",
        ]);
    }

    /**
     * Configure the Telescope authorization services.
     *
     * @return void
     */
    protected function authorization()
    {
        // $this->gate();
        Telescope::auth(function (Request $request) {
            $ip = $this->getIp();
            $isLocal = App::environment("local");
            $ipCheck = $ip == env("TELESCOPE_ALLOWED_IP_ADDRESS");
            if ($ip != env("TELESCOPE_ALLOWED_IP_ADDRESS")) {
                Log::info("Ip Addresses (1=Calculated,2=From env)", [
                    $ip,
                    env("TELESCOPE_ALLOWED_IP_ADDRESS"),
                ]);
            }
            return $isLocal || $ipCheck;
        });
    }

    public function getIp()
    {
        foreach (
            [
                "HTTP_CLIENT_IP",
                "HTTP_X_FORWARDED_FOR",
                "HTTP_X_FORWARDED",
                "HTTP_X_CLUSTER_CLIENT_IP",
                "HTTP_FORWARDED_FOR",
                "HTTP_FORWARDED",
                "REMOTE_ADDR",
            ]
            as $key
        ) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(",", $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (
                        filter_var(
                            $ip,
                            FILTER_VALIDATE_IP,
                            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                        ) !== false
                    ) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define("viewTelescope", function (User $user) {
            return in_array($user->email, [
                //
            ]);
        });
    }
}
