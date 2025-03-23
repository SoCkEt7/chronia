<h1 class="mb-4">Dashboard</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h5 class="card-title">Active Jobs</h5>
                <p class="display-4"><?php echo $active_count; ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h5 class="card-title">Total Jobs</h5>
                <p class="display-4"><?php echo $total_count; ?></p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <h5 class="card-title">System Status</h5>
                <p class="display-6 text-success">
                    <i class="bi bi-check-circle-fill"></i> Running
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Upcoming Jobs</h5>
            </div>
            <div class="card-body">
                <?php if (empty($upcoming_jobs)): ?>
                    <p class="text-center text-muted">No upcoming jobs scheduled</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Command</th>
                                <th>Next Run</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($upcoming_jobs as $job): ?>
                                <tr>
                                    <td><?php echo $job['id']; ?></td>
                                    <td class="text-truncate" style="max-width: 400px;">
                                        <?php echo htmlspecialchars($job['command']); ?>
                                    </td>
                                    <td>
                                        <?php echo date('Y-m-d H:i:s', strtotime($job['next_run'])); ?>
                                        <small class="text-muted">
                                            (<?php echo $this->timeAgo(strtotime($job['next_run'])); ?>)
                                        </small>
                                    </td>
                                    <td>
                                        <a href="index.php?page=edit&id=<?php echo $job['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="index.php?page=test&id=<?php echo $job['id']; ?>" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-play"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Helper method for time ago display
function timeAgo($timestamp) {
    $difference = time() - $timestamp;
    
    if ($difference < 0) {
        if ($difference > -60) {
            return 'in less than a minute';
        }
        if ($difference > -3600) {
            return 'in ' . ceil(-$difference / 60) . ' minutes';
        }
        if ($difference > -86400) {
            return 'in ' . ceil(-$difference / 3600) . ' hours';
        }
        if ($difference > -604800) {
            return 'in ' . ceil(-$difference / 86400) . ' days';
        }
        return 'in ' . date('M j', $timestamp);
    }
    
    return ''; // In the past
}
?>