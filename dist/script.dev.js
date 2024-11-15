"use strict";

var cartTable = document.querySelector("#cart-table tbody");
var cartTotal = document.getElementById("cart-total");
var cartTotalFooter = document.getElementById("cart-total-footer");
var finalizeButton = document.getElementById("finalize-btn");
var cart = [{
  name: "Produto 1",
  price: 5,
  quantity: 0,
  category: "Categoria 1",
  image: "https://picsum.photos/50/50"
}, {
  name: "Produto 2",
  price: 5,
  quantity: 0,
  category: "Categoria 2",
  image: "https://picsum.photos/50/50"
}, {
  name: "Produto 3",
  price: 5,
  quantity: 0,
  category: "Categoria 3",
  image: "https://picsum.photos/50/50"
}];

function updateCart() {
  cartTable.innerHTML = "";
  var total = 0;
  cart.forEach(function (item, index) {
    var row = document.createElement("tr");
    row.innerHTML = "\n      <td>\n        <div class=\"produtc\">\n          <img src=\"".concat(item.image, "\" alt=\"").concat(item.name, "\">\n          <div class=\"info\">\n            <div class=\"Name\">").concat(item.name, "</div>\n            <div class=\"category\">").concat(item.category, "</div>\n          </div>\n        </div>\n      </td>\n      <td>$").concat(item.price, "</td>\n      <td>\n        <div class=\"qty\">\n          <button class=\"decrease\" data-index=\"").concat(index, "\"><i class='bx bx-minus'></i></button>\n          <span>").concat(item.quantity, "</span>\n          <button class=\"increase\" data-index=\"").concat(index, "\"><i class='bx bx-plus'></i></button>\n        </div>\n      </td>\n      <td>$").concat((item.price * item.quantity).toFixed(0), "</td>\n      <td>\n        <button class=\"remove\" data-index=\"").concat(index, "\"><i class='bx bx-x'></i></button>\n      </td>\n    ");
    cartTable.appendChild(row);
    total += item.price * item.quantity;
  });
  cartTotal.textContent = "$".concat(total.toFixed(0));
  cartTotalFooter.textContent = "$".concat(total.toFixed(0));
}

function removeItem(index) {
  cart.splice(index, 1);
  updateCart();
}

function updateQuantity(index, increase) {
  if (increase) {
    cart[index].quantity++;
  } else if (cart[index].quantity > 0) {
    cart[index].quantity--;
  }

  updateCart();
}

cartTable.addEventListener("click", function (event) {
  if (event.target.closest(".remove")) {
    var index = event.target.closest(".remove").dataset.index;
    removeItem(index);
  }

  if (event.target.closest(".increase")) {
    var _index = event.target.closest(".increase").dataset.index;
    updateQuantity(_index, true);
  }

  if (event.target.closest(".decrease")) {
    var _index2 = event.target.closest(".decrease").dataset.index;
    updateQuantity(_index2, false);
  }
});
finalizeButton.addEventListener("click", function () {
  if (cart.length > 0) {
    alert("Compra finalizada com sucesso!");
    cart = [];
    updateCart();
  } else {
    alert("Seu carrinho está vazio.");
  }
});
updateCart();
//# sourceMappingURL=script.dev.js.map
