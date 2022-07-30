//SCRIPT POUR LES CASES A COCHER : 


$(document).ready(function () {
    $('#submit').click(function () {
        var count = 0;
        $('.checkbox_table').each(function () {
            if ($(this).is(':checked'))
            {
                count = count + 1;
            }
        });
        if (count > 0)
        {
            $('#export_form').submit();
        } else
        {
            alert("Merci de sélectionner au moins une table à exporter");
            return false;
        }
    });
});