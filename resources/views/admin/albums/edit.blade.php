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
        let tagInputs = [];

        document.querySelectorAll('.tags-input').forEach(function(tagInput) {
            let input = new Tagify(tagInput, {
                whitelist: {!! json_encode(App\Tag::all()->pluck('name')) !!},
                originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', '),
                dropdown: {
                    maxItems: 20,
                    enabled: 0,
                    closeOnSelect: false
                }
            });
            tagInputs.push(input);
        });

        $(document).on('submit', '.image-update-form', function(event) {
            event.preventDefault();

            let submitButton = $(this).find('[type=submit]');
            submitButton.prop('disabled', true);

            let container = $(this).closest('.image-form-container');

            $.ajax(this.action, {
                'type': 'POST',
                'data': new FormData(this),
                'success': function(data) {
                    container.html(data['edit-view']);
                    tagInputs.forEach(function(input) {
                        try {
                            input.settings.whitelist = data['tag-list'];
                        } catch {}
                    });
                    let input = new Tagify(container.find('.tags-input')[0], {
                        whitelist: data['tag-list'],
                        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', '),
                        dropdown: {
                            maxItems: 20,
                            enabled: 0,
                            closeOnSelect: false
                        }
                    });
                    tagInputs.push(input);
                    submitButton.prop('disabled', false);
                    $(window).trigger('resize');

                    $.notify({
                        icon: "image",
                        message: "Image was successfully saved."
                    },{
                        type: 'success',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                },
                'error': function(data) {
                    let error = data.status;
                    if(data.responseJSON) {
                        error = data.responseJSON.message;
                    } else if (data.responseText) {
                        error = data.responseText;
                    }

                    submitButton.prop('disabled', false);

                    if(data.responseJSON && data.responseJSON.errors) {
                        console.log(data.responseJSON.errors);
                    }

                    $.notify({
                        icon: "image",
                        message: "Error while saving image: " + error
                    },{
                        type: 'danger',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });

        $(document).on('submit', '.image-create-form', function(event) {
            event.preventDefault();

            let submitButton = $(this).find('[type=submit]');
            submitButton.prop('disabled', true);

            let container = $(this).closest('.image-form-container');

            $.ajax(this.action, {
                'type': 'POST',
                'data': new FormData(this),
                'success': function(data) {
                    let newContainer = container.clone();
                    newContainer.html(data['edit-view']);
                    container.before(newContainer);
                    tagInputs.forEach(function(input) {
                        try {
                            input.settings.whitelist = data['tag-list'];
                        } catch {}
                    });
                    let input = new Tagify(newContainer.find('.tags-input')[0], {
                        whitelist: data['tag-list'],
                        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(', '),
                        dropdown: {
                            maxItems: 20,
                            enabled: 0,
                            closeOnSelect: false
                        }
                    });
                    tagInputs.push(input);
                    submitButton.prop('disabled', false);
                    $(window).trigger('resize');

                    // Clear 'new image' inputs:
                    container.find('#input-file-new, #input-title-new, #input-alt-new, #input-tags-new').val('');
                    container.find('.fileinput.fileinput-exists').removeClass('fileinput-exists').addClass('fileinput-new');
                    tagInputs.filter(function(item) {return item.DOM.originalInput == document.querySelector('#input-tags-new')})[0].removeAllTags()

                    $.notify({
                        icon: "image",
                        message: "Image was successfully saved."
                    },{
                        type: 'success',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                },
                'error': function(data) {
                    let error = data.status;
                    if(data.responseJSON) {
                        error = data.responseJSON.message;
                    } else if (data.responseText) {
                        error = data.responseText;
                    }

                    submitButton.prop('disabled', false);

                    if(data.responseJSON && data.responseJSON.errors) {
                        console.log(data.responseJSON.errors);
                    }

                    $.notify({
                        icon: "image",
                        message: "Error while saving image: " + error
                    },{
                        type: 'danger',
                        timer: 4000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        }
                    });
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        })
    </script>
@endpush