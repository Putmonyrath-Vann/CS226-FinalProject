const cardHTML = `<input type="text" class="card" name="category_name[]" id="add" placeholder="Add New Category"/>`;
const submitButtonHTML = `<button class="category-food-add-btn" onclick="submit()" id="submit">submit</button>`;
const form = document.querySelector("#form");

function addCategory() {
    if (form.childNodes.length === 1) {
        const buttons = document.querySelector("#buttons");
        buttons.innerHTML += submitButtonHTML;
    }
    else {
        const cards = document.querySelectorAll(".card");
        if (cards[cards.length - 1].value === "") {
            return;
        }
    }
    const cardElement = document.createElement("div");
    cardElement.innerHTML = cardHTML;
    form.appendChild(cardElement);
    const cards = document.querySelectorAll(".card");
    cards[cards.length - 1].addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            addCategory();
        }
    });
    focusLastCard();
}

function focusLastCard() {
    const cards = document.querySelectorAll(".card");
    cards[cards.length - 1].focus();
}

function submit() {
    const form = document.querySelector("#form");
    // console.log(form)
    form.submit()
}
