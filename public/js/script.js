function handleNavClick(event) {
    if (event.target.textContent.match(/^\n?-/)) {
        event.target.textContent = event.target.textContent.replace(/^\n?-/, '+');
    } else {
        event.target.textContent = event.target.textContent.replace(/^\n?\+/, '-');
    }

    let target = event.target.dataset.target.replace('#', '');
    document.getElementById(target).classList.toggle("show");
}