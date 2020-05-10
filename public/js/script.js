function handleNavClick(event) {
    if (event.target.textContent.match(/^\n?-/)) {
        event.target.textContent = event.target.textContent.replace(/^\n?-/, '+');
    } else {
        event.target.textContent = event.target.textContent.replace(/^\n?\+/, '-');
    }

    let target = event.target.dataset.target.replace('#', '');
    document.getElementById(target).classList.toggle("show");
}

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
    typeahead.classList.add('hidden');
}

function showTypeahead() {
    let typeahead = document.getElementById("typeahead");
    typeahead.classList.remove('hidden');
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


