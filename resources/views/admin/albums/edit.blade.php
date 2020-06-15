@extends('layouts.app', ['activePage' => 'albums', 'titlePage' => __('Create Album')])

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
                <form method="post" action="{{ route('admin.albums.update', compact('album')) }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Edit Album') }}</h4>
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
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
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
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card">
                                    <x-picture :image="$image" class="card-img-top"></x-picture>
                                    <div class="card-body">
                                        <form method="post" action="{{ route('admin.images.update', compact('image')) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group{{ $errors->has('title-' . $image->id) ? ' has-danger' : '' }}">
                                                <label for="input-title-{{ $image->id }}">{{ __('Title') }}</label>
                                                <input class="form-control{{ $errors->has('title-' . $image->id) ? ' is-invalid' : '' }}" name="title-{{ $image->id }}" id="input-title-{{ $image->id }}" type="text" placeholder="{{ __('Title') }}" value="{{ old('title-' . $image->id, $image->title) }}" required="true" aria-required="true" />
                                                @if ($errors->has('title-' . $image->id))
                                                <span id="title-error-{{ $image->id }}" class="error text-danger" for="input-title-{{ $image->id }}">{{ $errors->first('title-' . $image->id) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('alt-' . $image->id) ? ' has-danger' : '' }}">
                                                <label for="input-alt-{{ $image->id }}">{{ __('Alt Text') }}</label>
                                                <input class="form-control{{ $errors->has('alt-' . $image->id) ? ' is-invalid' : '' }}" name="alt-{{ $image->id }}" id="input-alt-{{ $image->id }}" type="text" placeholder="{{ __('Alt Text') }}" value="{{ old('alt-' . $image->id, $image->alt) }}" required="true" aria-required="true" />
                                                @if ($errors->has('alt-' . $image->id))
                                                <span id="alt-error-{{ $image->id }}" class="error text-danger" for="input-alt-{{ $image->id }}">{{ $errors->first('alt-' . $image->id) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('tags-' . $image->id) ? ' has-danger' : '' }}">
                                                <label for="input-tags-{{ $image->id }}">{{ __('Tags') }}</label>
                                                <input class="form-control tags-input border-top-0 border-left-0 border-right-0{{ $errors->has('tags-' . $image->id) ? ' is-invalid' : '' }}" name="tags-{{ $image->id }}" id="input-tags-{{ $image->id }}" type="text" placeholder="{{ __('Tags') }}" value="{{ old('tags-' . $image->id, implode(', ', $image->tags->pluck('name')->toArray())) }}" />
                                                @if ($errors->has('tags-' . $image->id))
                                                <span id="tags-error-{{ $image->id }}" class="error text-danger" for="input-tags-{{ $image->id }}">{{ $errors->first('tags-' . $image->id) }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group{{ $errors->has('date-' . $image->id) ? ' has-danger' : '' }}">
                                                <label for="input-date-{{ $image->id }}">{{ __('Date') }}</label>
                                                <input class="form-control{{ $errors->has('date-' . $image->id) ? ' is-invalid' : '' }}" name="date-{{ $image->id }}" id="input-date-{{ $image->id }}" type="date" placeholder="{{ __('Date') }}" value="{{ old('date-' . $image->id, $image->date) }}" required="true" aria-required="true" />
                                                @if ($errors->has('date-' . $image->id))
                                                <span id="date-error-{{ $image->id }}" class="error text-danger" for="input-date-{{ $image->id }}">{{ $errors->first('date-' . $image->id) }}</span>
                                                @endif
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-danger mr-2" form="form-delete-{{ $image->id }}">
                                                    Delete
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                        <form id="form-delete-{{ $image->id }}" method="post" action="{{ route('admin.images.destroy', compact('image')) }}" onsubmit="return confirm('Are you sure you want to delete this image?')">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('admin.images.store') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="album_id" value="{{ $album->id }}">
                                            <div class="fileinput fileinput-new text-center w-100" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail img-raised">
                                                    <img src="https://wolper.com.au/wp-content/uploads/2017/10/image-placeholder.jpg" alt="...">
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
                                                <input class="form-control{{ $errors->has('alt-new') ? ' is-invalid' : '' }}" name="alt-new" id="input-alt-new" type="text" value="{{ old('alt-new', '') }}" required="true" aria-required="true" />
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
        document.querySelectorAll('.tags-input').forEach(function(tagInput) {
            new Tagify(tagInput, {
                whitelist: {!! json_encode(App\Tag::all()->pluck('name')) !!},
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', '),
                dropdown: {
                    maxItems: 20,
                    enabled: 0,
                    closeOnSelect: false
                }
            });
        });
    </script>
@endpush