@extends('layouts.app', ['activePage' => 'albums', 'titlePage' => __('Albums')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Albums</h4>
            <p class="card-category">Photos go into albums, and can also have tags</p>
          </div>
          <div class="card-body">
            <div class="text-right">
              <a href="{{ route('admin.albums.create') }}" class="btn btn-sm btn-primary">Add album</a>
            </div>
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Name
                  </th>
                  <th>
                    Images
                  </th>
                  <th>
                    Date
                  </th>
                  <th class="text-center">
                    Published
                  </th>
                  <th class="text-right">
                    Actions
                  </th>
                </thead>
                <tbody>
                    @foreach($albums as $album)
                  <tr>
                    <td>
                      <a class="font-weight-bold" href="{{ route('admin.albums.edit', compact('album')) }}">
                        {{ $album->title }}
                      </a>
                    </td>
                    <td>
                      {{ $album->images_count }}
                    </td>
                    <td>
                      {{ $album->date }}
                    </td>
                    <td class="text-center">
                      <form class="col-12 col-md-auto" id="form-publish-album" method="post" action="{{ route('admin.albums.updateIsActive', compact('album')) }}">
                          <div class="togglebutton">
                              @csrf
                              <input type="hidden" name="is_active" value="0">
                              <label class="text-nowrap mb-0">
                                  <input name="is_active" type="checkbox" value="1" @if($album->is_active) checked="" @endif class="input-publish-album">
                                  <span class="toggle"></span>
                                  <span class="sr-only">
                                    Publish Album
                                  </span>
                              </label>
                          </div>
                      </form>
                    </td>
                    <td class="td-actions text-right">
                        <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('admin.albums.edit', compact('album')) }}">
                          <i class="material-icons">edit</i>
                        </a>
                        <form class="d-inline" method="post" action="{{ route('admin.albums.destroy', compact('album')) }}" onsubmit="return confirm('Do you really want to delete this album?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-link">
                              <i class="material-icons">delete</i>
                            </button>
                        </form>
                    </td>
                  </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
              {!! $albums->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script type="text/javascript" src="{{ mix('js/admin/albums/index.js') }}"></script>
@endpush