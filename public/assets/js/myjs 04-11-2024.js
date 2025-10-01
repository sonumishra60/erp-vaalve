// Function to validate email
function validateEmail(email) {
    // Regular expression for email validation
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// Function to validate GST number
function validateGST(gst) {
    // Regular expression for GST validation
    var re = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/;
    return re.test(gst);
}

// Function to validate phone number
function validatePhone(phone) {
    // Regular expression for phone validation
    var re = /^[0-9]{10}$/;
    return re.test(phone);
}

function validatePAN(pan) {
    var panUpperCase = pan.trim().toUpperCase();
    var panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    return panRegex.test(panUpperCase);
}

function funmasterdata() {
    return $.ajax({
        type: 'GET',
        url: masterDataUrl, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}

function funmastercategory() {
    return $.ajax({
        type: 'GET',
        url: masterparentcategory, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function funmasterroles() {
    return $.ajax({
        type: 'GET',
        url: masterroles, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function funroles(roleTypeId) {
    var url = rolesByTypeUrl.replace(':roleTypeId', roleTypeId); // Replace placeholder with actual ID
    return $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json'
    });
}

function funlocation(){
    return $.ajax({
        type: 'GET',
        url: statedate, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}

function funcitybysate(stateId){
    var url = citybystate.replace(':stateId', stateId); // Replace placeholder with actual ID
  //  console.log(url);
    return $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json'
    });
}


function funcustomertype (){
   
    return $.ajax({
        type: 'GET',
        url: customertype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}


function fundealertype(){
  
    return $.ajax({
        type: 'GET',
        url: delaertype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}


function fungalleriestype(){
  
    return $.ajax({
        type: 'GET',
        url: gallerytype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}

function funbillingstatus(){
  
    return $.ajax({
        type: 'GET',
        url: billingtype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}


function funbdistributorstatus(){

    return $.ajax({
        type: 'GET',
        url: dristributortype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}

function funbusinesstype(){

    return $.ajax({
        type: 'GET',
        url: businesstype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}

function funbanktype(){

    return $.ajax({
        type: 'GET',
        url: banktype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}


function funallsalesusers(){

    return $.ajax({
        type: 'GET',
        url: allsalesusers, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });

}

function funmainhead(){
    return $.ajax({
        type: 'GET',
        url: mainheads, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function funcluster(){
    return $.ajax({
        type: 'GET',
        url: cluster, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function funtransproter(){
    return $.ajax({
        type: 'GET',
        url: transproter, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}

function funparentcategory(){
    return $.ajax({
        type: 'GET',
        url: parentcategory, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}

function funcolor(){
    return $.ajax({
        type: 'GET',
        url: color, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function funbrand(){
    return $.ajax({
        type: 'GET',
        url: brand, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function fungetallsalesuser(){
    return $.ajax({
        type: 'GET',
        url: allsalesuser, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}

function fungetalldistributor(){
    return $.ajax({
        type: 'GET',
        url: alldistributor, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function fungetordertype(){
    return $.ajax({
        type: 'GET',
        url: allordertype, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}


function fungetpaymnetmode(){
    return $.ajax({
        type: 'GET',
        url: paymnetmode, // Replace with your server endpoint
        error: function(xhr, status, error) {
            console.error('Error occurred:', status, error);
        }
    });
}



$(document).ready(function() {

    var today = new Date();
    today.setHours(0, 0, 0, 0);


    $(function() {
        $('.bank_check_recieved_date').datepicker({
            language: "es",
            autoclose: true,
            format: "dd-M-yyyy",
           
        });


        $('.year_calender').datepicker({
            format: "M-yyyy", // Format to display month and year
            minViewMode: 1,   // Set the minimum view mode to "months"
            autoclose: true,  // Automatically close the datepicker after selection
            todayHighlight: true, // Highlight today's date
        });
        

        $('#order_date').datepicker({
            autoclose: true,
            format: "dd-M-yyyy",
            startDate: today,
            endDate: today,
            todayHighlight: true
        });


        $('.backdatenotselected').datepicker({
            autoclose: true,
            format: "dd-M-yyyy",
            startDate: today,
          
            todayHighlight: true
        });

    });



    $('.logoutButton').on('click', function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: logout,
            data: {
                _token: csrfToken
            },
            success: function(response) {  
                window.location.href = login;
            },
            error: function(xhr, status, error) {
                window.location.href = login;
                alert('An error occurred while logging out.');
            }
        });
    });
});