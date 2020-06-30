<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = [
            'site_name' => config('settings.site_name', 'Photography | Author Name'),
            'title_pattern' => config('settings.title_pattern', ':pageTitle — :siteName'),
            'author_name' => config('settings.author_name', 'Author Name'),
            'prints_link' => config('settings.prints_link', ''),
            'enable_comments' => config('settings.enable_comments', ''),
            'default-header-image' => config('settings.default-header-image', ''),
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $setting = Setting::where(['key' => $validated['key']])->first();

        if ($setting && $validated['value']) {
            $setting->update($validated);
        } elseif (!$setting && $validated['value']) {
            Setting::create($validated);
        } elseif ($setting && !$validated['value']) {
            $setting->delete();
        }

        return back()->withStatus('Setting successfully updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }

    public function updateGoogleAnalyticsCredentials(Request $request)
    {
        $validated = $request->validate([
            'ga-credentials' => 'required|file|mimes:json',
        ]);
        $newCredentials = file_get_contents($validated['ga-credentials']->getRealPath());
        if(!($newCredentialJson = json_decode($newCredentials))) {
            return back()->withErrors([
                'ga-credentials' => 'Credentials file is not a valid JSON file',
            ]);
        }
        if(
            !($newCredentialJson->type ?? false) ||
            !($newCredentialJson->project_id ?? false) ||
            !($newCredentialJson->private_key_id ?? false) ||
            !($newCredentialJson->private_key ?? false) ||
            !($newCredentialJson->client_email ?? false) ||
            !($newCredentialJson->client_id ?? false) ||
            !($newCredentialJson->auth_uri ?? false) ||
            !($newCredentialJson->token_uri ?? false) ||
            !($newCredentialJson->auth_provider_x509_cert_url ?? false) ||
            !($newCredentialJson->client_x509_cert_url ?? false)
        ) {
            return back()->withErrors([
                'ga-credentials' => 'Credentials file is missing fields required for service account authentication',
            ]);
        }

        // Backup old credentials
        if(file_exists(base_path() . '/service-account-credentials.json')) {
            if (!is_dir(base_path() . '/service-account-credential-backups')) {
                mkdir(base_path() . '/service-account-credential-backups', 0777, true);
            }
            rename(
                base_path() . '/service-account-credentials.json',
                base_path() . '/service-account-credential-backups/service-account-credentials-' . now() . '.json'
            );
        }

        // Save new credentials
        move_uploaded_file(
            $validated['ga-credentials']->getRealPath(),
            base_path() . '/service-account-credentials.json'
        );

        return back()->with([
            'ga-credentials-status' => 'Service Account Credentials successfully updated'
        ]);
    }
}
