
// Search typeahead
function typeahead(e) {
    clearTypeahead();

    let searchterm = e.target.value;
    if (searchterm === "") {
        hideTypeahead();
        return false;
    }

    let results = searchTitles(searchterm, markdownFiles);

    if (results.length > 0) {
        showTypeahead();

        for (let i in results) {
            let r = results[i];
            addTypeaheadElement(r)
        }
    } else {
        hideTypeahead();
    }
}

function addTypeaheadElement(r) {
    let div = document.createElement("div");
    let anchor = document.createElement("a");
    let text = document.createTextNode(r[1]);

    anchor.setAttribute('href', `/${r[0]}/${r[1]}`);
    anchor.appendChild(text);
    div.appendChild(anchor);

    let typeahead = document.getElementById("typeahead");

    typeahead.appendChild(div);
}

function clearTypeahead() {
    let typeahead = document.getElementById("typeahead");

    typeahead.innerHTML = '';
}

function hideTypeahead() {
    let typeahead = document.getElementById("typeahead");
    let input = document.getElementById("search_md_searchterm");
    let button = document.getElementById("search_md_Search");

    typeahead.classList.add('hidden');
    input.classList.remove('searching');
    button.classList.remove('searching');
}

function showTypeahead() {
    let typeahead = document.getElementById("typeahead");
    let input = document.getElementById("search_md_searchterm");
    let button = document.getElementById("search_md_Search");
    highlightPosition = -1;

    typeahead.classList.remove('hidden');
    input.classList.add('searching');
    button.classList.add('searching');
}

function searchTitles(searchterm, files, results = []) {
    for (let key in files) {
        let value = files[key];
        let re = new RegExp(searchterm, "g");

        if(typeof value === "object") {
            searchTitles(searchterm, value, results);
        } else if (key.match(re)) {
            results.push([value, key]);
        }
    }

    return results;
}

const searchField = document.getElementById('search_md_searchterm');
searchField.addEventListener('input', typeahead);

// Arrow keys on search input
let highlightPosition = null;
document.addEventListener('keydown', handleSearchKeys);

function handleSearchKeys(e) {
    if (searchField !== document.activeElement) {
        return false;
    }

    switch (e.code) {
        case 'ArrowUp':
            selectTypeaheadUp();
            break;
        case 'ArrowDown':
            selectTypeaheadDown();
            break;
        case 'Enter':
            if (clickHighlighted()) {
                e.preventDefault();
            }
            break;
        case 'Escape':
            removeHighlight(highlightPosition);
            hideTypeahead();
    }
}

function clickHighlighted() {
    const typeahead = document.getElementById('typeahead');
    const highlightedDiv = typeahead.getElementsByClassName('highlight');

    if (highlightedDiv.length < 1) {
        return false;
    }

    const anchor = highlightedDiv[0].firstChild;

    window.location = anchor.href;

    return true;
}

function selectTypeaheadUp() {
    const typeaheadElement = document.getElementById('typeahead');

    if (highlightPosition === 0) {
        return false;
    }

    removeHighlight(highlightPosition);
    highlightPosition--;
    addHighlight(highlightPosition);
}

function selectTypeaheadDown() {
    const typeaheadElement = document.getElementById('typeahead');

    if (highlightPosition === typeaheadElement.childNodes.length - 1) {
        return false;
    }

    removeHighlight(highlightPosition);
    highlightPosition++;
    addHighlight(highlightPosition);
}

function removeHighlight(position) {
    const typeaheadElement = document.getElementById('typeahead');
    const highlightElement = typeaheadElement.childNodes[position];

    if(typeof highlightElement === "undefined") {
        return false;
    }

    highlightElement.classList.remove('highlight')
}

function addHighlight(position) {
    const typeaheadElement = document.getElementById('typeahead');
    const highlightElement = typeaheadElement.childNodes[position];

    if(typeof highlightElement === "undefined") {
        return false;
    }

    highlightElement.classList.add('highlight')
}