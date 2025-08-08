<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style>
    .event-img{
        width:4rem;
        height:4rem;
        object-fit:cover;
        object-position:center center;
        border-radius: 8px;
    }
</style>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Event Attendance Management</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="20%">
					<col width="35%">
					<col width="20%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Event Title</th>
						<th>Description</th>
						<th>Date of The Event</th>
						<th>Total Attendees</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$qry = $conn->query("
						SELECT 
							el.*,
							COUNT(ea.id) as total_attendees
						FROM `event_list` el 
						LEFT JOIN `event_attendance` ea ON el.id = ea.event_id 
						GROUP BY el.id 
						ORDER BY el.date_created DESC
					");
					while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo htmlspecialchars($row['title']) ?></td>
							<td><?php echo strlen($row['description']) > 100 ? substr(htmlspecialchars($row['description']), 0, 100) . '...' : htmlspecialchars($row['description']) ?></td>
							<td><?php echo date("M d, Y h:i A", strtotime($row['date_created'])) ?></td>
							<td class="text-center">
                                <span class="badge badge-info"><?php echo $row['total_attendees'] ?></span>
                            </td>
							<td class="text-center">
								<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  	Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                </button>
				                <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_attendance" href="javascript:void(0)" data-id="<?= $row['id'] ?>" data-title="<?= htmlspecialchars($row['title']) ?>">
                                        <span class="fa fa-eye text-primary"></span> View Attendance
                                    </a>
                                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="./?page=attendance/attendance_report&event_id=<?= $row['id'] ?>">
                                        <span class="fa fa-file-alt text-success"></span> Generate Report
                                    </a>
				                </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceModalLabel">Event Attendance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="attendance-content">
                    <!-- Attendance content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function(){
		$('.view_attendance').click(function(){
			var event_id = $(this).attr('data-id');
			var event_title = $(this).attr('data-title');
			
			$('#attendanceModalLabel').text('Attendance for: ' + event_title);
			$('#attendance-content').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
			$('#attendanceModal').modal('show');
			
			// Load attendance data
			$.ajax({
				url: _base_url_ + "admin/attendance/view_attendance.php",
				method: "POST",
				data: {event_id: event_id},
				error: function(err) {
					console.log(err);
					$('#attendance-content').html('<div class="alert alert-danger">An error occurred while loading attendance data.</div>');
				},
				success: function(resp) {
					$('#attendance-content').html(resp);
					// Initialize DataTable for attendance data
					$('#attendanceTable').dataTable({
						columnDefs: [
							{ orderable: false, targets: [] }
						],
						order: [0, 'asc']
					});
					$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
				}
			});
		});
		
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: [5] }
			],
			order: [3, 'desc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');
	});
</script>
