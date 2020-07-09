@extends('layouts.app', ['activePage' => 'albums', 'titlePage' => __('Edit Album')])

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify@3.11.1/dist/tagify.css" integrity="sha256-oyPFbWMktxbXwQRY8CjTboVuTKjZJ2V5EHKKxDrdnNc=" crossorigin="anonymous">
<style type="text/css">
    .tags-input {
        height: auto;
    }
</style>
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card ">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-12 col-md">
                                <h4 class="card-title">{{ __('Edit Album') }}</h4>
                                <p class="card-category">{{ __('Album information') }}</p>
                            </div>
                            <div class="col-12 col-md-auto d-flex align-items-center">
                                <a class="text-white py-2" href="{{ route('albums.show', compact('album')) }}" target="_blank">
                                    <span class="material-icons mr-2">launch</span>View on Site
                                </a>
                            </div>
                            <form class="col-12 col-md-auto" id="form-publish-album" method="post" action="{{ route('admin.albums.updateIsActive', compact('album')) }}">
                                <div class="togglebutton card card-body m-0 pl-0">
                                    @csrf
                                    <input type="hidden" name="is_active" value="0">
                                    <label class="text-primary text-nowrap mb-0">
                                        <input name="is_active" type="checkbox" value="1" @if($album->is_active) checked="" @endif class="input-publish-album">
                                        <span class="toggle"></span>
                                        Publish Album
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body ">
                        <form method="post" action="{{ route('admin.albums.update', compact('album')) }}" autocomplete="off" class="form-horizontal" id="albumInfoForm">
                            @csrf
                            @method('put')
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
                                        <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="input-title" type="text" placeholder="{{ __('Title') }}" value="{{ old('title', $album->title) }}" required="true" aria-required="true" />
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
                                        <input class="form-control{{ $errors->has('date') ? ' is-invalid' : '' }}" name="date" id="input-date" type="date" placeholder="{{ __('date') }}" value="{{ old('date', $album->date) }}" required />
                                        @if ($errors->has('date'))
                                        <span id="date-error" class="error text-danger" for="input-date">{{ $errors->first('date') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                        <button type="submit" form="albumInfoForm" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-plain">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title mt-0">Images</h4>
                        <p class="card-category">Add/edit/delete images here</p>
                    </div>
                    <div class="card-body">
                        @if (session('imageStatus'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('imageStatus') }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            @foreach($album->images as $image)
                            <div class="col-12 col-md-6 col-lg-3 image-form-container">
                                <x-admin.images.edit-component :image="$image"/>
                            </div>
                            @endforeach
                            <div class="col-12 col-md-6 col-lg-3 image-form-container">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="image-create-form" method="post" action="{{ route('admin.images.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="album_id" value="{{ $album->id }}">
                                            <div class="fileinput fileinput-new text-center w-100" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail img-raised">
                                                    <img src="{{ asset('material/img/image-placeholder.jpg') }}" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                                                <div>
                                                    <label class="btn btn-raised btn-round btn-default btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input class="d-none" type="file" name="file-new" id="input-file-new" />
                                                    </label>
                                                </div>
                                                @if ($errors->has('file-new'))
                                                <span id="file-error-new" class="error text-danger" for="input-file-new">{{ $errors->first('file-new') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('title-new') ? ' has-danger' : '' }}">
                                                <label for="input-title-new">{{ __('Title') }}</label>
                                                <input class="form-control{{ $errors->has('title-new') ? ' is-invalid' : '' }}" name="title-new" id="input-title-new" type="text" value="{{ old('title-new', '') }}" required="true" aria-required="true" />
                                                @if ($errors->has('title-new'))
                                                <span id="title-error-new" class="error text-danger" for="input-title-new">{{ $errors->first('title-new') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('alt-new') ? ' has-danger' : '' }}">
                                                <label for="input-alt-new">{{ __('Alt Text') }}</label>
                                                <textarea class="form-control{{ $errors->has('alt-new') ? ' is-invalid' : '' }}" name="alt-new" id="input-alt-new" type="text" required="true" aria-required="true">{{ old('alt-new', '') }}</textarea>
                                                @if ($errors->has('alt-new'))
                                                <span id="alt-error-new" class="error text-danger" for="input-alt-new">{{ $errors->first('alt-new') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('tags-new') ? ' has-danger' : '' }}">
                                                <label for="input-tags-new">{{ __('Tags') }}</label>
                                                <input class="form-control tags-input border-right-0 border-left-0 border-top-0{{ $errors->has('tags-new') ? ' is-invalid' : '' }}" name="tags-new" id="input-tags-new" type="text" placeholder="{{ __('Tags') }}" value="{{ old('tags-new') }}" />
                                                @if ($errors->has('tags-new'))
                                                <span id="tags-error-new" class="error text-danger" for="input-tags-new">{{ $errors->first('tags-new') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('date-new') ? ' has-danger' : '' }}">
                                                <label for="input-date-new">{{ __('Date') }}</label>
                                                <input class="form-control{{ $errors->has('date-new') ? ' is-invalid' : '' }}" name="date-new" id="input-date-new" type="date" value="{{ old('date-new', $album->date) }}" required="true" aria-required="true" />
                                                @if ($errors->has('date-new'))
                                                <span id="date-error-new" class="error text-danger" for="input-date-new">{{ $errors->first('date-new') }}</span>
                                                @endif
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify@3.11.1/dist/tagify.min.js" integrity="sha256-jGAErKzBJxTL0qIA/fFPvhNbj9vLi8hsNFule27y6cE=" crossorigin="anonymous"></script>
<script type="text/javascript">
    window.existingTags = @json(App\Tag::all()->pluck('name'));
</script>
<script type="text/javascript" src="{{ mix('js/admin/albums/edit.js') }}"></script>
@endpush