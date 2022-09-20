<div id="crudEventPanel" class="collapse panel panel-default">
    <div class="panel-heading crud-event">Event</div>
    <div class="panel-body">
        <div class="col-sm-12">
            <form id="eventForm">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="start_date" class="col-sm-2 col-form-label">Start Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="start_date" name="startDate" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="repeat_on" class="col-sm-2 col-form-label">Repeat On:</label>
                    <div class="col-sm-10">
                        <select class="form-control col-sm-10" id="repeat_on" name="repeatOn">
                            <option value="D">Day</option>
                            <option value="W">Week</option>
                            <option value="M">Month</option>
                            <option value="Y">Year</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row repeat_on_week_dropdown repeat_on_option_dropdown hide">
                    <label for="repeat_on_week_dropdown" class="col-sm-2 col-form-label">Repeat Weekly:</label>
                    <div class="col-sm-10">
                        <select class="form-control col-sm-10" id="repeat_on_week_dropdown" name="repeatWeek">
                            <option value="">Select</option>
                            <option value="1">Sunday</option>
                            <option value="2">Monday</option>
                            <option value="3">Tuesday</option>
                            <option value="4">Wednesday</option>
                            <option value="5">Thursday</option>
                            <option value="6">Friday</option>
                            <option value="7">Saturday</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row repeat_on_month_dropdown repeat_on_option_dropdown hide">
                    <label for="repeat_on_week_dropdown" class="col-sm-2 col-form-label">Repeat Every Month:</label>
                    <div class="col-sm-10">
                        <select class="form-control col-sm-10" id="repeat_on_month_dropdown" name="repeatMonth">
                            <option value="">Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="panel panel-default">
                        <div class="panel-heading">End of event</div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label for="end_date" class="col-sm-4 col-form-label">By Date</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control" id="end_date" name="endDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 text-center"> OR </div>
                                <div class="col-sm-5">
                                    <div class="form-group row">
                                        <label for="number_of_occurrence" class="col-sm-4 col-form-label">By Occurrence</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="number_of_occurrence" name="endAfterOccurrences">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" id="eventId" name="id" />
                    <button type="button" id="submitEventBtn" class="btn btn-primary">Save</button>
                    <button type="button" id="cancelEventBtn" class="btn btn-primary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
