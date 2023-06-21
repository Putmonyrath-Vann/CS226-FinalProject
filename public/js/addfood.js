const submitButtonHTML = `<button class="category-food-add-btn" onclick="submit()" id="submit">submit</button>`;
const form = document.querySelector("#form");

function addFood(categories) {
    const rows = document.querySelectorAll(".input-food-row");
    if (rows.length >= 5) {
        alert('You can only add 5 foods at a time')
        return
    }
    if (form.childNodes.length === 1) {
        const buttons = document.querySelector("#buttons");
        buttons.innerHTML += submitButtonHTML;
    }
    else {
        const finalRow = document.querySelector(".input-food-row:last-child");
        const inputs = finalRow.querySelectorAll(".input-food", '[type="file"]');
        let returnFlag = false;
        inputs.forEach(input => {
            if (input.value === "") {
                returnFlag = true;
            }
        })
        if (returnFlag) return
    }

    const options = categories.map(category => {
        return `<option value=${category.category_id}>${category.category_name}</option>`
    }).join('')

    const foodRowHTML = `
    <input type="text" name="food_name[]" class="input-food" id="add" placeholder="Add New Food"/>
    <input type="number" name="food_price[]" class="input-food" id="add" placeholder="Price"/>
    <select class="input-food" name="food_category[]">
        <option disabled selected>-- Select Category --</option>
        ${options}
    </select>
    <div class="flex-center width-25">
        <input type="file" name="food_image[]" title="Please make sure the image is smaller than 1500KB" class="input-food" id="add" placeholder="Add New Food Image"/>
    </div>
    `
    const foodRow = document.createElement("div");
    foodRow.classList.add("input-food-row");
    foodRow.innerHTML = foodRowHTML;
    form.appendChild(foodRow);
    const finalRow = document.querySelector(".input-food-row:last-child");
    const inputs = finalRow.querySelectorAll(".input-food");

    inputs.forEach(input => {
        input.addEventListener("keydown", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                addFood();
            }
        });
    })
    focusLastRow();
}

function focusLastRow() {
    const finalRow = document.querySelector(".input-food-row:last-child");
    finalRow.querySelector(".input-food").focus();
}

function submit() {
    form.submit()
}
