document.addEventListener('DOMContentLoaded', () => {
    const productData = {
        name: '',
        ingredients: '',
        description: '',
        calories: '',
        proteins: '',
        fats: '',
        carbs: '',
        price: '',
        img: '',
    }
    productForm = document.getElementById('new_product');
    nameInput = document.getElementById('name-input');
    ingredientsInput = document.getElementById('ingredients-input');
    descriptionInput = document.getElementById('description-input');
    caloriesInput = document.getElementById('calories-input');
    proteinsInput = document.getElementById('proteins-input');
    fatsInput = document.getElementById('fats-input');
    carbsInput = document.getElementById('carbs-input');
    priceInput = document.getElementById('price-input');
    imgInput = document.getElementById('img-input');

    function onNameInputChange(event) {
        productData.name = event.target.value;
        invalidateProductPreview();
    }
    function onIngredientsInputChange(event) {
        productData.ingredients = event.target.value;
        invalidateProductPreview();
    }
    function onDescriptionInputChange(event) {
        productData.description = event.target.value;
        invalidateProductPreview();
    }
    function onCaloriesInputChange(event) {
        productData.calories = event.target.value;
        invalidateProductPreview();
    }
    function onProteinsInputChange(event) {
        productData.proteins = event.target.value;
        invalidateProductPreview();
    }
    function onFatsInputChange(event) {
        productData.fats = event.target.value;
        invalidateProductPreview();
    }
    function onCarbsInputChange(event) {
        productData.carbs = event.target.value;
        invalidateProductPreview();
    }
    function onPriceInputChange(event) {
        productData.price = event.target.value;
        invalidateProductPreview();
    }
    async function onImgChange(event) {
        const file = event.target.files[0];
        const b64Img = await asyncReadFileAsBase64(file);
        productData.img = b64Img;
        invalidateProductPreview();
        document.querySelector('.img-input').src = productData.img;
    }
    
    function onProductFormSubmit(event) {
        event.preventDefault();

        const isValidData = productData.description.trim().length
        && productData.name.trim().length
        && productData.ingredients.trim().length
        && productData.img.trim().length
        && productData.calories.trim().length
        && productData.proteins.trim().length
        && productData.fats.trim().length
        && productData.carbs.trim().length
        && productData.price.trim().length

        if (isValidData) {
            console.log(productData);

            let requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(productData)
            };
            let response = fetch('/product/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(productData)
            })
                .then(() => {
                    console.log('2')
                    // if (response.status >= 200 && response.status <= 399) {
                        console.log('1')
                        window.location.href = '/';
                    // }
                })
                .catch((error) => {
                });

        }
    }

    function initEventListeners() {
        productForm.addEventListener('submit', onProductFormSubmit);
        nameInput.addEventListener('input', onNameInputChange);
        ingredientsInput.addEventListener('input', onIngredientsInputChange);
        descriptionInput.addEventListener('input', onDescriptionInputChange);
        imgInput.addEventListener('change', onImgChange);
        caloriesInput.addEventListener('input', onCaloriesInputChange);
        proteinsInput.addEventListener('input', onProteinsInputChange);
        fatsInput.addEventListener('input', onFatsInputChange);
        carbsInput.addEventListener('input', onCarbsInputChange);
        priceInput.addEventListener('input', onPriceInputChange);
    }
    function invalidateProductPreview() {
        const productPreviewName = document.getElementById('page-preview-name');
        productPreviewName.innerText = productData.name;
        const productPreviewIngredients = document.querySelector('.content__ingredients');
        productPreviewIngredients.innerText = productData.ingredients;
        const productPreviewDescription = document.querySelector('.content__discription');
        productPreviewDescription.innerText = productData.description;
        const productPreviewPrice = document.querySelector('.content__button');
        productPreviewPrice.innerText = "тащи в логово за " + productData.price + "₽";
        const productPreviewCalories = document.querySelector('#cals');
        productPreviewCalories.innerText = productData.calories;
        const productPreviewProteins = document.querySelector('#prots');
        productPreviewProteins.innerText = productData.proteins;
        const productPreviewFats = document.querySelector('#fats');
        productPreviewFats.innerText = productData.fats;
        const productPreviewCarbs = document.querySelector('#carbs');
        productPreviewCarbs.innerText = productData.carbs;
        if (productData.img != '') 
        {
            const productPreviewImg= document.querySelector('.info__image');
            productPreviewImg.src = productData.img;
        } else {
            const productPreviewImg= document.querySelector('.info__image');
            productPreviewImg.src = "/images/preview-pizza.png";
        }

        const productCardPreviewName = document.querySelector('.card-preview__name');
        productCardPreviewName.innerText = productData.name;
        const productCardPreviewIngredients = document.querySelector('.card-preview__ingredients');
        productCardPreviewIngredients.innerText = productData.ingredients;
        const productCardPreviewPrice = document.querySelector('.card-preview__price');
        productCardPreviewPrice.innerText = productData.price + "₽";
        if (productData.img != '') 
        {
            const productCardPreviewImg = document.querySelector('.card-preview__img');
            productCardPreviewImg.src = productData.img;
        } else {
            const productCardPreviewImg = document.querySelector('.card-preview__img');
            productCardPreviewImg.src = "/images/preview-card.png";
        }
    }

    function asyncReadFileAsBase64(file) {
        return new Promise((resolve, reject) => {
            const fr = new FileReader();
            fr.onerror = reject;
            fr.onload = () => {
                resolve(fr.result);
            }
            fr.readAsDataURL(file);
        });
    }
    initEventListeners();
})