<div class="card">
	<div class="card-header card-header-primary">
		<h4 class="card-title">Traffic Sources</h4>
		<p class="card-category">Where visitors to the site came from over the past 7 days</p>
	</div>
	<div class="card-body table-responsive">
		<table class="table table-hover">
			<thead class="text-warning">
				<th>Source / Medium</th>
				<th class="text-right">Sessions</th>
			</thead>
			<tbody id="sessionSourcesList">
				<tr>
					<td colspan="2">Loading…</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

@push('js')
<script>
	$(document).ready(function() {
    /* get our data: */
    $.ajax('{{ route('admin.dashboard.data.session-sources') }}', {
      success: function(data) {
      	let pagesHtml = $('<tbody>');
      	data.forEach(function(row, index) {
      		let rowHtml = $('<tr>');
      		rowHtml.append('<td>' + row['source_medium'] + '</td>');
      		rowHtml.append('<td class="text-right">' + row['sessions'] + '</td>');
      		pagesHtml.append(rowHtml);
      	});
      	$('#sessionSourcesList').html(pagesHtml.html());
      }
    });
  });
</script>
@endpush