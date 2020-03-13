function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}


// Add Grades activity //

function openDash(evt, gradesName) {
    var i, tabdashcontent, tabdashlinks;
    tabdashcontent = document.getElementsByClassName("tabdashcontent");
    for (i = 0; i < tabdashcontent.length; i++) {
        tabdashcontent[i].style.display = "none";
    }
    tabdashlinks = document.getElementsByClassName("tabdashlinks");
    for (i = 0; i < tabdashlinks.length; i++) {
        tabdashlinks[i].className = tabdashlinks[i].className.replace(" active", "");
    }
    document.getElementById(gradesName).style.display = "block";
    evt.currentTarget.className += " active";
}


// Add Grades activity //

function openActivity(evt, activityName) {
    var i, tabactscontent, tabactslinks;
    tabactscontent = document.getElementsByClassName("tabactscontent");
    for (i = 0; i < tabactscontent.length; i++) {
        tabactscontent[i].style.display = "none";
    }
    tabactslinks = document.getElementsByClassName("tabactslinks");
    for (i = 0; i < tabactslinks.length; i++) {
        tabactslinks[i].className = tabactslinks[i].className.replace(" active", "");
    }
    document.getElementById(activityName).style.display = "block";
    evt.currentTarget.className += " active";
}
