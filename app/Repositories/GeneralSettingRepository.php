<?php

namespace App\Repositories;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class GeneralSettingRepository extends Repository
{
    private static $path = '/settings';

    public static function model()
    {
        return GeneralSetting::class;
    }

    public static function storeByRequest(Request $request, $settings)
    {
        $siteLogoId = $settings->logo_id;
        if ($request->hasFile('site_logo')) {
            $siteLogo = (new MediaRepository())->updateOrCreateByRequest(
                $request->site_logo,
                self::$path,
                'Image',
                $settings->logo
            );
            $siteLogoId = $siteLogo->id;
        }

        $smallLogoId = $settings->small_logo_id;
        if ($request->hasFile('small_logo')) {
            $smallLogo = (new MediaRepository())->updateOrCreateByRequest(
                $request->small_logo,
                self::$path,
                'Image',
                $settings->smallLogo
            );
            $smallLogoId = $smallLogo->id;
        }

        $faviconId = $settings->fav_id;
        if ($request->hasFile('favicon')) {
            $favicon = (new MediaRepository())->updateOrCreateByRequest(
                $request->favicon,
                self::$path,
                'Image',
                $settings->favicon
            );
            $faviconId = $favicon->id;
        }

        $generalSettings = self::query()->updateOrCreate([
            'id' => $settings?->id ?? 0,
        ], [
            'site_title' => $request->site_title,
            'currency_id' => $request->currency_id,
            'currency_position' => $request->currency_position,
            'date_format' => $request->date_format,
            'date_with_time' => $request->date_with_time,
            'developed_by' => $request->developed_by,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'logo_id' => $siteLogoId,
            'small_logo_id' => $smallLogoId,
            'fav_id' => $faviconId,
            'direction' => $request->direction,
        ]);

        return $generalSettings;
    }

    public static function languageUpdate($lang)
    {
        $generalSettings = GeneralSettingRepository::query()->latest()->first();
        $update = self::update($generalSettings, [
            'lang' => $lang
        ]);
        return $update;
    }
}
