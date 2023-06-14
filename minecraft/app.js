let body = document.querySelector('body');
let shop_container = document.querySelector('.shop-container');
let shopping_cart_image = document.querySelector('.login-item-image');
let cart = document.querySelector('.cart');
let cart_list = document.querySelector('.cart-list');
let cart_total = document.querySelector('.cart-total');
let cart_close = document.querySelector('.cart-close');

let items_quantity = [];
var totalItems;
var totalPrice;


function updateCart(item_id, value) {
    //If null create cart item element
    if (items_quantity[item_id] == null) {
        // Set initial value to 0
        items_quantity[item_id] = 0;

        // Create cart item DIV element
        let newDiv = document.createElement('div');
        newDiv.setAttribute('id', "cart-items-" + item_id)
        newDiv.innerHTML = 
        `
        <div class="cart-item border-inventory"">
        <div class="cart-item-image">
          <img src="${document.getElementById("shop-item-image-" + item_id).src}" alt="Dirt" class="cart-image" />
        </div>
        <p class="cart-item-name"> ${document.getElementById("shop-item-name-" + item_id).innerText} </p>
        <p class="cart-item-price" id="cart-item-price-${item_id}">$${document.getElementById("shop-item-price-" + item_id)}</p>
        <div class='cart-item-buttons'>
        <button onclick='updateCart(${item_id}, -1)'>-</button>
          <div id='cart-item-${item_id}'>${items_quantity[item_id]}</div>
        <button onclick='updateCart(${item_id}, 1)'>+</button>
        </div>
        </div>
        `;
        cart_list.appendChild(newDiv);
    }
    // Change value of item quantity
    items_quantity[item_id] = items_quantity[item_id] + value;
    // console.log(products[item_id].name + " quantity in cart is: " + items_quantity[item_id])

    // Update HTML
    document.getElementById('cart-item-' + item_id).innerHTML = `${items_quantity[item_id]}`;
    document.getElementById('cart-item-price-' + item_id).innerHTML = `$${Math.round(items_quantity[item_id] * document.getElementById("shop-item-price-" + item_id).innerText.replace('$', '') * 100) / 100}</div>`;
        // Update Total price
    tempInt = 0;
    items_quantity.forEach((value, id) => {
        // console.log(value + " and price is: " + products[id].price);
        tempInt = tempInt + (value * document.getElementById("shop-item-price-" + id).innerText.replace('$', ''));
    })
    tempInt = Math.round(tempInt * 100) / 100;
    totalPrice = tempInt; // var total price
    document.querySelector('.cart-total').innerHTML = 
    `
    <div class='cart-checkout'>Checkout</div>
    <div>$${totalPrice}</div>
    `;
        // Update Total items
    tempInt = 0;
    items_quantity.forEach((value) => {
        tempInt = tempInt + value;
    })
    totalItems = tempInt;
    document.getElementById('total-items').innerHTML = `${totalItems}`;
    cart.setAttribute('id', "cart-not-empty")

    // Delete DIV element if quantity is 0
    if (items_quantity[item_id] == 0) {
        items_quantity[item_id] = null;
        let delDiv = document.getElementById('cart-items-' + item_id);
        delDiv.remove();
    }
    if (totalItems == 0) {
        let delDiv = document.querySelector('.cart-checkout');
        delDiv.remove();
        cart.removeAttribute('id', "cart-not-empty");
    }
}


shopping_cart_image.addEventListener('click', ()=>{
    body.classList.add('open-cart')
})
cart_close.addEventListener('click', ()=>{
    body.classList.remove('open-cart')
})

// Prevent submitting form
$('#chat-text-box-form').on('submit', function(event) {
    event.preventDefault();
    let message = document.getElementById('chat-input').value;
    document.getElementById('chat-input').value = '';

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 & this.status == 200) {
            // TODO: Real time chatting
        }
    }
    xmlhttp.open('POST', 'scripts/send_server_chat.php', true);
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.send('msg=' + message);
})