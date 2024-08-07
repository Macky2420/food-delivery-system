// Get references to all the select elements and cost display paragraphs
const selects = document.querySelectorAll('select');
const costParagraphs = document.querySelectorAll('#cost');

// Loop through all the select elements and add event listeners to each one
selects.forEach((select, index) => {
  // Add change event listener to the select element
  select.addEventListener('change', () => {
    // Get the selected option element
    const selectedOption = select.options[select.selectedIndex];

    // Get the name and cost of the selected option
    const name = selectedOption.text;
    const cost = parseFloat(selectedOption.dataset.cost);

    // Update the text content of the corresponding cost display paragraph to show the name and cost of the selected option,
    // or the default cost if no option is selected or the cost is NaN
    if (selectedOption && !isNaN(cost)) {
      costParagraphs[index].textContent = `PHP ${cost.toFixed(2)}`;
    } 
  });

  // Trigger the change event once to initialize the cost display paragraph
  select.dispatchEvent(new Event('change'));
});

  // Foods
  const foodsButton = document.querySelector('#foodsButton');
  const foodsContent = document.querySelector('#foodsContent');
  // Drinks
  const drinksButton = document.querySelector('#drinksButton');
  const drinksContent = document.querySelector('#drinksContent');
  // Foods
  foodsButton.addEventListener('click', () => {
      if (foodsContent.classList.contains('visible')) {
          foodsContent.classList.remove('hidden');
          drinksContent.classList.add('hidden');
          foodsButton.classList.add('bg-green-800');
          foodsButton.classList.add('text-white');
          foodsButton.classList.remove('text-green-800');
          drinksButton.classList.remove('bg-green-800');
          drinksButton.classList.remove('text-white');
          drinksButton.classList.add('text-green-800');
      }
  })
  // Drinks
  drinksButton.addEventListener('click', () => {
      if (drinksContent.classList.contains('hidden')) {
          foodsContent.classList.add('hidden');
          drinksContent.classList.remove('hidden');
          foodsButton.classList.remove('bg-green-800');
          foodsButton.classList.remove('text-white');
          foodsButton.classList.add('text-green-800');
          drinksButton.classList.add('bg-green-800');
          drinksButton.classList.add('text-white');
          drinksButton.classList.remove('text-green-800');
      }
  })