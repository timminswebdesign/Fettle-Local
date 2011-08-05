$(document).ready(function(){


    $('#btnVal').click(function(){
    
        $(".fieldRow").each(function(){
        
        
            var currec = $(this);
            var attributename = $(this).children("td").children('.fno').text()
            var objectname = $(this).children("td").children('.owntbl').val();
            
            if (objectname == "") {
            
                objectname = $("#defOwner").val();
            }
            
            
            
            if ($(this).children("td").children('.fn').val() !== "") {
            
                attributename = $(this).children("td").children('.fn').val()
                
            }
            
            $.ajax({
                type: "POST",
                url: "./validateattributes.php",
                data: {
                    'attributename': attributename,
                    'objectname': objectname
                },
                success: function(data){
                
                
                
                    var xml = $(data).find("rows").get();
                    
                    $(xml).find("row").each(function(i){
                    
                    
                    
                        if ($(this).find("valid").text() == "true") {
                        
                        
                            $(currec).children("td").children('.valImg').removeClass('notvalid');
                            $(currec).children("td").children('.valImg').addClass('valid');
                            
                        }
                        else {
                            $(currec).children("td").children('.valImg').removeClass('valid');
                            $(currec).children("td").children('.valImg').addClass('notvalid');
                            
                        }
                        
                        $(currec).children("td").children('.fdt').val($(this).find("maxtype").text());
                        $(currec).children("td").children('.flen').val($(this).find("length").text());
                        
                        if ($(this).find("required").text() == "1") {
                        
                            $(currec).children("td").children('.fr').prop("checked", true);
                            
                        }
                        else {
                            $(currec).children("td").children('.fr').prop("checked", false);
                        }
                        
                    });
                    
                }
            });
            
        });
        
    });
    
    
    
    
    $('#btnValData').click(function(){
		
		
		
    
        $('td[class^="dd"]').removeClass("invaliddata");
        var errors = "";
        $('#txtError').val("");
       
        $(".fieldRow").each(function(){
        
          var rowNum = 0;
        
            if ($(this).children("td").children('.fne').prop("checked") == true) {
            
                var currec = $(this);
                
                var dd = $(this).children("td").children('.fno').attr('name').replace('fno', '.dd');
                var flength = $(this).children("td").children('.flen').val();
                var required = $(this).children("td").children('.fr').prop("checked");
                var datatype = $(this).children("td").children('.fdt').val();
                var fieldNameO = $(this).children("td").children('.fno').text();
                var fieldNameN = $(this).children("td").children('.fn').val();
               
                $(dd).each(function(){
                rowNum++;
                    if ($(this).text().length > flength) {
                    
                        $(this).addClass("invaliddata");
                        errors += "Error:: Row: " + rowNum + " Original Field: " + fieldNameO + " New Field:" + fieldNameN + " :: Data Greater than Field Length\r\n";
                    };
                    
                    
                    if (valDataType($(this).text(), datatype) == false) {
						  $(this).addClass("invaliddata");
						 errors += "Error:: Row: " + rowNum + " Original Field: " + fieldNameO + " New Field:" + fieldNameN + " :: Not A Valid "+datatype+" Data Type\r\n";
                    
					}
                    
                        if (required && $(this).text().length < 1) {
                        
                            $(this).addClass("invaliddata");
                            errors += "Error:: Row: " + rowNum + " Original Field: " + fieldNameO + " New Field:" + fieldNameN + " ::Field is Required\r\n";
                        };
                    
                    if (datatype == "YORN" && $(this).text().length > 1) {
                    
                        $(this).addClass("invaliddata");
                        errors += "Error:: Row: " + rowNum + " Original Field: " + fieldNameO + " New Field:" + fieldNameN + " ::Not A Valid YORN\r\n";
                        
                        
                    }
                    
                    
                });
                
                
            }
            
        });
        
        
        
        if (errors.length > 0) {
        
            $('#txtError').val(errors);
            $('.valError').slideDown();
			 $('.valValid').slideUp();
			                            
		 info("Data Validation Failed - Check Log for Details",true);				
                            
        }
        else {
 			info("Data Validation Sucessful",false);
        }
    });
    
    
    
    
});




function valDataType(fValue, dataType){

    switch (dataType) {
        case 'INTEGER':
            
            if (isNaN(fValue) == true) {
            
                return false;
            }
            break;
        case 'SMALLINT':
            if (isNaN(fValue) == true) {
            
                return false;
            }
            break;
        case 'FLOAT':
            if (isNaN(fValue) == true) {
            
                return false;
            }
            break;
        case 'AMOUNT':
            if (isNaN(fValue) == true) {
            
                return false;
            }
            break;
            
    }
    
    return true;
    
}

