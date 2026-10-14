let initialized = false;
const listElement = document.getElementById("people-list");
const connectionStatusElement =
    document.getElementById("connection-status");

let currentState = {};
let requestInProgress = false;

function displayName(name) {
    return name.charAt(0).toUpperCase() + name.slice(1);
}

function renderPeople() {
    listElement.replaceChildren();

    for (const person of currentState) {
        const name = person['name'];
        const row = document.createElement("tr");

        const nameCell = document.createElement("td");
        const nameLink = document.createElement("a");
        nameLink.href = `https://is${encodeURIComponent(name)}.nogin.nl`;
        nameLink.textContent = displayName(name);
        nameCell.appendChild(nameLink);

        const statusCell = document.createElement("td");
        statusCell.className = "status-cell";

        const statusText = document.createElement("span");
        statusText.className = "status-text";
        statusText.dataset.statusFor = name;

        const label = document.createElement("label");
        label.className = "switch";

        const input = document.createElement("input");
        input.type = "checkbox";
        input.dataset.personId = name;
        input.setAttribute(
            "aria-label",
            `Toggle nogin.nl status for ${displayName(name)}`
        );

        const slider = document.createElement("span");
        slider.className = "slider";

        input.addEventListener("change", () => {
            updatePerson(name, input.checked, input);
        });

        label.appendChild(input);
        label.appendChild(slider);

        statusCell.appendChild(statusText);
        statusCell.appendChild(label);

        row.appendChild(nameCell);
        row.appendChild(statusCell);

        listElement.appendChild(row);
    }

    initialized = true;
}

function renderState(state) {
    for (const person of currentState) {
        let name = person['name'];
        let isNogInNL = person['isNogInNL'];

        const input = document.querySelector(
            `input[data-person-id="${name}"]`
        );

        const statusText = document.querySelector(
            `[data-status-for="${name}"]`
        );

        if (input) {
            input.checked = isNogInNL;
        }

        if (statusText) {
            statusText.textContent = isNogInNL ? "nogin.nl" : "nietin.nl";
        }
    }
}

async function loadState() {
    if (requestInProgress) {
        return;
    }

    requestInProgress = true;

    try {
        const response = await fetch(`api.php/persons`, {
            cache: "no-store"
        });

        if (!response.ok) {
            throw new Error("Unable to load status");
        }

        const state = await response.json();

        currentState = state;
        if (!initialized) {
            renderPeople();
        }
        renderState(state);
    } catch (error) {
        connectionStatusElement.textContent = "Unable to connect";
        console.error(error);
    } finally {
        requestInProgress = false;
    }
}

async function updatePerson(name, isNogInNL, input) {
    input.disabled = true;

    try {
        const response = await fetch("api.php/persons/" + name, {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                isNogInNL: isNogInNL
            })
        });

        const result = await response.json();

        if (!response.ok || result.isNogInNL !== isNogInNL) {
            throw new Error(result.error || "Update failed");
        }

        await loadState();
    } catch (error) {
        input.checked = currentState[name] === true;
        alert(error.message);
    } finally {
        input.disabled = false;
    }
}

async function start() {
    try {
        await loadState();

        setInterval(loadState, 1000);
    } catch (error) {
        connectionStatusElement.textContent = "Unable to load page data";
        console.error(error);
    }
}

start();
