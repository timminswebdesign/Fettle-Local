$(document).ready(function(){


    $('#btnSm').click(function(){
    
        $.ajax({
            type: "POST",
            url: "./runquery.php",
            data: {
            
                'query': "delete from mappings where templateid = " + $("#opPrevMap").val()
            
            }
        });
        
        $(".fieldRow").each(function(){
        
        
            var currec = $(this);
            
            var templateid = $("#opPrevMap").val();
            var original = $(this).children("td").children('.fno').text();
            var newname = $(this).children("td").children('.fn').val();
            var enabled = $(this).children("td").children('.fne').prop("checked");
            var isgl = $(this).children("td").children('.fngl').prop("checked");
            var ownertable = $(this).children("td").children('.owntbl').val();
            var name = $("#opPrevMap option:selected").text();
            var deftbl = $("#defOwner").val();
            
            $.ajax({
                type: "POST",
                url: "./savemappings.php",
                data: {
                
                    'templateid': templateid,
                    'original': original,
                    'newname': newname,
                    'enabled': enabled,
                    'isgl': isgl,
                    'ownertable': ownertable,
                    'name': name,
                    'deftbl': deftbl
                },
                success: function(data){
                
                
                
                }
            });
            
        });
        info("Mappings Saved Sucessfully", false);
        
    });
    
    
    $('#btnSma').click(function(){
    
        $('#msgSaveMapping').dialog("open");
        
    });
    
    
    $("#msgSaveMapping").dialog({
        height: 140,
        modal: true,
        autoOpen: false,
        buttons: {
            "Save": function(){
				
				
				    var templateid = parseInt($("#opPrevMap").children('option:last').val()) + 1;
				
				 $(".fieldRow").each(function(){
        
        
            var currec = $(this);
            
           
		   
            var original = $(this).children("td").children('.fno').text();
            var newname = $(this).children("td").children('.fn').val();
            var enabled = $(this).children("td").children('.fne').prop("checked");
            var isgl = $(this).children("td").children('.fngl').prop("checked");
            var ownertable = $(this).children("td").children('.owntbl').val();
            var name = $("#templatename").val();
            var deftbl = $("#defOwner").val();
            
            $.ajax({
                type: "POST",
                url: "./savemappings.php",
                data: {
                
                     'templateid': templateid,
                    'original': original,
                    'newname': newname,
                    'enabled': enabled,
                    'isgl': isgl,
                    'ownertable': ownertable,
                    'name': name,
                    'deftbl': deftbl
                },
                success: function(data){
                
                
                
                }
            });
            
		
			
        });
		
			$("#opPrevMap").append('<option value="'+ templateid +'">'+$("#templatename").val()+'</option>');
        info("Mappings Saved Sucessfully", false);
		
				
                $(this).dialog("close");
            },
            Cancel: function(){
                $(this).dialog("close");
            }
        }
    });
    
    $('#btnLm').click(function(){
    
    
    
    
        $.ajax({
            type: "POST",
            url: "./loadmappings.php",
            data: {
                'templateid': $("#opPrevMap").val()
            },
            success: function(data){
            
            
            
                var xml = $(data).find("rows").get();
                
                $(xml).find("row").each(function(i){
                
                
                    var currec = ".fno:contains('" + $(this).find("original").text() + "')";
                    
                    currec = $(currec).parent().parent();
                    
                    
                    
                    $(currec).children("td").children('.fn').val($(this).find("newname").text());
                    $(currec).children("td").children('.owntbl').val($(this).find("ownertable").text());
                    $('#defOwner').val($(this).find("deftbl").text());
                    
                    if ($(this).find("enabled").text() == 'true') {
                    
                        $(currec).children("td").children('.fne').prop("checked", true);
                    }
                    else {
                        $(currec).children("td").children('.fne').prop("checked", false);
                    }
                    
                    if ($(this).find("isgl").text() == 'true') {
                    
                        $(currec).children("td").children('.fngl').prop("checked", true);
                    }
                    else {
                        $(currec).children("td").children('.fngl').prop("checked", false);
                    }
                    
                    
                    
                });
                
            }
        });
        
        info("Mappings Loaded Sucessfully", false);
        
        
    });
    
});





