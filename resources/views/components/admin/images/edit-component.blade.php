<div class="card">
    <x-picture :image="$image" class="card-img-top"></x-picture>
    <div class="card-body">
        <form class="image-update-form" method="post" action="{{ route('admin.images.update', compact('image')) }}">
            @csrf
            @method('PUT')
            <div class="form-group{{ $errors->has('title-' . $image->id) ? ' has-danger' : '' }}">
                <label for="input-title-{{ $image->id }}">{{ __('Title') }}</label>
                <input class="form-control{{ $errors->has('title-' . $image->id) ? ' is-invalid' : '' }}" name="title-{{ $image->id }}" id="input-title-{{ $image->id }}" type="text" placeholder="{{ __('Title') }}" value="{{ old('title-' . $image->id, $image->title) }}" required="true" aria-required="true">
                @if ($errors->has('title-' . $image->id))
                <span id="title-error-{{ $image->id }}" class="error text-danger" for="input-title-{{ $image->id }}">{{ $errors->first('title-' . $image->id) }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('alt-' . $image->id) ? ' has-danger' : '' }}">
                <label for="input-alt-{{ $image->id }}">{{ __('Alt Text') }}</label>
                <textarea class="form-control{{ $errors->has('alt-' . $image->id) ? ' is-invalid' : '' }}" name="alt-{{ $image->id }}" id="input-alt-{{ $image->id }}" type="text" placeholder="{{ __('Alt Text') }}" required="true" aria-required="true">{{ old('alt-' . $image->id, $image->alt) }}</textarea>
                @if ($errors->has('alt-' . $image->id))
                <span id="alt-error-{{ $image->id }}" class="error text-danger" for="input-alt-{{ $image->id }}">{{ $errors->first('alt-' . $image->id) }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('tags-' . $image->id) ? ' has-danger' : '' }}">
                <label for="input-tags-{{ $image->id }}">{{ __('Tags') }}</label>
                <input class="form-control tags-input border-top-0 border-left-0 border-right-0{{ $errors->has('tags-' . $image->id) ? ' is-invalid' : '' }}" name="tags-{{ $image->id }}" id="input-tags-{{ $image->id }}" type="text" placeholder="{{ __('Tags') }}" value="{{ old('tags-' . $image->id, implode(', ', $image->tags->pluck('name')->toArray())) }}">
                @if ($errors->has('tags-' . $image->id))
                <span id="tags-error-{{ $image->id }}" class="error text-danger" for="input-tags-{{ $image->id }}">{{ $errors->first('tags-' . $image->id) }}</span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('date-' . $image->id) ? ' has-danger' : '' }}">
                <label for="input-date-{{ $image->id }}">{{ __('Date') }}</label>
                <input class="form-control{{ $errors->has('date-' . $image->id) ? ' is-invalid' : '' }}" name="date-{{ $image->id }}" id="input-date-{{ $image->id }}" type="date" placeholder="{{ __('Date') }}" value="{{ old('date-' . $image->id, $image->date) }}" required="true" aria-required="true">
                @if ($errors->has('date-' . $image->id))
                <span id="date-error-{{ $image->id }}" class="error text-danger" for="input-date-{{ $image->id }}">{{ $errors->first('date-' . $image->id) }}</span>
                @endif
            </div>
            <div class="text-center">
                <button type="submit" form="form-image-delete-{{ $image->id }}" class="btn btn-danger">
                    Delete
                </button>
                <button type="submit" class="btn btn-primary">
                    Save
                </button>
            </div>
        </form>
        <form method="post" action="{{ route('admin.images.destroy', compact('image')) }}" id="form-image-delete-{{ $image->id }}" class="d-none form-image-delete">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

@if(!config('image-delete-handler-added', false) && !config()->set('image-delete-handler-added', true))
@push('js')
<script type="text/javascript">
    $(document).on('submit', '.form-image-delete', function(event) {
        event.preventDefault();
        if(!confirm('Do you really want to delete this image?')) {
            return false;
        }

        let container = $(this).closest('.image-form-container');

        $.ajax(this.action, {
            'type': 'POST',
            'data': new FormData(this),
            'success': function(data) {
                container.remove();

                $.notify({
                    icon: "image",
                    message: data.message
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

                if(data.responseJSON && data.responseJSON.errors) {
                    console.log(data.responseJSON.errors);
                }

                $.notify({
                    icon: "image",
                    message: "Error while deleting image: " + error
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
</script>
@endpush
@endif