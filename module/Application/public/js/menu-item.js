let currentIcon = $('input.iconpicker').val();


(async () => {
    const response = await fetch('/json/icons.json')
    const result = await response.json()

    const iconpicker = new Iconpicker(document.querySelector(".iconpicker"), {
        icons: result,
        showSelectedIn: document.querySelector(".selected-icon"),
        searchable: true,
        selectedClass: "selected",
        containerClass: "my-picker",
        hideOnSelect: true,
        fade: true,
        defaultValue: currentIcon,
        valueFormat: val => `${val}`
    });
})()

/**
 * const iconpicker = new Iconpicker(document.querySelector('.iconpicker'), {
 *     showSelectedIn: document.querySelector('.selected-icon'),
 *     icons: ['fa fa-times', 'fa fa-check', 'fas fa-bars', 'far fa-thin fa-image'],
 *     defaultValue: currentIcon,
 *     valueFormat: val => `${val}`
 * })
 */