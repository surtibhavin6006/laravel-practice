@extends('defaultLayout')

@section('content')
    <h1>Events</h1>
    <hr/>

    <div class="mb-10" style="margin-bottom: 10px;">
        <button id="eventToggleButton">+ Event</button>
    </div>

    <div class="showError alert alert-danger col-sm-12 hide" style="color:red;margin-bottom: 15px;"></div>
    <div class="showSuccess alert alert-success col-sm-12 hide" style="color:red;margin-bottom: 15px;"></div>

    @include('event.crudForm')

    <table class="table event-listing">
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

    <hr/>
    <div class="row event-history-div hide">
        <h1>Events History</h1>
        <table class="table event-history">
            <thead>
            <tr>
                <th scope="col">Executed At</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

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
                    }
                });
            },
            getEventHistoryByEventId : function (eventId) {
                event.common.showListingLoader();
                let getEventHistoryByIdURL = '{{ route('api.event.history',['id' => '#eventId']) }}';
                getEventHistoryByIdURL = getEventHistoryByIdURL.replace("#eventId",eventId);
                $.ajax({
                    url: getEventHistoryByIdURL,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        event.common.prepareHtmlFromJsonDataDisplayForEventHistory(data.data);
                        event.common.hideListingLoader();
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
                            },
                            greaterStart: "#start_date"
                        },
                        repeatOn : "required",
                        repeatWeek : {
                            required : function (ele) {
                                return $("#repeat_on").val() === 'W';
                            }
                        },
                        repeatMonth : {
                            required : function (ele) {
                                return $("#repeat_on").val() === 'M';
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
                                        <a class="eventHistoryClass" href="javascript:void(0);" data-id="`+data.id+`">
                                            <span class="glyphicon glyphicon-list"></span>
                                        </a>
                                        <a class="eventDeleteClass" href="javascript:void(0);" data-id="`+data.id+`">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>`;
                    });

                    event.common.hideListingLoader();

                    $(".event-listing tbody").html(html);
                },
                prepareHtmlFromJsonDataDisplayForEventHistory : function (jsonData) {

                    let html = '';
                    jsonData.forEach(function (data) {
                        html += `<tr>
                                    <td>`+data.executed_on+`</td>
                                </tr>`;
                    });

                    event.common.hideListingLoader();

                    $(".event-history tbody").html(html);
                    $(".event-history-div").removeClass('hide');
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
                    $(".event-listing tbody").html('');
                },
                setEditDataForEvent : function (data) {

                    $("#crudEventPanel > .crud-event").html('Event Edit - <b>'+data.title+'</b>');

                    $("#eventForm :input:not(:button)").each(function () {
                        $(this).val(data[$(this).attr('name')]);

                        if(
                            $(this).attr('name') != 'title'
                        ){
                            $(this).addClass('form-control-plaintext');
                            $(this).attr('readOnly',true);
                        }

                        if(
                            $(this).attr('name') == 'repeatOn' && data[$(this).attr('name')] == 'W'
                        ){
                            $(".repeat_on_week_dropdown").removeClass('hide');
                        }

                        if(
                            $(this).attr('name') == 'repeatOn' && data[$(this).attr('name')] == 'M'
                        ){
                            $(".repeat_on_month_dropdown").removeClass('hide');
                        }

                    });

                    $("#crudEventPanel").show();
                },
                getCurrentPage : function () {
                    let data = $('.currentPage > .page-link').data();
                    return data.pagenum;
                },
                formReset : function (form) {
                    $(form).trigger("reset");
                    $('#eventForm :input').removeAttr('readonly');
                    $(".showError").addClass('hide');
                    $(".repeat_on_option_dropdown").addClass('hide');
                    $("#crudEventPanel").hide();
                    $("#crudEventPanel > .crud-event").html('Event');
                }
            }
        }

        $(document).ready(function(){
            event.getAllEvent();

            $("#repeat_on").change(function () {
                $('.repeat_on_option_dropdown').addClass('hide');
                $('#repeat_on_week_dropdown').prop('selectedIndex',0);
                $('#repeat_on_month_dropdown').prop('selectedIndex',0);
                if($(this).val() === 'M'){
                    $('.repeat_on_month_dropdown').removeClass('hide');
                }else if($(this).val() === 'W'){
                    $('.repeat_on_week_dropdown').removeClass('hide');
                }
            });

            $("#submitEventBtn").on('click',function () {
                event.validateEvent($("#eventForm"));
            });

            $("#cancelEventBtn").on('click',function () {
                event.common.formReset($('#eventForm'));
            });

            $(".event-listing tbody").on('click','a.eventEditClass',function () {
                let data = $(this).data();
                event.getEventById(data.id);
            });

            $(".event-listing tbody").on('click','a.eventHistoryClass',function () {
                let data = $(this).data();
                event.getEventHistoryByEventId(data.id);
            });

            $(".event-listing tbody").on('click','a.eventDeleteClass',function () {
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

            jQuery.validator.addMethod("greaterStart", function (value, element, params) {
                return this.optional(element) || new Date(value) >= new Date($(params).val());
            },'Must be greater than start date.');

        });


    </script>
@endsection
