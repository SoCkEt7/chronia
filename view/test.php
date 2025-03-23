<h1 class="mb-4">Test Cron Job</h1>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Test Results</h5>
        <div>
            <a href="index.php?page=list" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="alert <?php echo $result['exit_code'] === 0 ? 'alert-success' : 'alert-danger'; ?>">
            <strong>Exit Code:</strong> <?php echo $result['exit_code']; ?>
            <?php if ($result['exit_code'] === 0): ?>
                <i class="bi bi-check-circle-fill text-success"></i> Success
            <?php else: ?>
                <i class="bi bi-x-circle-fill text-danger"></i> Failed
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <h5>Command Output:</h5>
            <div class="p-3 bg-light rounded">
                <pre class="mb-0" style="max-height: 300px; overflow-y: auto;"><?php echo htmlspecialchars($result['output'] ?: 'No output'); ?></pre>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Schedule Information</h5>
            </div>
            <div class="card-body">
                <p class="mb-2">
                    <strong>Next 5 Scheduled Executions:</strong>
                </p>
                <ul class="list-group">
                    <?php
                    // In a real implementation, this would calculate actual next run times
                    $now = time();
                    for ($i = 1; $i <= 5; $i++):
                        $time = $now + ($i * 3600); // Placeholder: every hour
                    ?>
                        <li class="list-group-item">
                            <?php echo date('Y-m-d H:i:s', $time); ?>
                        </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="index.php?page=list" class="btn btn-outline-secondary">Back to List</a>
            <div>
                <a href="index.php?page=edit&id=<?php echo $id; ?>" class="btn btn-outline-primary">
                    <i class="bi bi-pencil"></i> Edit Job
                </a>
                <a href="index.php?page=test&id=<?php echo $id; ?>" class="btn btn-success">
                    <i class="bi bi-play"></i> Run Again
                </a>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="alert alert-info">
        <h5><i class="bi bi-info-circle"></i> Testing Information</h5>
        <p>
            This test executes your command in a controlled environment and captures the output and exit code.
            A successful exit code (0) indicates the command ran without errors.
        </p>
        <p>
            Testing a job does not affect its scheduled execution. Your job will still run according to its schedule.
        </p>
    </div>
</div>