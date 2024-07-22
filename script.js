// Toggle class active
const navbarNav = document.querySelector(".navbar-nav");
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");
const cartForm = document.querySelector(".cart-form");
const userProfile = document.querySelector(".profile");
const header = document.querySelector(".header-main");
const containerPayment = document.querySelector(".bg-payment");

// When hamburger clicked
document.querySelector("#menu").onclick = (e) => {
  e.preventDefault(); // Prevent default behavior
  navbarNav.classList.toggle("active");
};

//when search btn clicked
document.querySelector("#search").onclick = (e) => {
  e.preventDefault(); // Prevent default behavior
  searchForm.classList.toggle("active");
  searchBox.focus();
};

//when shopping cart clicked
document.querySelector("#cart").onclick = (e) => {
  e.preventDefault(); // Prevent default behavior
  cartForm.classList.toggle("active");
};

//when user clicked
document.querySelector("#user").onclick = (e) => {
  e.preventDefault(); // Prevent default behavior
  userProfile.classList.toggle("active");
};

// Click outside element to close
const menu = document.querySelector("#menu");
const searchBtn = document.querySelector("#search");
const cartBtn = document.querySelector("#cart");
const userBtn = document.querySelector("#user");

document.addEventListener("click", function (e) {
  if (!menu.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
    header.style.zIndex = "99";
  }

  if (!searchBtn.contains(e.target) && !searchForm.contains(e.target)) {
    searchForm.classList.remove("active");
  }

  if (!cartBtn.contains(e.target) && !cartForm.contains(e.target)) {
    cartForm.classList.remove("active");
  }

  if (!userBtn.contains(e.target) && !userProfile.contains(e.target)) {
    userProfile.classList.remove("active");
  }
});

//star
function rating(data) {
  let total = 5;
  let rate = data.rating;
  let balance = total - rate;

  let starHTML = "";

  for (let i = 0; i < rate; i++) {
    starHTML += `<i data-feather="star" class="full-star"></i>`;
  }

  for (let i = 0; i < balance; i++) {
    starHTML += `<i data-feather="star" class="star"></i>`;
  }

  return starHTML;
}

//view detail
const detailItem = document.getElementById("item-detail-modal");

function viewItemDetails(itemId, e) {
  e.preventDefault();
  fetch("detail.php?id=" + itemId)
    .then((response) => response.json())
    .then((data) => {
      let star = rating(data);
      detailItem.style.display = "flex";
      console.log(data.id);

      document.getElementById("modal-content").innerHTML = `
            <div class="image">
                <img src="${data.image}" alt="">
            </div>
            <div class="product-content">
                <h3>${data.name}</h3>
                <p>${data.description}</p>
                <div class="product-star">
                  ${star}
                </div>
                <p class="price">RM${data.price}</p>
                ${
                  data.sessionId > 0
                    ? `<a href="#" class='addToCart'><i data-feather="shopping-cart"></i><span>Add to cart</span></a>`
                    : `<a href="#" onclick='hideCart(event)'><i data-feather="shopping-cart"></i><span>Add to cart</span></a>`
                }
            </div>
            <div class="close">
              <a href="#" class="close-icon"><i data-feather="x"></i></a>
            </div>
          `;
      feather.replace();

      document.querySelector(".addToCart").onclick = (e) => {
        cart(data.id, e);
      };
    })
    .catch((error) => console.error("Error:", error));
}

// Close modal box
document.addEventListener("click", function (e) {
  if (e.target.closest(".close-icon")) {
    console.log("done");
    detailItem.style.display = "none";
    e.preventDefault();
  }
});

// Click outside modal
const container = document.querySelector(".modal-container");

window.onclick = (e) => {
  if (e.target === container) {
    detailItem.style.display = "none";
  }
};

//shopping cart
//defalut if no item
let noItem = document.createElement("p");
noItem.innerHTML = "no Item";
noItem.style.textAlign = "center";
noItem.style.marginTop = "3rem";
cartForm.appendChild(noItem);

function updateNoItemMessage() {
  const cartItems = document.querySelectorAll(".cart-item");
  if (cartItems.length === 0) {
    noItem.style.display = "block";
    divBuy.style.display = "none";
  } else {
    noItem.style.display = "none";
    divBuy.style.display = "block";
  }
}

//Price and Buy
const divBuy = document.createElement("div");
divBuy.classList.add("price-buy");

const printTotalPrice = document.createElement("h1");
printTotalPrice.classList.add("price-display");
printTotalPrice.innerHTML = "RM 0.00";
divBuy.appendChild(printTotalPrice);

const buyButton = document.createElement("button");
buyButton.classList.add("buyBtn");
buyButton.innerHTML = "Checkout";
buyButton.disabled = true;
divBuy.appendChild(buyButton);

function cart(itemId, e) {
  e.preventDefault();
  fetch("detail.php?id=" + itemId)
    .then((response) => response.json())
    .then((data) => {
      console.log(data.id);

      const cartItems = document.querySelectorAll(".cart-item");
      let isDuplicate = false;

      cartItems.forEach((item) => {
        const existingItemId = item.getAttribute("data-item-id");
        if (existingItemId === data.id.toString()) {
          isDuplicate = true;
          console.log("Item with ID " + data.id + " already exists in cart.");

          //increase the input number if duplicate
          const quantityInput = item.querySelector("#quantity");
          let cartNum = parseInt(quantityInput.value) || 0;
          cartNum++;
          quantityInput.value = cartNum;
          updateQuantityBadge();

          return; // Exit forEach loop early if duplicate found
        }
      });

      if (!isDuplicate) {
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");
        cartItem.setAttribute("data-item-id", data.id);

        cartItem.innerHTML = `
        <input type="checkbox" name="" id="cart-check">
        <img src="${data.image}" alt="">
        <div class="info">
            <h3>${data.name}</h3>
            <div class="price-quantity">
                <p class="price">RM${data.price}</p>
                <div class="quantity-form">
                    <div onclick="decreaseCart(this, event)">-</div>
                    <form>
                      <input type="text" name="quantity" id="quantity" value="1">
                    </form>
                    <div onclick="increaseCart(this)">+</div>
                </div>
            </div>
            <i class="delete-icon" data-feather="trash-2" onclick="removeCart(this, event)"></i>
        </div>
      `;
        cartForm.appendChild(cartItem);

        //trigger cheeckbox
        const checkbox = cartItem.querySelector("#cart-check");
        checkbox.addEventListener("change", function () {
          priceTotal();
        });
      }

      feather.replace();
      updateNoItemMessage();
      updateQuantityBadge();

      cartForm.appendChild(divBuy);
      priceTotal();
    })
    .catch((error) => console.error("Error:", error));
}

function priceTotal() {
  const cartItems = document.querySelectorAll(".cart-item");
  const displayPrice = document.querySelector(".price-display");
  let totalPrice = 0;
  let anyCheckboxChecked = false;

  cartItems.forEach((item) => {
    const checkbox = item.querySelector("#cart-check");

    if (checkbox.checked) {
      anyCheckboxChecked = true;
      const price = parseFloat(
        item.querySelector(".price").textContent.replace("RM", "")
      );
      const quantity = parseInt(item.querySelector("#quantity").value);
      totalPrice += price * quantity;
    }
  });

  displayPrice.innerHTML = "RM " + totalPrice.toFixed(2);
  buyButton.disabled = !anyCheckboxChecked;
}

function increaseCart(element) {
  const cartItem = element.closest(".cart-item");
  if (cartItem) {
    const quantityInput = cartItem.querySelector("#quantity");
    let cartNum = parseInt(quantityInput.value) || 0;
    cartNum++;
    quantityInput.value = cartNum;
    updateQuantityBadge();

    priceTotal();
  }
}

function decreaseCart(element, event) {
  const cartItem = element.closest(".cart-item");
  if (cartItem) {
    const quantityInput = cartItem.querySelector("#quantity");
    let cartNum = parseInt(quantityInput.value) || 0;
    if (cartNum > 0) {
      cartNum--;
      quantityInput.value = cartNum;
    }

    if (cartNum == 0) {
      cartItem.closest(".cart-item").remove();
      event.stopPropagation();
    }

    updateNoItemMessage();
    updateQuantityBadge();

    priceTotal();
  }
}

function removeCart(cartItem, event) {
  cartItem.closest(".cart-item").remove();

  updateNoItemMessage();
  event.stopPropagation();
  updateQuantityBadge();

  priceTotal();
}

function totalQuantity() {
  const cartItems = document.querySelectorAll(".cart-item");
  let totalQuantity = 0;

  cartItems.forEach((item) => {
    const quantityInput = item.querySelector("#quantity");
    if (quantityInput) {
      totalQuantity += parseInt(quantityInput.value) || 0;
    }
  });

  return totalQuantity;
}

function updateQuantityBadge() {
  //cart quantity
  const quantityBadge = document.querySelector(".quantity-badge");
  let quantityItem = totalQuantity();

  if (quantityItem > 0) {
    if (quantityItem > 99) {
      quantityItem = "99+";
    }
    quantityBadge.innerHTML = quantityItem;
    quantityBadge.style.display = "block";
  } else {
    quantityBadge.style.display = "none";
  }
}

function hideCart(event) {
  alert("You need to login first");
  event.preventDefault();
}

//when payment clicked

buyButton.onclick = () => {
  containerPayment.classList.toggle("active");
};

document.addEventListener("click", function (e) {
  if (!buyButton.contains(e.target) && containerPayment.contains(e.target)) {
    containerPayment.classList.remove("active");
  }
});
