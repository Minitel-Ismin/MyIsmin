@extends('common.layout') @section('title') Calendrier @endsection


@section('scripts')

<script type="text/javascript"
	src="{{URL::asset('assets/js/dateformat.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>
<script>

var test;
document.onreadystatechange = function () {
    if(document.readyState != "complete")
        return;
    var retour = [];
    $.ajax({
        'async': false,
        'global': false,
        'url': "{{URL::to("/calendar/event")}}",
        'dataType': "json",
        'success': function (data) {
            $.each(data,function(i, e){
                if(e.assos){
                    var asso_name = e.assos.name;
                }else{
                    var asso_name = "Autre";
                }
                retour.push({
                    title: e.title,
                    start: e.start,
                    end  : e.end,
                    orga : asso_name,
                    description: e.description,
                    lieu: e.lieu.name
                });
            });
        }
    });
    $('#calendar').fullCalendar({
        lang: 'fr',
        eventLimit: true, // allow "more" link when too many events
        events: retour,
        height: 1000,
        defaultView: 'agendaWeek',
        eventRender: function(event, element) {

        element.append("<br/>Description: " + event.description);
            element.append("<br/><br/>Lieu: "+ event.lieu);
            element.append("<br/>Organisateur: " + event.orga);
           
    		    element.attr('href', 'javascript:void(0);');
    		    element.click(function() {
    		             $("#startTime").html(moment(event.start).format('D/M à H:MM'));
    		             $("#endTime").html(moment(event.end).format('D/M à H:MM'));
    		             $("#eventInfo").html(event.description);
    		             $("#eventPlace").html(event.lieu);
    		             $("#eventOrg").html(event.orga);
    		             
    		        	$("#eventContent").dialog({ modal: true, title: event.title, width:350});
    		        });
    		    
        }
    });
};

</script>

@endsection @section('content')
<link href="{{ URL::asset('assets/css/jquery-ui.css' )}}"
	rel="stylesheet">
<div id='calendar'></div>
<div id="eventContent" title="Event Details" style="display: none;">
	Début: <span id="startTime"></span><br> 
	Fin: <span id="endTime"></span><br>
	Description: <span id="eventInfo"></span><br>
	Lieu: <span id="eventPlace"></span><br>
	Organisateur: <span id="eventOrg"></span><br> 
</div>
@endsection
