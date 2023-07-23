/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//require('./public/assets/css/app.css');
import noUiSlider from 'nouislider';
import '/node_modules/nouislider/dist/nouislider.css'
import Filter from './modules/Filter'

new Filter(document.querySelector('.js-filter'))

const prixSlider = document.getElementById('prix-slider');

if (prixSlider) {
    const prixmin =document.getElementById('prixmin');
    const prixmax =document.getElementById('prixmax');
    const prixminValue = Math.floor(parseInt(prixSlider.dataset.min, 10) / 10) * 10;
    const prixmaxValue = Math.ceil(parseInt(prixSlider.dataset.max, 10) / 10) * 10;
    const range = noUiSlider.create(prixSlider, {
        start: [prixmin.value || prixminValue, prixmax.value || prixmaxValue],
        connect: true,
        step: 100,
        range: {
            'min': prixminValue,
            'max': prixmaxValue
        }
    });
    
    range.on('slide', function (values, handle) {
        if (handle === 0) {
            prixmin.value = Math.round(values[0])
        }
        if (handle === 1) {
            prixmax.value = Math.round(values[1])
        }
    })
    range.on('end', function (values, handle) {
        prixmin.dispatchEvent(new Event('change'))
    })
}


const kmSlider = document.getElementById('km-slider');

if (kmSlider) {
    const kmmin =document.getElementById('kmmin');
    const kmmax =document.getElementById('kmmax');
    const kmminValue = Math.floor(parseInt(kmSlider.dataset.min, 10) / 10) * 10;
    const kmmaxValue = Math.ceil(parseInt(kmSlider.dataset.max, 10) / 10) * 10;
    const range = noUiSlider.create(kmSlider, {
        start: [kmmin.value || kmminValue, kmmax.value || kmmaxValue],
        connect: true,
        step: 100,
        range: {
            'min': kmminValue,
            'max': kmmaxValue
        }
    });
    
    range.on('slide', function (values, handle) {
        if (handle === 0) {
            kmmin.value = Math.round(values[0])
        }
        if (handle === 1) {
            kmmax.value = Math.round(values[1])
        }
    })
    range.on('end', function (values, handle) {
        kmmin.dispatchEvent(new Event('change'))
    })
}


const anneeSlider = document.getElementById('annee-slider');
if (anneeSlider) {
    const anneemin =document.getElementById('anneemin');
    const anneemax =document.getElementById('anneemax');
    const anneeminValue = Math.floor(parseInt(anneeSlider.dataset.min, 10) / 10) * 10;
    const anneemaxValue = Math.ceil(parseInt(anneeSlider.dataset.max, 10) / 10) * 10;
    const range = noUiSlider.create(anneeSlider, {
        start: [anneemin.value || anneeminValue, anneemax.value || anneemaxValue],
        connect: true,
        step: 1,
        range: {
            'min': anneeminValue,
            'max': anneemaxValue
        }
    });
    
    range.on('slide', function (values, handle) {
        if (handle === 0) {
            anneemin.value = Math.round(values[0])
        }
        if (handle === 1) {
            anneemax.value = Math.round(values[1])
        }
    })
    range.on('end', function (values, handle) {
        anneemin.dispatchEvent(new Event('change'))
    })
}

var dimanche = document.getElementById('Dimanche');
var samedi = document.getElementById('Samedi');