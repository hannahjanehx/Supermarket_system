$(document).ready(function() {
    
    $('[name=iSkus]').keypress(function(event){
        return !(event.charCode == 46);
    });

    $('#items').on("submit", function(event) {

        event.preventDefault();

        let skuArray = {};

        $.each($('.sku'), function () {
            if(this.value == '') {
                value = 0;
            } else {
                value = this.value;
            }
            skuArray[this.id] = value;
        });


        $.ajax({
            type: 'post',
            url: 'SubmissionForm/submissionForm.php',
            data: {
                'action': 'generate_price',
                'values': skuArray
            },
            success: function(response) {
                data = JSON.parse(response);
                alert('Total: £' + data.total + " Your Savings: £" + data.savings);
            }
        });
    })

  });