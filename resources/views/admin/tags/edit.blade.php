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
                                <x-admin.images.edit-component :image="$image"/>
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