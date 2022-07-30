//SCRIPT POUR LES CASES A COCHER (TOUT) : 


function cocherTout(etat)
{
    var cases = document.getElementsByTagName('input');   // on recupère tous les inputs
    for (var i = 1; i < cases.length; i++)     // on les parcourt
        if (cases[i].type == 'checkbox')     // si on a une checkbox...
        {
            cases[i].checked = etat;
        }
    // ... on la coche ou non


}