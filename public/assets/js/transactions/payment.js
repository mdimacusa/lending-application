$(document).ready(function(){
    $("#rate").change(function(){
        let rate = $("#rate").val()
        let tenurity = $("#tenurity").val()
        let amount = $("#amount").val()
        let interest = (amount*rate)*tenurity
        let loanoutstanding = parseFloat(amount)+parseFloat(interest)
        let monthly = loanoutstanding/tenurity
        $("#interest").val(isNaN(interest.toFixed(2))?"0.00":interest.toFixed(2))
        $("#loanoutstanding").val(isNaN(loanoutstanding.toFixed(2))?"0.00":loanoutstanding.toFixed(2))
        $("#monthly").val(isNaN(monthly.toFixed(2))?"0.00":monthly.toFixed(2))
    })

    $("#tenurity").change(function(){
        let rate = $("#rate").val()
        let tenurity = $("#tenurity").val()
        let amount = $("#amount").val()
        let interest = (amount*rate)*tenurity
        let loanoutstanding = parseFloat(amount)+parseFloat(interest)
        let monthly = loanoutstanding/tenurity
        $("#interest").val(isNaN(interest.toFixed(2))?"0.00":interest.toFixed(2))
        $("#loanoutstanding").val(isNaN(loanoutstanding.toFixed(2))?"0.00":loanoutstanding.toFixed(2))
        $("#monthly").val(isNaN(monthly.toFixed(2))?"0.00":monthly.toFixed(2))
    })

    $("#amount").keyup(function(){

        let rate = '{{$query->rate}}';
        let tenurity = '{{$query->tenurity}}';
        let amount = $("#amount").val();
        let interest = (amount*rate)*tenurity;
        let loanoutstanding = '{{$query->loan_outstanding}}';
        let monthly = loanoutstanding/tenurity;
        let balanceAmount = '{{$query->balance_amount}}';
        let newMonthly = '{{$query->monthly}}';

        let calculateAmount = (parseFloat(newMonthly)-parseFloat(amount))*parseFloat(rate);

        let calculateAmountBalance = (Number(newMonthly)-Number(amount)+Number(balanceAmount))*parseFloat(rate);

        let calculateAmountLoan = (Number(loanoutstanding)-Number(amount)+Number(balanceAmount))*parseFloat(rate);

        $("#interest").val(isNaN(interest.toFixed(2))?"0.00":interest.toFixed(2));
        // $("#loanoutstanding").val(isNaN(loanoutstanding.toFixed(2))?"0.00":loanoutstanding.toFixed(2));
        $("#monthly").val(isNaN(monthly.toFixed(2))?"0.00":monthly.toFixed(2));

    })

    let interest = parseFloat('{{$query->interest}}');
    let loan_outstanding = parseFloat('{{$query->loan_outstanding}}');
    let rate = parseFloat('{{$query->rate}}');
    let monthly = parseFloat('{{$query->monthly}}');
    let remaining_month = parseInt('{{$remaining_month}}');
    let additional_penalties = parseInt('{{$query->additional_interest_amount}}');

    $('#payment_method').on('change',function()
    {

        switch($(this).val())
        {
            case "Standard Payment":
                $('#payment-for').css('display','block');
                $('#payment-method').removeClass( "col-md-12" ).addClass("col-md-6");
                $('#payment-date').removeClass( "col-md-6" ).addClass("col-md-12");
                $('#payment_for').css('display','block');
                $("#amount_to_pay").text(monthly.toFixed(2));
                $('#interest').prop('disabled', false);

                if(remaining_month===1)
                {
                    $("#amount_to_pay").text("₱"+(loan_outstanding).toFixed(2));
                }
                else
                {
                    $("#amount_to_pay").text("₱"+(monthly).toFixed(2));
                }

                break;
            case "Interest":

                $('#payment-for').css('display','none');
                $('#payment-date').removeClass( "col-md-12").addClass( "col-md-6");
                if(remaining_month===1)
                {
                    $("#amount_to_pay").text("₱"+(loan_outstanding).toFixed(2));
                }
                else
                {
                    if(additional_penalties>0)
                    {
                        $("#amount_to_pay").text("₱"+((monthly*rate)+additional_penalties).toFixed(2));
                    }
                    else
                    {
                        $("#amount_to_pay").text("₱"+(monthly*rate).toFixed(2));
                    }


                }
                break;
            default:
                $("#amount_to_pay").text("₱"+(loan_outstanding).toFixed(2));
                $('#payment-date').removeClass( "col-md-12").addClass( "col-md-6");
                $('#payment-for').css('display','none');
                $("#amount_to_pay").text("₱"+(loan_outstanding).toFixed(2));

        }

    });
    $('#interest').on('change',function()
    {
        if(remaining_month===1)
        {
            $("#amount_to_pay").text("₱"+(loan_outstanding).toFixed(2));
        }
        else
        {
            $("#amount_to_pay").text("₱"+(Math.round(monthly*$(this).val())).toFixed(2));
        }
    });

    function CopyAmount(amount) {
        var ex = $('<input>').val(amount).appendTo('body').select();
        document.execCommand("copy");
        alert("Amount has been copied.");
        ex.remove();
    }
});
