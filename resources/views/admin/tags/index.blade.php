@extends('layouts.app', ['activePage' => 'tags', 'titlePage' => __('Tags')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Tags</h4>
            <p class="card-category">Photos go into albums, and can also have tags</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th class="d-none">
                    Category
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Images
                  </th>
                  <th>
                    Date Created
                  </th>
                  <th class="text-right">
                    Actions
                  </th>
                </thead>
                <tbody>
                  @foreach($tags as $tag)
                  <tr>
                    <td class="d-none">
                      {{ optional($tag->category)->name }}
                    </td>
                    <td>
                      <a class="font-weight-bold" href="{{ route('admin.tags.edit', compact('tag')) }}">
                        {{ $tag->name }}
                      </a>
                    </td>
                    <td>
                      {{ $tag->images_count }}
                    </td>
                    <td>
                      {{ $tag->created_at->toDateString() }}
                    </td>
                    <td class="td-actions text-right">
                        <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('admin.tags.edit', compact('tag')) }}">
                          <i class="material-icons">edit</i>
                        </a>
                        <form class="d-inline" method="post" action="{{ route('admin.tags.destroy', compact('tag')) }}" onsubmit="return confirm('Do you really want to delete this tag?')">
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
              {!! $tags->links() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection