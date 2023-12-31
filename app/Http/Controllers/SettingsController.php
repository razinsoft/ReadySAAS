<?php

namespace App\Http\Controllers;

use App\Enums\DateFormat;
use App\Http\Requests\GeneralSettingsRequest;
use App\Http\Requests\MailSettingRequest;
use App\Models\GeneralSetting;
use App\Repositories\CurrencyRepository;
use App\Repositories\GeneralSettingRepository;

class SettingsController extends Controller
{
    public function generalSettings()
    {
        $currencies = CurrencyRepository::getAll();
        $generalSettings = GeneralSettingRepository::query()->latest()->first();
        $dateFormats = DateFormat::cases();

        $zones = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones[$key]['zone'] = $zone;
            $zones[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return view('settings.general', compact('generalSettings', 'zones', 'currencies', 'dateFormats'));
    }

    public function store(GeneralSettingsRequest $request, GeneralSetting $generalSetting)
    {
        if (app()->environment('local')) {
            return back()->with('error', 'This section is not available for demo version!');
        }
        GeneralSettingRepository::storeByRequest($request, $generalSetting);
        if (env('APP_TIMEZONE') != $request->timezone) {
            $this->setEnv('APP_TIMEZONE', $request->timezone);
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    public function mailSettings()
    {
        return view('settings.mail');
    }

    public function mailSettingsStore(MailSettingRequest $request)
    {
        cache()->flush();
        $environmentSet = array(
            'MAIL_MAILER' => 'smtp',
            'MAIL_HOST' => $request->host,
            'MAIL_PORT' => $request->port,
            'MAIL_FROM_ADDRESS' => $request->email_from,
            'MAIL_FROM_NAME' => $request->from_name,
            'MAIL_ENCRYPTION' => $request->encryption,
            'MAIL_USERNAME' => $request->username,
            'MAIL_PASSWORD' => $request->password,
        );

        foreach ($environmentSet as $key => $value) {
            $this->setEnv($key, $value);
        }

        return back()->with('message', 'Mail settings uploaded successfully');
    }

    public function setEnv($key, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            if ($key == 'MAIL_FROM_NAME' || $key == 'MAIL_FROM_ADDRESS') {
                file_put_contents($path, str_replace(
                    $key . '=' . '"' . env($key) . '"',
                    $key . '=' . "\"$value\"",
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, str_replace(
                    $key . '=' . env($key),
                    $key . '=' . $value,
                    file_get_contents($path)
                ));
            }
        }
    }
}
