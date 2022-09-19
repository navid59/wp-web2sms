jQuery(document).ready(function(){
    jQuery("#btn_pending").click(function(){
        pendingStr = jQuery('#wc_settings_web2sms_pending_text').val();
        if(isEmpty(pendingStr)) {
            console.log('Is empty');
            return false;
        }
        
        
        isStandard = isStandardTxt(pendingStr);
        smsCalculation(pendingStr, isStandard);
    });

    jQuery("#btn_onhold").click(function(){
        alert ('On-Hold');
    //     const article = document.getElementById("btn_onhold")
    //   console.log(article.dataset.smscontent);
    });
    
    jQuery("#btn_failed").click(function(){
        alert ('Failed');
    });
    
    jQuery("#btn_processing").click(function(){
        alert ('Processing');
    });
    
    jQuery("#btn_cancelled").click(function(){
        alert ('Cancelled');
    });
    
    jQuery("#btn_completed").click(function(){
        alert ('Completed');
    });
    
    jQuery("#btn_refunded").click(function(){
        alert ('Refunded');
    });
});

/**
 * Calculate Nr of SMS
 */
function smsCalculation(str, isStandard) {
    var maxSizeStandard          = 160; // Max Character in standard            | (140*8)/7
    var maxSizeNoneStandard      = 70;  // Max Character in none standard       | (140*8)/16
    var maxSpilitSizeStandard    = 153; // Max Character in split Standard      | ((140-6)*8)/7
    var maxSplitSizeNoneStandard = 67;  // Max Character in split none standard | ((140-6)*8)/16


    if(isStandard) {
        if(str.length <= maxSizeStandard) {
            // Calculate by 160
            smsNr = 1;
        } else {
            // Calculate by 153
            smsNr = Math.ceil(str.length / maxSpilitSizeStandard);
        }
    } else {
        if(str.length <= maxSizeNoneStandard) {
            // Calculate by 70
            smsNr = 1;
        } else {
            // Calculate by 67
            smsNr = Math.ceil(str.length / maxSplitSizeNoneStandard);
        }
    }

    console.log(str.length);
    console.log(str);
    console.log(isStandard);
    console.log(smsNr);
    
    tb_show("Mobile view", "../wp-content/plugins/netopia-payments-payment-gateway/src/devicesViewCellPhone.php?TB_iframe=true&width=400&height=770");
    
}

function isStandardTxt(str) {
    for (var i = 0; i < str.length; i++) {
        if(!isGsm7bit(str.charAt(i))) {
            return false;
        }
    }
    return true;
  }

function isGsm7bit(letter) {
    gsm = "@£$¥èéùìòÇØøÅåΔ_ΦΓΛΩΠΨΣΘΞ^{}\[~]|€ÆæßÉ!\"#¤%&'()*+,-./0123456789:;<=>?¡ABCDEFGHIJKLMNOPQRSTUVWXYZÄÖÑÜ§¿abcdefghijklmnopqrstuvwxyzäöñüà ";
    var letterInAlfabet = gsm.indexOf(letter) !== -1;
    return(letterInAlfabet);
}

/**
 * Check if variable is null | Undefine | Empty 
 */
function isEmpty(val){
    return (val === undefined || val == null || val.length <= 0) ? true : false;
}

