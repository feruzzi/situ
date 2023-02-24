let choices = document.querySelectorAll(".choices");
let initChoice;
for (let i = 0; i < choices.length; i++) {
    if (choices[i].classList.contains("multiple-remove")) {
        initChoice = new Choices(choices[i], {
            delimiter: ",",
            editItems: true,
            maxItemCount: -1,
            removeItemButton: true,
            customProperties: {
                unit: "data-unit",
            },
        });
    } else {
        initChoice = new Choices(choices[i], {
            placeholder: true,
            placeholderValue: "Cari",
            searchPlaceholderValue: "Cari...",
            shouldSort: true,
            renderSelectedChoices: "auto",
            customProperties: {
                "data-unit": "x",
            },
        });
    }
}
