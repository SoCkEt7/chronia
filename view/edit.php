<h1 class="mb-4">Edit Cron Job #<?php echo $entry['id']; ?></h1>

<div class="card">
    <div class="card-body">
        <form action="index.php?page=edit&id=<?php echo $entry['id']; ?>" method="post" id="editJobForm">
            <div class="mb-3">
                <label for="schedule" class="form-label">Cron Schedule</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="schedule" name="schedule" value="<?php echo htmlspecialchars($entry['schedule']); ?>">
                    <button class="btn btn-outline-secondary" type="button" id="scheduleBuilder">
                        <i class="bi bi-gear"></i> Builder
                    </button>
                </div>
                <div class="form-text" id="scheduleHelp">
                    Format: minute hour day month weekday (e.g. "0 * * * *" = hourly)
                </div>
            </div>
            
            <div class="mb-3">
                <label for="command" class="form-label">Command</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="command" name="command" value="<?php echo htmlspecialchars($entry['command']); ?>">
                    <button class="btn btn-outline-secondary" type="button" id="browseCommand">
                        <i class="bi bi-folder2-open"></i> Browse
                    </button>
                </div>
                <div class="form-text">
                    Enter the full path to the command or script to execute
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" <?php echo $entry['active'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="active">Active</label>
                </div>
                <div class="form-text">
                    When inactive, the job will remain in the crontab but won't execute
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="index.php?page=list" class="btn btn-outline-secondary">Cancel</a>
                <div>
                    <a href="index.php?page=test&id=<?php echo $entry['id']; ?>" class="btn btn-outline-success">
                        <i class="bi bi-play"></i> Test Run
                    </a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Schedule Builder Modal -->
<div class="modal fade" id="scheduleBuilderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Builder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Minute</label>
                        <select class="form-select schedule-part" data-part="minute">
                            <option value="*">Every minute (*)</option>
                            <option value="0">On the hour (0)</option>
                            <option value="15">Quarter past (15)</option>
                            <option value="30">Half past (30)</option>
                            <option value="45">Quarter to (45)</option>
                            <option value="0,15,30,45">Every quarter (0,15,30,45)</option>
                            <option value="0,30">Every half hour (0,30)</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="text" class="form-control mt-2 custom-input" data-for="minute" style="display:none;">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Hour</label>
                        <select class="form-select schedule-part" data-part="hour">
                            <option value="*">Every hour (*)</option>
                            <option value="0">Midnight (0)</option>
                            <option value="12">Noon (12)</option>
                            <option value="*/2">Every 2 hours (*/2)</option>
                            <option value="*/4">Every 4 hours (*/4)</option>
                            <option value="9-17">Business hours (9-17)</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="text" class="form-control mt-2 custom-input" data-for="hour" style="display:none;">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Day of Month</label>
                        <select class="form-select schedule-part" data-part="day">
                            <option value="*">Every day (*)</option>
                            <option value="1">First day (1)</option>
                            <option value="15">Middle of month (15)</option>
                            <option value="1,15">1st and 15th (1,15)</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="text" class="form-control mt-2 custom-input" data-for="day" style="display:none;">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Month</label>
                        <select class="form-select schedule-part" data-part="month">
                            <option value="*">Every month (*)</option>
                            <option value="1,4,7,10">Quarterly (1,4,7,10)</option>
                            <option value="1,7">Bi-annually (1,7)</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="text" class="form-control mt-2 custom-input" data-for="month" style="display:none;">
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Day of Week</label>
                        <select class="form-select schedule-part" data-part="weekday">
                            <option value="*">Every day (*)</option>
                            <option value="1-5">Weekdays (1-5)</option>
                            <option value="0,6">Weekends (0,6)</option>
                            <option value="1">Monday (1)</option>
                            <option value="2">Tuesday (2)</option>
                            <option value="3">Wednesday (3)</option>
                            <option value="4">Thursday (4)</option>
                            <option value="5">Friday (5)</option>
                            <option value="custom">Custom...</option>
                        </select>
                        <input type="text" class="form-control mt-2 custom-input" data-for="weekday" style="display:none;">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Preview</label>
                        <div class="input-group">
                            <span class="input-group-text">Cron Expression</span>
                            <input type="text" class="form-control" id="cronPreview" readonly>
                        </div>
                        <div class="form-text">
                            <span id="cronReadable">Every minute</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="applySchedule">Apply</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Schedule builder modal
    const scheduleBuilderModal = new bootstrap.Modal(document.getElementById('scheduleBuilderModal'));
    
    document.getElementById('scheduleBuilder').addEventListener('click', function() {
        scheduleBuilderModal.show();
    });
    
    // Schedule builder logic
    const scheduleParts = {
        minute: '*',
        hour: '*',
        day: '*',
        month: '*',
        weekday: '*'
    };
    
    // Parse existing schedule into parts (simplified)
    function parseSchedule() {
        const schedule = document.getElementById('schedule').value;
        const parts = schedule.split(' ');
        
        if (parts.length >= 5) {
            scheduleParts.minute = parts[0];
            scheduleParts.hour = parts[1];
            scheduleParts.day = parts[2];
            scheduleParts.month = parts[3];
            scheduleParts.weekday = parts[4];
        }
        
        // Update the selects to match the current schedule
        document.querySelectorAll('.schedule-part').forEach(function(select) {
            const part = select.dataset.part;
            const options = Array.from(select.options).map(option => option.value);
            
            if (options.includes(scheduleParts[part])) {
                select.value = scheduleParts[part];
            } else {
                select.value = 'custom';
                const customInput = document.querySelector(`.custom-input[data-for="${part}"]`);
                customInput.style.display = 'block';
                customInput.value = scheduleParts[part];
            }
        });
        
        updateCronPreview();
    }
    
    // Update the cron preview when schedule parts change
    document.querySelectorAll('.schedule-part').forEach(function(select) {
        select.addEventListener('change', function() {
            const part = this.dataset.part;
            const value = this.value;
            
            if (value === 'custom') {
                const customInput = document.querySelector(`.custom-input[data-for="${part}"]`);
                customInput.style.display = 'block';
                customInput.value = scheduleParts[part];
            } else {
                document.querySelector(`.custom-input[data-for="${part}"]`).style.display = 'none';
                scheduleParts[part] = value;
                updateCronPreview();
            }
        });
    });
    
    // Update when custom inputs change
    document.querySelectorAll('.custom-input').forEach(function(input) {
        input.addEventListener('input', function() {
            const part = this.dataset.for;
            scheduleParts[part] = this.value;
            updateCronPreview();
        });
    });
    
    // Update cron preview
    function updateCronPreview() {
        const cronExpression = `${scheduleParts.minute} ${scheduleParts.hour} ${scheduleParts.day} ${scheduleParts.month} ${scheduleParts.weekday}`;
        document.getElementById('cronPreview').value = cronExpression;
        
        // Update human-readable description (simplified)
        let readable = 'Custom schedule';
        
        if (cronExpression === '* * * * *') {
            readable = 'Every minute';
        } else if (cronExpression === '0 * * * *') {
            readable = 'Every hour, at the beginning of the hour';
        } else if (cronExpression === '0 0 * * *') {
            readable = 'Every day at midnight';
        }
        
        document.getElementById('cronReadable').textContent = readable;
    }
    
    // Apply schedule from builder to main form
    document.getElementById('applySchedule').addEventListener('click', function() {
        document.getElementById('schedule').value = document.getElementById('cronPreview').value;
        scheduleBuilderModal.hide();
    });
    
    // Initialize the schedule builder with current values
    parseSchedule();
});
</script>