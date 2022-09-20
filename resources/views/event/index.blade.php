@extends('defaultLayout')

@section('content')
    <h1>Events</h1>
    <hr/>

    <div class="mb-10" style="margin-bottom: 10px;">
        <button id="eventToggleButton">+ Event</button>
    </div>

    <div class="showError alert alert-danger col-sm-12 hide" style="color:red;margin-bottom: 15px;"></div>
    <div class="showSuccess alert alert-success col-sm-12 hide" style="color:red;margin-bottom: 15px;"></div>

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
                    <div class="form-group row repeat_on_week_dropdown hide">
                        <label for="repeat_on_week_dropdown" class="col-sm-2 col-form-label">Repeat On:</label>
                        <div class="col-sm-10">
                            <select class="form-control col-sm-10" id="repeat_on_week_dropdown" name="repeatWeek">
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
                    </div>
                </form>
            </div>
         </div>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
        </ul>
    </nav>

@endsection

@section('javascriptBlock')
    <script>
        var event = {
            getAllEvent : function (page){

                event.common.removeCurrentDataFromHtmlTable();
                event.common.showListingLoader();

                $.ajax({
                    url: '{{ route('api.event.list') }}',
                    type: 'GET',
                    data : {
                        page : page === undefined ? 1 : page
                    },
                    success: function(data) {
                        console.log(data);
                        event.common.prepareHtmlFromJsonDataDisplay(data.data);
                        event.common.preparePaginationAndDisplay(data.meta);
                    }
                });
            },
            getEventById : function (eventId) {
                event.common.showListingLoader();
                let getEventByIdURL = '{{ route('api.event.view',['id' => '#eventId']) }}';
                getEventByIdURL = getEventByIdURL.replace("#eventId",eventId);
                $.ajax({
                    url: getEventByIdURL,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        event.common.hideListingLoader();
                        event.common.setEditDataForEvent(data.data);
                        console.log(data);
                    }
                });
            },
            submitEvent: function (form) {

                let currentPage = event.common.getCurrentPage();

                let eventId = form.find("[name='id']").val();

                let url = '{{ route('api.event.create') }}';
                let type = 'POST';
                if(eventId){
                    url = '{{ route('api.event.update',['id' => '#eventId']) }}';
                    url = url.replace('#eventId',eventId);
                    type = 'PUT';
                }

                $.ajax({
                    url: url,
                    type: type,
                    data : form.serialize(),
                    dataType: 'json',
                    success: function(data) {
                        $('.showSuccess').html(' Saved!! ').removeClass('hide')
                        setTimeout(function() {
                            $('.showSuccess').html(' Saved!! ').addClass('hide')
                        },3000)
                        event.getAllEvent(currentPage);
                        event.common.formReset(form);
                    },
                    error: function(data, textStatus) {
                        let message = 'Something went wrong!!';

                        if(data.responseJSON.message !== undefined){
                            message = data.responseJSON.message;
                        }

                        $('.showError').html(message).removeClass('hide');
                    }
                });
            },
            validateEvent : function (form) {
                let $formValidate = form.validate({
                    onkeyup: false,
                    rules : {
                        title: "required",
                        startDate : {
                            required : true,
                            date: true
                        },
                        endDate : {
                            date : true,
                            required : function (ele) {
                                return $("#number_of_occurrence").val() === '';
                            }
                        },
                        repeatOn : "required",
                        repeatWeek : {
                            required : function (ele) {
                                return $("#repeat_on").val() === 'W';
                            }
                        },
                        endAfterOccurrences : {
                            required : function (ele) {
                                return $("#end_date").val() === '';
                            }
                        }
                    }
                });

                $formValidate.form();

                if(form.valid()){
                    event.submitEvent(form);
                }
            },
            deleteEventById : function (eventId) {
                event.common.showListingLoader();
                let delEventByIdURL = '{{ route('api.event.delete',['id' => '#eventId']) }}';
                delEventByIdURL = delEventByIdURL.replace("#eventId",eventId);
                $.ajax({
                    url: delEventByIdURL,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        let currentPage = event.common.getCurrentPage();
                        event.getAllEvent(currentPage);
                    }
                });
            },
            common : {
                prepareHtmlFromJsonDataDisplay : function (jsonData) {
                    let html = '';
                    jsonData.forEach(function (data) {
                        html += `<tr>
                                    <td>`+data.id+`</td>
                                    <td>`+data.title+`</td>
                                    <td>
                                        <a class="eventEditClass" href="javascript:void(0);" data-id="`+data.id+`">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <a class="eventDeleteClass" href="javascript:void(0);" data-id="`+data.id+`">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>`;
                    });

                    event.common.hideListingLoader();

                    $(".table tbody").html(html);
                },
                preparePaginationAndDisplay : function (jsonData) {

                    let pagination = ``;
                    let totalPage = jsonData.last_page;
                    let currentPage = jsonData.current_page;

                    for(let i=1;i<=totalPage;i++){

                        let pageItemClass = 'page-item';

                        // block for prev
                        if(i===1){

                            let prevPageItemClass = pageItemClass;
                            let prevPage = currentPage - 1;
                            if(currentPage === 1){
                                prevPageItemClass += ' disabled';
                                prevPage = 1;
                            }

                            pagination += `<li class="`+prevPageItemClass+`">
                                            <a class="page-link " href="javascript:void(0);" data-pagenum=`+(prevPage)+`>Previous</a>
                                        </li>`;

                        }


                        if(currentPage === i){
                            pageItemClass += ' currentPage disabled';
                        }


                        pagination += `<li class="`+pageItemClass+`">
                                            <a class="page-link" href="javascript:void(0);" data-pagenum=`+i+`>`+i+`</a>
                                       </li>`;


                        // block for next
                        if(i===totalPage){

                            let nextPage = currentPage + 1;
                            let nextPageItemClass = 'page-item';
                            if(currentPage === totalPage){
                                nextPageItemClass += ' disabled';
                                nextPage = totalPage;
                            }
                            pagination += `<li class="`+nextPageItemClass+`">
                                            <a class="page-link" href="javascript:void(0);" data-pagenum=`+(nextPage)+`>Next</a>
                                            </li>`;

                        }
                    }


                    $(".pagination").html(pagination);
                },
                hideListingLoader: function () {
                    $(".loader").hide();
                },
                showListingLoader: function () {
                    $(".loader").show();
                },
                removeCurrentDataFromHtmlTable : function () {
                    $(".table tbody").html('');
                },
                setEditDataForEvent : function (data) {

                    $("#crudEventPanel > .crud-event").html('Event Edit - <b>'+data.title+'</b>');

                    $("#eventForm :input").each(function () {
                        $(this).val(data[$(this).attr('name')])
                    });

                    $("#crudEventPanel").show();
                },
                getCurrentPage : function () {
                    let data = $('.currentPage > .page-link').data();
                    return data.pagenum;
                },
                formReset : function (form) {
                    $(form).trigger("reset");
                    $(".showError").addClass('hide');
                    $(".repeat_on_week_dropdown").hide();
                    $("#crudEventPanel").hide();
                    $("#crudEventPanel > .crud-event").html('Event');
                }
            }
        }

        $(document).ready(function(){
            event.getAllEvent();

            $("#repeat_on").change(function () {
                if($(this).val() === 'W'){
                    $('.repeat_on_week_dropdown').removeClass('hide');
                } else {
                    $('.repeat_on_week_dropdown').addClass('hide');
                }
            });

            $("#submitEventBtn").on('click',function () {
                event.validateEvent($("#eventForm"));
            });

            $(".table tbody").on('click','a.eventEditClass',function () {
                let data = $(this).data();
                event.getEventById(data.id);
            });

            $(".table tbody").on('click','a.eventDeleteClass',function () {
                if(confirm('Are you sure want to delete?') === true){
                    let data = $(this).data();
                    event.deleteEventById(data.id);
                }
            });

            $(".pagination").on("click",".page-item > .page-link",function () {
                let data = $(this).data();
                event.getAllEvent(data.pagenum);
            })

            $("#eventToggleButton").click(function () {
               $("#crudEventPanel").toggle();
            });

            $("#end_date").on('change',function() {
               $("#number_of_occurrence").val('');
            });

            $("#number_of_occurrence").on('change',function() {
               $("#end_date").val('');
            });



        });


    </script>
@endsection
