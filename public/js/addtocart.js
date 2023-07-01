

const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
});

const tick = `<img src="/images/check-mark.png" class="tick"/>`

function addToCart(restaurantID, foodID) {
    const currentCart = getCookie('cart')
    let foodObjects = [];
    let boughtInOtherRestaurant = false;
    if (currentCart != null) {
        boughtInOtherRestaurant = JSON.parse(currentCart).restaurantID != restaurantID;
        foodObjects = JSON.parse(currentCart).foodObjects;
    }

    if (boughtInOtherRestaurant) {
        alert('you have already added some food from other restaurant, please clear your cart first');
        return;
    }

    let foodExists = false;
    foodObjects.forEach(food => {
        if (food.id == foodID) {
            alert('you have already added this food to your cart');
            foodExists = true;
            return
        }
    })

    if (foodExists) return

    foodObjects.push({id: foodID, quantity: 1});

    const foods = document.querySelectorAll(".food-in-category")
    foods.forEach(food => {
        if (food.dataset.foodid == foodID) {
            food.querySelector('.food_in_category_text.food_price').innerHTML += tick;
        }
    })
    const cartObj = {
        restaurantID: restaurantID,
        foodObjects: foodObjects
    }

    setCookie('cart', cartObj, 1);
    // updateTotalPrice();

    // localStorage.setItem('cart', JSON.stringify(cartObj));
    console.log('added to cart')
}

function updateQuantity(foodID) {
    const newQuantity = event.target.value
    const currentCart = JSON.parse(getCookie('cart'))
    let foodObjects = currentCart.foodObjects;

    foodObjects.forEach(foodObject => {
        if (foodObject.id == foodID) {
            foodObject.quantity = newQuantity
            return
        }
    })

    setCookie('cart', {restaurantID: currentCart.restaurantID, foodObjects: foodObjects}, 1);

    updateTotalPrice();
}

function updateTotalPrice() {
    const rows = document.querySelectorAll('.cart-page-cart-row');
    const totalPriceBox = document.querySelector('.cart-page-total-price');
    const currentCart = JSON.parse(getCookie('cart'))

    let total = 0
    rows.forEach((row, index) => {
        if (index == 0) return
        let formattedPrice = row.querySelector('.cart-page-price').innerHTML;
        let price = Number(formattedPrice.replace(/[^0-9.-]+/g,""));

        let quantity = row.querySelector('.cart-page-quantity').value;

        total += price * quantity;
    })

    totalPriceBox.innerHTML = formatter.format(total);

    console.log(total);
}

function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    value = JSON.stringify(value);
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function removeFromCart(foodID) {
    const currentCart = JSON.parse(getCookie('cart'))
    let foodObjects = currentCart.foodObjects

    foodObjects.forEach((foodObject, index) => {
        if (foodObject.id == foodID) {
            foodObjects.splice(index, 1);
            return
        }
    })

    setCookie('cart', {restaurantID: currentCart.restaurantID, foodObjects: foodObjects}, 1);

    if (foodObjects.length == 0) {
        setCookie('cart', null, 0)
        window.location.reload();
        return
    }
    const food = document.querySelector(`#item${foodID}`)
    food.remove()

}

function getCookie(cookieName) {
    let cookie = {};
    document.cookie.split(';').forEach(function(el) {
      let [key,value] = el.split('=');
      cookie[key.trim()] = value;
    })
    return cookie[cookieName];
}