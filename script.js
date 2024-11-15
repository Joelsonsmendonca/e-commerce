const cartTable = document.querySelector("#cart-table tbody");
const cartTotal = document.getElementById("cart-total");
const cartTotalFooter = document.getElementById("cart-total-footer");
const finalizeButton = document.getElementById("finalize-btn");
const messageContainer = document.getElementById("message-container");

let cart = [
  {
    name: "Produto 1",
    price: 5,
    quantity: 0,
    category: "Categoria 1",
    image: "https://picsum.photos/50/50"
  },
  {
    name: "Produto 2",
    price: 5,
    quantity: 0,
    category: "Categoria 2",
    image: "https://picsum.photos/50/50"
  },
  {
    name: "Produto 3",
    price: 5,
    quantity: 0,
    category: "Categoria 3",
    image: "https://picsum.photos/50/50"
  }
];


function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}


function loadCart() {
  const storedCart = localStorage.getItem("cart");
  if (storedCart) {
    cart = JSON.parse(storedCart);
    updateCart();
  }
}

function showMessage(message, type = 'success') {
  messageContainer.innerHTML = ''; 
  
  const messageElement = document.createElement('div');
  messageElement.className = `message ${type}`;
  messageElement.textContent = message;
  messageContainer.appendChild(messageElement);

 
  setTimeout(() => {
    messageContainer.innerHTML = '';
  }, 3000);
}


function updateCart() {
  cartTable.innerHTML = "";
  let total = 0;

  cart.forEach((item, index) => {
    const row = document.createElement("tr");

    row.innerHTML = `
      <td>
        <div class="produtc">
          <img src="${item.image}" alt="${item.name}">
          <div class="info">
            <div class="Name">${item.name}</div>
            <div class="category">${item.category}</div>
          </div>
        </div>
      </td>
      <td>$${item.price}</td>
      <td>
        <div class="qty">
          <button class="decrease" data-index="${index}"><i class='bx bx-minus'></i></button>
          <span>${item.quantity}</span>
          <button class="increase" data-index="${index}"><i class='bx bx-plus'></i></button>
        </div>
      </td>
      <td>$${(item.price * item.quantity).toFixed(0)}</td>
      <td>
        <button class="remove" data-index="${index}"><i class='bx bx-x'></i></button>
      </td>
    `;

    cartTable.appendChild(row);
    total += item.price * item.quantity;
  });

  cartTotal.textContent = `$${total.toFixed(0)}`;
  cartTotalFooter.textContent = `$${total.toFixed(0)}`;

  saveCart(); 
}

function removeItem(index) {
  cart.splice(index, 1);
  updateCart();
  showMessage("Item removido do carrinho.", "success");
}

function updateQuantity(index, increase) {
  if (increase) {
    cart[index].quantity++;
  } else if (cart[index].quantity > 0) {
    cart[index].quantity--;
  }
  updateCart();
  showMessage("Quantidade atualizada.", "success");
}


cartTable.addEventListener("click", (event) => {
  if (event.target.closest(".remove")) {
    const index = event.target.closest(".remove").dataset.index;
    removeItem(index);
  }

  if (event.target.closest(".increase")) {
    const index = event.target.closest(".increase").dataset.index;
    updateQuantity(index, true);
  }

  if (event.target.closest(".decrease")) {
    const index = event.target.closest(".decrease").dataset.index;
    updateQuantity(index, false);
  }
});


finalizeButton.addEventListener("click", () => {
  if (cart.length > 0) {
    showMessage("Compra finalizada com sucesso!", "success");
    cart = [];
    updateCart();
  } else {
    showMessage("Seu carrinho está vazio.", "error");
  }
});


window.onload = loadCart;
