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
                    @foreach($settings as $key => $value)
                  <tr>
                    <td>
                      {{ $key }}
                    </td>
                    <td>
                      <form id="setting-{{ $key }}" action="{{ route('admin.settings.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="key" value="{{ $key }}">
                        <input class="w-100" type="text" name="value" value="{{ $value }}">
                      </form>
                    </td>
                    <td class="text-right">
                      <button type="submit" form="setting-{{ $key }}" class="btn btn-sm btn-primary">
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
    </div>
  </div>
</div>
@endsection