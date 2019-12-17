
function addcountry() {
    var name = $("#name").val();      
    var email = $("#email").val();

    $.post("createcountry.php", {                                  
        name: name,           
        email: email
    }, function (data, status) {                                    
        $("#add_new_record_modal").modal("hide");                   
        readcpuntry();                                              
        $("#first_name").val("");                                   
        $("#last_name").val("");
        $("#email").val("");
    });
}

function readcountry() {
    $.get("index.php", {}, function (data, status) {     
        $(".country_content").html(data);                           
    });
}

function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete User?"); 
    if (conf == true) {                                             
        $.post("delete_user.php", {                             
                id: id                                              
            },
            function (data, status) {
                readcountrys();                                      
            }
        );
    }
}

function updatecountry(id) {
    $("#country_id").val(id);                                   
    $.post("update_country.php", {                            
            id: id                                                  
        },
        function (data, status) {
            var user = JSON.parse(data);                            
            $("#update__country").val(user.country);    
			
        }
    );
    $("#update_user_modal").modal("show");                          
}


function UpdateUser() {
    var name = $("#update_name").val();                 
    var email = $("#update_email").val();
    var id = $("#hidden_user_id").val();                            

    $.post("update_user.php", {                          
            name: name,
            email: email
        },
        function (data, status) {
            $("#update_user_modal").modal("hide");                  
            readRecords();                                          
        }
    );
}

$(document).ready(function () {
    readcountry();                                                      
});
