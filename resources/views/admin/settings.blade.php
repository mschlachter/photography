@extends('layouts.app', ['activePage' => 'settings', 'titlePage' => __('Settings')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Settings</h4>
            <p class="card-category">Global settings for the website</p>
          </div>
          <div class="card-body">
            @if (session('status'))
            <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                  </button>
                  <span>{{ session('status') }}</span>
                </div>
              </div>
            </div>
            @endif
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <th>
                    Setting Name
                  </th>
                  <th>
                    Value
                  </th>
                  <th class="text-right">
                    Actions
                  </th>
                </div>
                <tbody>
                  @foreach($settings as $setting)
                  <tr>
                    <td>
                      <label for="input-setting-{{ $setting->key }}">{{ $setting->label }}</label>
                    </td>
                    <td>
                      <form id="setting-{{ $setting->key }}" action="{{ route('admin.settings.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="key" value="{{ $setting->key }}">
                        @if($setting->type == \App\Setting::TYPE_TEXTAREA)
                        <textarea id="input-setting-{{ $setting->key }}" class="w-100 px-2 py-1" name="value">{{ $setting->value }}</textarea>
                        @elseif($setting->type == \App\Setting::TYPE_CHECKBOX)
                        <input type="hidden" name="value" value="0">
                        <input id="input-setting-{{ $setting->key }}" type="checkbox" name="value" value="1" @if($setting->value) checked="" @endif>
                        @else
                        <input id="input-setting-{{ $setting->key }}" class="w-100" type="{{ $setting->type }}" name="value" value="{{ $setting->value }}">
                        @endif
                        {{-- To ensure this column takes an appropriate amount of space: --}}
                        <span style="visibility: collapse;height: 0;display: block;">{{ $setting->value }}</span>
                      </form>
                    </td>
                    <td class="text-right">
                      <button type="submit" form="setting-{{ $setting->key }}" class="btn btn-sm btn-primary">
                        Save
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Google Analytics Account Credentials</h4>
            <p class="card-category">Required for analytics-based metrics on the Dashboard</p>
          </div>
          <div class="card-body">
            @if (session('ga-credentials-status'))
            <div class="row">
              <div class="col-sm-12">
                <div class="alert alert-success">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                  </button>
                  <span>{{ session('ga-credentials-status') }}</span>
                </div>
              </div>
            </div>
            @endif
            <form action="{{ route('admin.settings.update-ga') }}" method="post" enctype="multipart/form-data">
              @csrf
              <p>
                <label for="client-account-credentials" class="d-block">
                  Service Account Credentials JSON file
                </label>
                <input id="client-account-credentials" type="file" name="ga-credentials" accept=".json,application/json"/>
                @if ($errors->has('ga-credentials'))
                <span id="client-account-credentials-error" class="error text-danger" for="client-account-credentials">{{ $errors->first('ga-credentials') }}</span>
                @endif
              </p>
              <button type="submit" class="btn btn-sm btn-primary">
                Save
              </button>
            </form>
            <h5 class="mt-4">
              How to obtain and setup a credentials file
            </h5>
            <ol>
              <li>
                <p>
                  <a href="https://www.google.com/analytics/web/" rel="noopener">
                    Create a Google Analytics account
                  </a>
                  and set up a domain property for the current url: {{ url('/') }}
                </p>
              </li>
              <li>
                <p>
                  Use the
                  <a href="https://console.developers.google.com/start/api?id=analytics&credential=client_key" rel="noopener">
                    Google Analytics API setup tool
                  </a>
                  to create a project in the Google API console, enable the API, and create credentials for a
                  <strong>Service Account</strong>.
                </p>
                <p>
                  You do not need to select any APIs or permissions in the setup tool; we will connect it to Google Analytics later.
                </p>
                <p>
                  When prompted for the Key type select <strong>JSON</strong>, and download the generated key.
                </p>
              </li>
              <li>
                <p>
                  Upload the credentials for the newly-created service account created in the previous step using the file input above.
                </p>
              </li>
              <li>
                <p>
                  Your service account will have a unique email address; add this email address as a user on your GA property (or for a specific view, if desired).
                </p>
                <p>
                  Once you've uploaded the credentials json file, the service account email address will appear here:
                  <strong>
                    {{
                      !file_exists($credentialsFile = base_path() . '/service-account-credentials.json') ? '' :
                      json_decode(
                        file_get_contents(
                          $credentialsFile
                        )
                        , true
                      )['client_email'] ?? ''
                    }}
                  </strong>
                </p>
              </li>
              <li>
                <p>
                  And you should be done! Confirm that the statistics on the <a href="{{ route('admin.dashboard') }}">Dashboard</a> match those on your Google Analytics property.
                </p>
              </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection