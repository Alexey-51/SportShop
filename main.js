// Утилиты
function toNum(str) {
    const num = Number(str.replace(/ /g, ""));
    return num;
}

function toCurrency(num) {
    const format = new Intl.NumberFormat("ru-RU", {
        style: "currency",
        currency: "RUB",
        minimumFractionDigits: 0,
    }).format(num);
    return format;
}

// Корзина
const cardAddArr = Array.from(document.querySelectorAll(".card__add"));
const cartNum = document.querySelector("#cart_num");
const cart = document.querySelector("#cart");

class Cart {
    products;
    constructor() {
        this.products = [];
    }
    get count() {
        return this.products.length;
    }
    addProduct(product) {
        this.products.push(product);
    }
    removeProduct(index) {
        this.products.splice(index, 1);
    }
    get cost() {
        const prices = this.products.map((product) => {
            return toNum(product.price);
        });
        const sum = prices.reduce((acc, num) => {
            return acc + num;
        }, 0);
        return sum;
    }
    get costDiscount() {
        const prices = this.products.map((product) => {
            return toNum(product.priceDiscount);
        });
        const sum = prices.reduce((acc, num) => {
            return acc + num;
        }, 0);
        return sum;
    }
    get discount() {
        return this.cost - this.costDiscount;
    }
}

class Product {
    imageSrc;
    name;
    price;
    priceDiscount;
    constructor(card) {
        this.imageSrc = card.querySelector(".card__image").children[0].src;
        this.name = card.querySelector(".card__title").innerText;
        this.price = card.querySelector(".card__price--common").innerText;
        this.priceDiscount = card.querySelector(".card__price--discount").innerText;
    }
}

const myCart = new Cart();

// Загружаем корзину из localStorage
if (localStorage.getItem("cart") == null) {
    localStorage.setItem("cart", JSON.stringify(myCart));
} else {
    const savedCart = JSON.parse(localStorage.getItem("cart"));
    myCart.products = savedCart.products;
    cartNum.textContent = myCart.count;
}

// Ищем родительскую карточку товара (может быть card или catalog-card)
function findParentCard(element) {
    return element.closest('.catalog-card') || element.closest('.card');
}

// Добавление товаров в корзину
cardAddArr.forEach((cardAdd) => {
    cardAdd.addEventListener("click", (e) => {
        e.preventDefault();
        
        // Находим родительскую карточку
        const card = findParentCard(e.target);
        if (!card) return;
        
        // Создаем товар
        const product = new Product(card);
        
        // Загружаем текущую корзину
        const savedCart = JSON.parse(localStorage.getItem("cart"));
        myCart.products = savedCart.products;
        
        // Добавляем товар
        myCart.addProduct(product);
        
        // Сохраняем в localStorage
        localStorage.setItem("cart", JSON.stringify(myCart));
        
        // Обновляем счетчик
        cartNum.textContent = myCart.count;
        
        // Анимация добавления
        cart.style.transform = 'scale(1.2)';
        setTimeout(() => {
            cart.style.transform = 'scale(1)';
        }, 200);
    });
});

// Попап
const popup = document.querySelector(".popup");
const popupClose = document.querySelector("#popup_close");
const body = document.body;
const popupContainer = document.querySelector("#popup_container");
const popupProductList = document.querySelector("#popup_product_list");
const popupCost = document.querySelector("#popup_cost");
const popupDiscount = document.querySelector("#popup_discount");
const popupCostDiscount = document.querySelector("#popup_cost_discount");

cart.addEventListener("click", (e) => {
    e.preventDefault();
    popup.classList.add("popup--open");
    body.classList.add("lock");
    popupContainerFill();
});

function popupContainerFill() {
    popupProductList.innerHTML = null;
    const savedCart = JSON.parse(localStorage.getItem("cart"));
    myCart.products = savedCart.products;
    
    if (myCart.products.length === 0) {
        const emptyMessage = document.createElement("div");
        emptyMessage.classList.add("popup__product");
        emptyMessage.innerHTML = '<p style="text-align: center; width: 100%;">Корзина пуста</p>';
        popupProductList.appendChild(emptyMessage);
    } else {
        const productsHTML = myCart.products.map((product, index) => {
            const productItem = document.createElement("div");
            productItem.classList.add("popup__product");
      
            const productWrap1 = document.createElement("div");
            productWrap1.classList.add("popup__product-wrap");
            const productWrap2 = document.createElement("div");
            productWrap2.classList.add("popup__product-wrap");
      
            const productImage = document.createElement("img");
            productImage.classList.add("popup__product-image");
            productImage.setAttribute("src", product.imageSrc);
      
            const productTitle = document.createElement("h2");
            productTitle.classList.add("popup__product-title");
            productTitle.innerHTML = product.name;
      
            const productPrice = document.createElement("div");
            productPrice.classList.add("popup__product-price");
            productPrice.innerHTML = toCurrency(toNum(product.priceDiscount));
      
            const productDelete = document.createElement("button");
            productDelete.classList.add("popup__product-delete");
            productDelete.innerHTML = "&#10006;";
      
            productDelete.addEventListener("click", () => {
                myCart.products.splice(index, 1);
                localStorage.setItem("cart", JSON.stringify(myCart));
                cartNum.textContent = myCart.count;
                popupContainerFill();
            });
      
            productWrap1.appendChild(productImage);
            productWrap1.appendChild(productTitle);
            productWrap2.appendChild(productPrice);
            productWrap2.appendChild(productDelete);
            productItem.appendChild(productWrap1);
            productItem.appendChild(productWrap2);
      
            return productItem;
        });
    
        productsHTML.forEach((productHTML) => {
            popupProductList.appendChild(productHTML);
        });
    }
  
    popupCost.value = toCurrency(myCart.cost);
    popupDiscount.value = toCurrency(myCart.discount);
    popupCostDiscount.value = toCurrency(myCart.costDiscount);
}

popupClose.addEventListener("click", (e) => {
    e.preventDefault();
    popup.classList.remove("popup--open");
    body.classList.remove("lock");
});

// Закрытие попапа по клику вне его
popup.addEventListener("click", (e) => {
    if (e.target === popup) {
        popup.classList.remove("popup--open");
        body.classList.remove("lock");
    }
});