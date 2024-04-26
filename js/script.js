function changeActiveTab(evt) {
    var i, links;

    links = document.getElementsByClassName("links");

    for (i = 0; i < links.length; i++) {
        links[i].className = links[i].className.replace(" active", "");
    }

    evt.currentTarget.className += " active";
}
