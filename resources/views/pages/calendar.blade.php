@extends('common.layout') @section('title') Calendrier @endsection


@section('scripts')

<script type="text/javascript"
	src="{{URL::asset('assets/js/dateformat.js')}}"></script>
<script type="text/javascript"
	src="{{URL::asset('assets/js/jquery-ui.min.js')}}"></script>
<script>


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
                    lieu: e.lieu.name,
                    asso: e.assos
                });
            });
        }
    });
    $('#calendar').fullCalendar({
        lang: 'fr',
        eventLimit: true, // allow "more" link when too many events
        events: retour,
        height: 1000,
        eventRender: function(event, element) {

            if(event.orga!="Autre"){
                element.css("background-color", event.asso.color);
                element.css("border-color", event.asso.color);
                element.css("color", event.asso.text_color);
            }
            
            element.attr('href', 'javascript:void(0);');
            element.click(function() {
                $("#startTime").html(moment(event.start).format('D/M à H:mm'));
                $("#endTime").html(moment(event.end).format('D/M à H:mm'));
                $("#eventInfo").html(event.description);
                $("#eventPlace").html(event.lieu);
                $("#eventOrg").html(event.orga);
                    
                $("#eventContent").dialog({ modal: true, title: event.title, width:350});
            });
    		    
        }
    });
};

</script>

@endsection 


@section('content')
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
