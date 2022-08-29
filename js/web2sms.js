jQuery(document).ready(function(){
    jQuery("#btn_pending").click(function(){
        alert ('PENDING');
        jQuery("#myModal").modal('show');
    });

    jQuery("#btn_onhold").click(function(){
        alert ('On-Hold');
        // jQuery("#myModal").modal('show');
    });
    
    jQuery("#btn_failed").click(function(){
        alert ('Failed');
        // jQuery("#myModal").modal('show');
    });
    
    jQuery("#btn_processing").click(function(){
        alert ('Processing');
        // jQuery("#myModal").modal('show');
    });
    
    jQuery("#btn_cancelled").click(function(){
        alert ('Cancelled');
        // jQuery("#myModal").modal('show');
    });
    
    jQuery("#btn_completed").click(function(){
        alert ('Completed');
        // jQuery("#myModal").modal('show');
    });
    
    jQuery("#btn_refunded").click(function(){
        alert ('Refunded');
        // jQuery("#myModal").modal('show');
    });
});