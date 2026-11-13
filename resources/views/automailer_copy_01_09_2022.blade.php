
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  @include('shared.css_links.css_links')
</head>
<body>
  <div class="container-fluid">
    {{-- <input type="text" name="" id="clock"> --}}
    <div style="margin-top: 8%;">
      <h1 class="display-2 text-center">DO NOT CLOSE</h1>

      <hr class="my-4 ">

      <p class="text-center">Auto Mail Notification</p>
      <span id="time"></span>

    </div>
  </div>


</body>
<!-- @section('js_content') -->
@include('shared.js_links.js_links')
<script type="text/javascript">


$(document).ready(function () {
    setInterval(myTimer, 1000);

    // checkDateForEmail();
    function myTimer() {

        const d = new Date();

        var current_time = d.toLocaleString("en-US", {
                timeZone: 'Asia/Manila',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
        });

        $("#time").html(current_time);

        if(current_time == "10:00:00 AM"){
            checkDateForEmail();
            monthlyMailerFunction();
        }

        // if(current_time == "03:23:00 PM"){
        //     monthlyMailerFunction();
        // }
    }

    // Auto Email every 7th day of the month
    function monthlyMailerFunction(){
        const date = new Date();
        const currentYear = date.getFullYear();
        const currentMonth = date.getMonth();
        const currentDay = date.getDate();
        const seventhDayOfTheMonthInLongFormat = new Date(currentYear, currentMonth, 7);
        const forTesting = `${(currentMonth+1)}/${currentDay}/${currentYear}`;
        const seventhDayOfTheMonth = `${(currentMonth+1)}/7/${currentYear}`;
        const sixthDayOfTheMonth = `${(currentMonth+1)}/6/${currentYear}`;
        const fifthDayOfTheMonth = `${(currentMonth+1)}/5/${currentYear}`;
        const fourthDayOfTheMonth = `${(currentMonth+1)}/4/${currentYear}`;
        const thirdDayOfTheMonth = `${(currentMonth+1)}/3/${currentYear}`;
        const secondDayOfTheMonth = `${(currentMonth+1)}/2/${currentYear}`;
        const firstDayOfTheMonth = `${(currentMonth+1)}/1/${currentYear}`;
        console.log('currentYear ', currentYear);
        console.log('currentMonth ', currentMonth + ' (0 based, thats why I add 1 for the currentMonth)');
        console.log('currentDay ', currentDay);
        console.log('seventhDayOfTheMonth ', seventhDayOfTheMonth);
        console.log('seventhDayOfTheMonthInLongFormat ', seventhDayOfTheMonthInLongFormat);
        console.log('-----------------------------------------------------------------------------------------------------');

        const dateToday = `${(currentMonth+1)}/${currentDay}/${currentYear}`;
        const dateTodayInLongFormat = new Date(currentYear, currentMonth, currentDay);
        console.log(`dateToday ${dateToday}`);
        console.log('dateTodayInLongFormat ', dateTodayInLongFormat);


        /* For testing purposes only */
        // if(dateToday == forTesting){
        //     console.log(`dateToday ${dateToday} and forTesting ${forTesting} is equal`);
        //     sendMonthlyMailerFunction();
        // }else{
        //     console.log(`dateToday ${dateToday} and forTesting ${forTesting} is not equal`);
        // }

        if(dateToday == sixthDayOfTheMonth){
            console.log(`Date today ${dateToday} is equal to ${sixthDayOfTheMonth}`);
            sendMonthlyMailerForJannusFunction();
        }
        else if(dateToday == seventhDayOfTheMonth){
            console.log(`Date today ${dateToday} is equal to ${seventhDayOfTheMonth}`);
            sendMonthlyMailerFunction();
        }
        else{
            console.log(`Date today ${dateToday} is not equal to ${firstDayOfTheMonth}`);
        }


        /* Copy */
        // if(dateToday == seventhDayOfTheMonth ||
        //     dateToday == sixthDayOfTheMonth ||
        //     dateToday == fifthDayOfTheMonth ||
        //     dateToday == fourthDayOfTheMonth ||
        //     dateToday == thirdDayOfTheMonth ||
        //     dateToday == secondDayOfTheMonth ||
        //     dateToday == firstDayOfTheMonth
        // ){
        //     console.log(`Date today ${dateToday} is equal to ${seventhDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is equal to ${sixthDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is equal to ${fifthDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is equal to ${fourthDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is equal to ${thirdDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is equal to ${secondDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is equal to ${firstDayOfTheMonth}`);
        //     sendMonthlyMailerFunction();
        // }else{
        //     console.log(`Date today ${dateToday} is not equal to ${seventhDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is not equal to ${firstDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is not equal to ${seventhDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is not equal to ${sixthDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is not equal to ${fifthDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is not equal to ${fourthDayOfTheMonth}`);
        //     console.log(`Date today ${dateToday} is not equal to ${thirdDayOfTheMonth}`);
        // }
    }

    function sendMonthlyMailerFunction(){
        console.log('sendMonthlyMailerFunction() called');
        $.ajax({
            url: "sendMonthlyMailer",
            method: "get",
            dataType: "json",
            success: function(response){
                if(response['result'] == 1){
                    console.log(`sendMonthlyMailerFunction Successful`);
                }
                else{
                    console.log(`sendMonthlyMailerFunction Unsuccessful`);
                }
            }
        });
    }

    function sendMonthlyMailerForJannusFunction(){
        console.log('sendMonthlyMailerForJannusFunction() called');
        $.ajax({
            url: "sendMonthlyForJannusMailer",
            method: "get",
            dataType: "json",
            success: function(response){
                if(response['result'] == 1){
                    console.log(`sendMonthlyMailerFunction Successful`);
                }
                else{
                    console.log(`sendMonthlyMailerFunction Unsuccessful`);
                }
            }
        });
    }

    function checkDateForEmail(){
        $.ajax({
            url: "get_date",
            method: "get",
            dataType: "json",
            success: function(response){
                let i=0;
                let customerClaimDetails = response['claimRecord'];
                for(i = 0; i<customerClaimDetails.length; i++){

                    /*
                        Script to format date base on database column (required_reply)
                    */

                    databaseDate = new Date(customerClaimDetails[i]['required_reply']);

                    // TO MAKE THE FORMAT OF THE DATE WITHOUT THE TIME
                    databaseDate = ('0' + (databaseDate.getMonth()+1)).slice(-2) + '/'
                    + ('0' + databaseDate.getDate()).slice(-2) + '/'
                    +  databaseDate.getFullYear();

                    databaseDate_inlongformat = new Date(databaseDate);
                    console.log(`databaseDate_inlongformat ${databaseDate_inlongformat} and databaseDate ${databaseDate}`,);
                    /*
                        End Script
                    */


                    /*
                        Script to format date minus 1 day for comparison for before due date email
                    */
                    databaseDateForMinus = new Date(customerClaimDetails[i]['required_reply']);
                    databaseDateMinusOneDay = new Date(databaseDateForMinus.setDate(databaseDateForMinus.getDate()-1));

                    databaseDateMinusOneDay = ('0' + (databaseDateMinusOneDay.getMonth()+1)).slice(-2) + '/'
                    + ('0' + databaseDateMinusOneDay.getDate()).slice(-2) + '/'
                    +  databaseDateMinusOneDay.getFullYear();

                    // databaseDateMinusOneDay = new Date(databaseDateMinusOneDay);

                    /*
                        End Script
                    */


                    /*
                        Script to format date today for comparison
                    */
                    date_today = new Date();

                    //TO MAKE THE FORMAT OF THE DATE WITHOUT THE TIME
                    todayDate = ('0' + (date_today.getMonth()+1)).slice(-2) + '/'
                    + ('0' + date_today.getDate()).slice(-2) + '/'
                    +  date_today.getFullYear();

                    todayDate_inlongformat = new Date(todayDate);
                    /*
                        End Script
                    */


                    // console.log("database duedate:");
                        console.log("database id "+customerClaimDetails[i]['id']);

                        console.log("database duedate: "+databaseDate);
                        console.log("date today for comparison: "+todayDate);
                        console.log("date -1 day for before duedate: "+databaseDateMinusOneDay);


                    if(databaseDate == todayDate){
                        // console.log("database duedate: "+databaseDate);
                        // console.log("date today for comparison: "+todayDate);
                        // console.log("date -1 day for before duedate: "+databaseDateMinusOneDay);
                        console.log("run sendMailDueDate for database id "+customerClaimDetails[i]['id']);
                        sendMailDueDate(customerClaimDetails[i]['id']);
                    }
                    if(databaseDateMinusOneDay == todayDate ){
                        // console.log("database duedate: "+databaseDate);
                        // console.log("date today for comparison: "+todayDate);
                        // console.log("date -1 day for before duedate: "+databaseDateMinusOneDay);
                        console.log("run sendMailBeforeDueDate for database id "+customerClaimDetails[i]['id']);

                        sendMailBeforeDueDate(customerClaimDetails[i]['id']);

                    }
                    if(todayDate_inlongformat > databaseDate_inlongformat){
                        // console.log("database duedate: "+databaseDate);
                        // console.log("date today for comparison: "+todayDate);
                        // console.log("date -1 day for before duedate: "+databaseDateMinusOneDay);
                        console.log("run sendMailOverDue for database id "+customerClaimDetails[i]['id']);

                        sendMailOverDue(customerClaimDetails[i]['id']);
                    }
                }


            }
        });
    }

    function sendMailDueDate(id){
        $.ajax({
            url: "send_mail_due_date",
            method: "get",
            data: {
                id : id,
            },
            dataType: "json",
            success: function(response){
                if(response['result'] == 1){
                    console.log('sendMailDueDate for database id = '+ id + ' Successful');
                }
                else{
                    console.log('sendMailDueDate for database id = '+ id + ' Failed');
                }
            }
        });
    }
    function sendMailBeforeDueDate(id){
        $.ajax({
            url: "send_mail_before_due_date",
            method: "get",
            data: {
                id : id,
            },
            dataType: "json",
            success: function(response){
                if(response['result'] == 1){
                    console.log('sendMailBeforeDueDate for database id = '+ id + ' Successful');
                }
                else{
                    console.log('sendMailBeforeDueDate for database id = '+ id + ' Failed');
                }
            }
        });
    }
    function sendMailOverDue(id){
        $.ajax({
            url: "send_mail_over_due_date",
            method: "get",
            data: {
                id : id,
            },
            dataType: "json",
            success: function(response){
                if(response['result'] == 1){
                    console.log('sendMailOverDue for database id = '+ id + ' Successful');
                }
                else{
                    console.log('sendMailOverDue for database id = '+ id + ' Failed');
                }
            }
        });
    }




});



</script>
</html>

