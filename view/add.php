<h1 class="mb-4">Add New Cron Job</h1>

<div class="card">
    <div class="card-body">
        <form action="index.php?page=add" method="post" id="addJobForm">
            <div class="mb-3">
                <label for="scheduleType" class="form-label">Schedule Type</label>
                <select class="form-select" id="scheduleType">
                    <option value="simple">Simple (User-friendly)</option>
                    <option value="advanced">Advanced (Crontab syntax)</option>
                    <option value="predefined">Predefined Templates</option>
                </select>
            </div>
            
            <!-- Simple Schedule Builder -->
            <div id="simpleScheduleBuilder" class="mb-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Schedule Builder</h5>
                    </div>
                    <div class="card-body">
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
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="command" class="form-label">Command</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="command" name="command" placeholder="e.g. /usr/bin/backup.sh">
                    <button class="btn btn-outline-secondary" type="button" id="browseCommand">
                        <i class="bi bi-folder2-open"></i> Browse
                    </button>
                </div>
                <div class="form-text">
                    Enter the full path to the command or script to execute
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="index.php?page=list" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Job</button>
            </div>
        </form>
    </div>
</div>