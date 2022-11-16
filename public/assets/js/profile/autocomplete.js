$(document).ready(function (){
    $.getJSON('/assets/json/ru.json', function (cities){
        cities.forEach(function (key, value){
            $('#cities').append(`<option value="${key.name}"></option>`)
        });
    });
})