
$( ".sortable" ).sortable({
	appendTo:"body",
	dropOnEmpty:"false",
	start : function (e,ui)
	 {
	 	ui.placeholder.width(172);
	 	ui.placeholder.height(42);
	 	ui.placeholder.css({visibility: 'visible', border : '1px solid black'});
	 	//alert();
	 },
	 receive : function(e,ui)
	 {
	 }
});

$( "#card-stats" ).sortable({
	appendTo:"body",
	dropOnEmpty:"false",
	cancel: "#listCreateList",
	 update : function(e,ui)
	 {

	 }
});
$("#card-stats").disableSelection();
$( ".dragable" ).draggable({
	appendTo :"body",
	helper:"clone",
	grid: [1, 1],
	revert:false,
	connectToSortable:".sortable",
	start: function(e, ui)
	 {
	  var draggableId = e.target.id;
	  var width = $("#"+draggableId).css("width");
	  var height = $("#"+draggableId).css("height");
	  $(ui.helper).css("width",172);
	  $(ui.helper).css("height",height);
	 },
	 stop : function (e,ui)
	 {
	 }
});
$('#listCreateList').prop('onclick',null).off('click');
$('#listCreateList').on('click', function() {
		//alert("klik + "+ cardId +" owner : "+owner);
		//var href = $(this).attr("href");
		$("#modalcreatelist").openModal();
	});

$(document).ready(function() {
    var gabung = '<div class="dragable cDrag'+'Dynamic'+' cardUser'+"Departure"+'" id="cDrag'+'Dynamic'+'" style="width:100%;height:100%;">';
	gabung		+= '<a id="card'+'Dynamic'+'" href="javascript:void(0);" class="aCardUserLabel" onclick="">';
	gabung 		+= '<div class="card-action" style="background-color:white;color:black;border-radius:5px;margin-top:8px;">';
	gabung 		+= '<div class="row cardUserLabel" id="labelCard'+'Dynamic'+'" style="margin:auto;">';
	gabung 		+= '</div>'
	gabung 		+= '<div class="left-align black-text" style="word-wrap:break-word;" id="cardTitle'+'Dynamic'+'">'+"Dynamic"+'</div>';
	gabung 		+= '</div>';
	gabung 		+= '</a>';
	gabung 		+= '</div>';
	$("#list"+"Departure").append(gabung);
    	$( ".dragable" ).draggable({
    	appendTo :"body",
    	helper:"clone",
    	grid: [1, 1],
    	revert:false,
    	connectToSortable:".sortable",
    	start: function(e, ui)
    	 {
    	  var draggableId = e.target.id;
    	  var width = $("#"+draggableId).css("width");
    	  var height = $("#"+draggableId).css("height");
    	  $(ui.helper).css("width",172);
    	  $(ui.helper).css("height",height);
    	 },
    	 stop : function (e,ui)
    	 {
    	 }
    });
});

