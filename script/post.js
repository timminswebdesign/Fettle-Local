$(document).ready(function(){

    var IterUrl = Array();
    var curUrl = 0;
    var timer;
    
    $('#btnPost').click(function(){
    
    
    
    
    
        var delay = $('#postDelay').val() * 1000 * 60;
        
        var i = 0;
        
        $('#msgPostStat').text("");
        $(".btnDownload").each(function(){
        
        
            IterUrl[i] = "http://localhost:7001/fettle" + $(this).children("span").children("a").attr("href");
             IterUrl[i] = IterUrl[i].replace('php','xml');
			 IterUrl[i] = IterUrl[i].replace('PHP','XML');
			 
			 
            $('#msgPostStat').append('<div id="ps' + i + '"><img src="./images/loading.gif" alt="loading"/><span>' + $(this).children("span").text() + '</span></div>');
            
            
            i++;
        });
        
        
        $('#msgPostStat').dialog("open");
        
        postTimer();
        timer = setInterval(postTimer, delay);
        
        
    });
    
    
    
    function postTimer(){
        var f = curUrl;

            
                $.ajax({
                    type: "POST",
                    url: './post.php',
                    data: {
						'xmlurl': IterUrl[curUrl],
						'maxurl': $('#postLoc').val()						
					},
                    success: function(data){
                    
                    
                        $("#ps" + f + " span").text($("#ps" + f + " span").text() + " - Completed");
                        $("#ps" + f + " img").attr("src", "./images/tick.png");
                    },
                    error: function(xhr){
                    
                        $("#ps" + f + " span").text($("#ps" + f + " span").text() + " - Could Not Post - Error:"+xhr.status);
                        $("#ps" + f + " img").attr("src", "./images/cross.png");
                        
                    }
                    
                    
                });
                
                
            
            
            
            
      
        
        curUrl++;
        
        if (curUrl >= IterUrl.length) {
            curUrl = 0;
            clearInterval(timer);
            
        }
        
    }
    
    
    
    
    
    $("#msgPostStat").dialog({
        height: 140,
        modal: true,
        autoOpen: false,
        buttons: {
            "Cancel Post": function(){
            
            $(this).dialog("close");
            }
            
            
        },
		  beforeClose: function(event, ui) {
		  	curUrl = 0;
            clearInterval(timer);
		  }
    
    
    });
    
    
});


