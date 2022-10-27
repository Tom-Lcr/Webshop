window.addEventListener('DOMContentLoaded', function () {

    var titels = document.getElementsByClassName("artikelTitel");
    console.log(titels);

    for (var i = 0; i < titels.length; i++) {

        var titel = titels[i];

        var aantalLetters = titel.innerHTML.length;

        if (aantalLetters > 29) {
            titel.style.fontSize = "0.9em";
        }
    }
});

