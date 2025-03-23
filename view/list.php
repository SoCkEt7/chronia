<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Cron Jobs</h1>
    <a href="index.php?page=add" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add New Job
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div>
                <strong>All Jobs (<?php echo count($entries); ?>)</strong>
            </div>
            <div>
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (empty($entries)): ?>
            <div class="alert alert-info">
                No cron jobs found. <a href="index.php?page=add">Add your first job</a>.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Schedule</th>
                            <th>Command</th>
                            <th>Status</th>
                            <th>Last Run</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entries as $entry): ?>
                            <tr class="job-row <?php echo $entry['active'] ? 'job-active' : 'job-inactive'; ?>">
                                <td><?php echo $entry['id']; ?></td>
                                <td>
                                    <code><?php echo htmlspecialchars($entry['schedule']); ?></code>
                                    <button class="btn btn-sm btn-link schedule-info" data-schedule="<?php echo htmlspecialchars($entry['schedule']); ?>">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                </td>
                                <td class="text-truncate" style="max-width: 300px;">
                                    <?php echo htmlspecialchars($entry['command']); ?>
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input status-toggle" type="checkbox" 
                                            data-id="<?php echo $entry['id']; ?>" 
                                            <?php echo $entry['active'] ? 'checked' : ''; ?>>
                                        <label class="form-check-label">
                                            <?php echo $entry['active'] ? 'Active' : 'Inactive'; ?>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($entry['last_run']['time']): ?>
                                        <?php echo date('Y-m-d H:i:s', strtotime($entry['last_run']['time'])); ?>
                                        <span class="badge <?php echo $entry['last_run']['status'] ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $entry['last_run']['status'] ? 'Success' : 'Failed'; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">Never</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="index.php?page=edit&id=<?php echo $entry['id']; ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?page=test&id=<?php echo $entry['id']; ?>" class="btn btn-sm btn-outline-success" title="Test Run">
                                            <i class="bi bi-play"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger delete-job" data-id="<?php echo $entry['id']; ?>" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Schedule Info Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Schedule: <code id="scheduleString"></code></h6>
                
                <div class="mt-3">
                    <h6>Next 5 Executions:</h6>
                    <ul id="nextRunsList" class="list-group">
                        <li class="list-group-item text-center">
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            Loading...
                        </li>
                    </ul>
                </div>
                
                <div class="mt-3">
                    <h6>Human-Readable:</h6>
                    <p id="humanReadable" class="alert alert-info">
                        Analyzing schedule pattern...
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this cron job? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle handlers
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            const id = this.dataset.id;
            const active = this.checked;
            window.location.href = `index.php?page=toggle&id=${id}&active=${active ? 1 : 0}`;
        });
    });
    
    // Schedule info modal
    const scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));
    document.querySelectorAll('.schedule-info').forEach(function(button) {
        button.addEventListener('click', function() {
            const schedule = this.dataset.schedule;
            document.getElementById('scheduleString').textContent = schedule;
            
            // Reset the next runs list
            document.getElementById('nextRunsList').innerHTML = `
                <li class="list-group-item text-center">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Loading...
                </li>
            `;
            
            // Reset the human-readable text
            document.getElementById('humanReadable').textContent = 'Analyzing schedule pattern...';
            
            // Show the modal
            scheduleModal.show();
            
            // Fetch the next run times
            fetch(`index.php?page=api&action=next_runs&schedule=${encodeURIComponent(schedule)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let html = '';
                        data.next_runs.forEach(function(time) {
                            const date = new Date(time);
                            html += `
                                <li class="list-group-item">
                                    ${date.toLocaleString()}
                                </li>
                            `;
                        });
                        document.getElementById('nextRunsList').innerHTML = html;
                        
                        // Set human-readable text based on schedule pattern
                        // This is a simplified version - a real implementation would be more comprehensive
                        let humanReadable = '';
                        
                        if (schedule.startsWith('@')) {
                            // Special schedules
                            const specialMap = {
                                '@yearly': 'Once a year, at midnight on January 1st',
                                '@annually': 'Once a year, at midnight on January 1st',
                                '@monthly': 'Once a month, at midnight on the first day of the month',
                                '@weekly': 'Once a week, at midnight on Sunday',
                                '@daily': 'Once a day, at midnight',
                                '@hourly': 'Once an hour, at the beginning of the hour',
                                '@reboot': 'At system startup'
                            };
                            humanReadable = specialMap[schedule] || 'Special schedule';
                        } else {
                            // Parse standard cron format
                            const parts = schedule.split(' ');
                            if (parts.length >= 5) {
                                const min = parts[0];
                                const hour = parts[1];
                                const dom = parts[2];
                                const month = parts[3];
                                const dow = parts[4];
                                
                                if (min === '*' && hour === '*' && dom === '*' && month === '*' && dow === '*') {
                                    humanReadable = 'Every minute';
                                } else if (min === '0' && hour === '*' && dom === '*' && month === '*' && dow === '*') {
                                    humanReadable = 'Every hour, at the beginning of the hour';
                                } else if (min === '0' && hour === '0' && dom === '*' && month === '*' && dow === '*') {
                                    humanReadable = 'Every day at midnight';
                                } else {
                                    humanReadable = 'Custom schedule - see next execution times for details';
                                }
                            }
                        }
                        
                        document.getElementById('humanReadable').textContent = humanReadable;
                    }
                })
                .catch(error => {
                    document.getElementById('nextRunsList').innerHTML = `
                        <li class="list-group-item text-danger">
                            Failed to load execution times
                        </li>
                    `;
                    document.getElementById('humanReadable').textContent = 
                        'Could not analyze schedule pattern';
                });
        });
    });
    
    // Delete confirmation modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.querySelectorAll('.delete-job').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('confirmDelete').href = `index.php?page=delete&id=${id}`;
            deleteModal.show();
        });
    });
    
    // Status filter
    document.getElementById('statusFilter').addEventListener('change', function() {
        const value = this.value;
        const rows = document.querySelectorAll('.job-row');
        
        if (value === 'all') {
            rows.forEach(row => row.style.display = '');
        } else if (value === 'active') {
            rows.forEach(row => {
                row.style.display = row.classList.contains('job-active') ? '' : 'none';
            });
        } else if (value === 'inactive') {
            rows.forEach(row => {
                row.style.display = row.classList.contains('job-inactive') ? '' : 'none';
            });
        }
    });
});
</script>