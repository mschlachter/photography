<div class="card">
	<div class="card-header card-header-warning">
		<h4 class="card-title">Most Popular Images</h4>
		<p class="card-category">Most-viewed image pages over the past 7 days</p>
	</div>
	<div class="card-body table-responsive">
		<table class="table table-hover">
			<thead class="text-warning">
				<th>Rank</th>
				<th>Title</th>
				<th class="text-right">Views</th>
			</thead>
			<tbody id="mostPopularPagesList">
				<tr>
					<td colspan="3">Loading…</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@push('js')
<script>
	$(document).ready(function() {
    // get our data:
    $.ajax('{{ route('admin.dashboard.data.most-popular-images') }}', {
      success: function(data) {
      	let pagesHtml = $('<tbody>');
      	data.forEach(function(row, index) {
      		let rowHtml = $('<tr>');
      		rowHtml.append('<td>' + (index + 1) + '</td>');
      		rowHtml.append('<td><a href="' + row['url'] + '">' + row['title'].split('—')[0] + '</a></td>');
      		rowHtml.append('<td class="text-right">' + row['views'] + '</td>');
      		pagesHtml.append(rowHtml);
      	});
      	$('#mostPopularPagesList').html(pagesHtml.html());
      }
    });
  });
</script>
@endpush