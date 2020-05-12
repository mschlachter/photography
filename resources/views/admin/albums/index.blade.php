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
                  <th class="text-right">
                    Actions
                  </th>
                </thead>
                <tbody>
                    @foreach($albums as $album)
                  <tr>
                    <td>
                      {{ $album->title }}
                    </td>
                    <td>
                      {{ $album->images_count }}
                    </td>
                    <td>
                      {{ $album->date }}
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