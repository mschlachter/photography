@extends('layouts.app', ['activePage' => 'albums', 'titlePage' => __('Create Album')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('admin.albums.store') }}" autocomplete="off" class="form-horizontal">
            @csrf

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Create Album') }}</h4>
                <p class="card-category">{{ __('Album information') }}</p>
              </div>
              <div class="card-body ">
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
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-title">{{ __('Title') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('Title') }}" value="{{ old('title', '') }}" required="true" aria-required="true"/>
                      @if ($errors->has('title'))
                        <span id="title-error" class="error text-danger" for="input-title">{{ $errors->first('title') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-date">{{ __('Date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('date') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="input-date" type="date" placeholder="{{ __('date') }}" value="{{ old('date', today()) }}" required />
                      @if ($errors->has('date'))
                        <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection