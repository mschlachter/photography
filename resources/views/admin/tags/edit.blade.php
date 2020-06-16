@extends('layouts.app', ['activePage' => 'tags', 'titlePage' => __('Edit Tag')])

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
                <form method="post" action="{{ route('admin.tags.update', compact('tag')) }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Edit Tag') }}</h4>
                            <p class="card-category">{{ __('Tag information') }}</p>
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
                                <label class="col-sm-2 col-form-label" for="input-name">{{ __('Name') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('name') }}" value="{{ old('name', $tag->name) }}" required="true" aria-required="true" />
                                        @if ($errors->has('name'))
                                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
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
                        <p class="card-category">Edit images here</p>
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
                            @foreach($tag->images as $image)
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
                                                <button type="submit" class="btn btn-primary">
                                                    Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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