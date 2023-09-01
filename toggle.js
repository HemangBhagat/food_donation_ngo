function changedish(e) {
    console.log("You changed the input: ", e);
    let dish_field1 = document.querySelector('div[data-name="dish_field1"]');
    let dish_field2 = document.querySelector('div[data-name="dish_field2"]');
    let dish_field3 = document.querySelector('div[data-name="dish_field3"]');
    let dish_field4 = document.querySelector('div[data-name="dish_field4"]');
    let dish_field5 = document.querySelector('div[data-name="dish_field5"]');
    dish_field1.style.display = 'none';
    dish_field2.style.display = 'none';
    dish_field3.style.display = 'none';
    dish_field4.style.display = 'none';
    dish_field5.style.display = 'none';

    if(e.target.value == "1") {
        dish_field1.style.display = '';
    }
    else if(e.target.value == "2") {
        dish_field1.style.display = '';
        dish_field2.style.display = '';

    }
    else if(e.target.value == "3") {
        dish_field1.style.display = '';
        dish_field2.style.display = '';
        dish_field3.style.display = '';
    }
    else if(e.target.value == "4") {
        dish_field1.style.display = '';
        dish_field2.style.display = '';
        dish_field3.style.display = '';
        dish_field4.style.display = '';
    }
    else{
        dish_field1.style.display = '';
        dish_field2.style.display = '';
        dish_field3.style.display = '';
        dish_field4.style.display = '';
        dish_field5.style.display = '';
    }
}
let selectInput = document.querySelector('#amount');
changedish({target: selectInput});
selectInput.addEventListener('change', changedish);
