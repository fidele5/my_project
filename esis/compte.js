function CompteARebours()
{
    var date_actuelle = new Date(); 
    var annee = date_actuelle.getFullYear();
    var fin = new Date(annee, 0, 30, 0, 0, 0);
    if (fin.getTime() < date_actuelle.getTime())
        fin = new Date(++annee, 11, 25, 8, 0, 0); 
    var tps_restant = fin.getTime() - date_actuelle.getTime();

    var s_restantes = tps_restant / 1000; 
    var i_restantes = s_restantes / 60;
    var H_restantes = i_restantes / 60;
    var d_restants = H_restantes / 24;
    var m_restants = d_restants /31;
    
    s_restantes = Math.floor(s_restantes % 60); 
    i_restantes = Math.floor(i_restantes % 60); 
    H_restantes = Math.floor(H_restantes % 24); 
    d_restants = Math.floor(d_restants); 
    m_restants = Math.floor(m_restants) 

    var mois_fr = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 
    'Septembre', 'Octobre', 'Novembre', 'Décembre');
    texte = "Il reste exactement <strong>" +d_restants+ " jours</strong>, " +H_restantes+ " heures</strong>," +
    " <strong>" +i_restantes+ " minutes</strong> et <strong>" +s_restantes+ "s</strong> avant la publication.</div>";
    document.getElementById("affichage").innerHTML = texte;
}
setInterval(CompteARebours, 1000);

function CompteARebours2()
{
    var date_actuelle = new Date(); 
    var annee = date_actuelle.getFullYear();
    var fin = new Date(annee, 0, 28, 0, 0, 0);
    if (fin.getTime() < date_actuelle.getTime())
        fin = new Date(++annee, 11, 25, 8, 0, 0); 
    var tps_restant = fin.getTime() - date_actuelle.getTime();

    var s_restantes = tps_restant / 1000; 
    var i_restantes = s_restantes / 60;
    var H_restantes = i_restantes / 60;
    var d_restants = H_restantes / 24;
    var m_restants = d_restants /31;
    
    s_restantes = Math.floor(s_restantes % 60); 
    i_restantes = Math.floor(i_restantes % 60); 
    H_restantes = Math.floor(H_restantes % 24); 
    d_restants = Math.floor(d_restants); 
    m_restants = Math.floor(m_restants) 

    var mois_fr = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 
    'Septembre', 'Octobre', 'Novembre', 'Décembre');
    texte = "Il reste exactement <strong>" +d_restants+ " jours</strong>, " +H_restantes+ " heures</strong>," +
    " <strong>" +i_restantes+ " minutes</strong> et <strong>" +s_restantes+ "s</strong> avant le vote.</div>";
    document.getElementById("affichage1").innerHTML = texte;
}
setInterval(CompteARebours2, 1000);