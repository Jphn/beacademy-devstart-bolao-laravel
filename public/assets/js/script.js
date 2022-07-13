dozens = [];

function submitDozensForm() {
    let button = document.getElementById('postDozensFormSubmitButton');
    button.click();
}

function toggleDozenValue(element, value) {
    let index = dozens.indexOf(value);

    if (index === -1) {
        if (dozens.length === 10) return;
        dozens.push(value);
    } else {
        dozens.splice(index, 1);
    }

    element.classList.toggle('selected');

    updateFormInputValue();
    updateCounters();
    changeChosenValues(value);
}

function updateFormInputValue() {
    let element = document.getElementById('dozensInput');

    element.value = JSON.stringify(dozens ?? []);
}

function updateCounters() {
    let selected = dozens.length, remaining = 10 - selected;

    let counterSelected = document.getElementById('counterSelected'),
        counterRemaining = document.getElementById('counterRemaining');

    counterSelected.innerText = selected;
    counterRemaining.innerText = remaining;
}

function changeChosenValues(value) {
    let element = Array.from(document.querySelectorAll('div.btn-dzn.outline'))
        .find(el => el.textContent == (dozens.includes(value) ? '00' : `${value}`));

    element.classList.toggle('selected');
    element.innerText = !dozens.includes(value) ? '00' : value;
}
