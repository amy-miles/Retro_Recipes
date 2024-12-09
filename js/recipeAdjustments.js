// This handles the functionality of the adjustment of the servings
//console.log("recipeAdjustments.js loaded");debugging
// Store original recipe data for reset button
const originalRecipes = {};

// Fetch recipe data from the server on page load
document.addEventListener("DOMContentLoaded", function () {
    fetch("helpers/getRecipeData.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch recipe data");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Populate the original recipes cache
            data.forEach(recipe => {
                originalRecipes[recipe.recipe_id] = {
                    servings: recipe.servings,
                    ingredients: JSON.parse(recipe.ingredients) 
                };
            });
        })
        .catch(error => console.error("Error fetching recipe data:", error));
});

//multiplies the serving by the factor selected (1/2x or 2x)
function adjustRecipe(recipeId, factor) {
    const original = originalRecipes[recipeId];
    if (!original) {
        console.error("Recipe data not found for ID:", recipeId);
        return;
    }

    // Adjust servings without trailing zeros
    const scaledServings = parseFloat((original.servings * factor).toFixed(2));
    document.getElementById(`servings-${recipeId}`).textContent = scaledServings % 1 === 0 
        ? scaledServings.toFixed(0)  // Display as integer if it's a whole number
        : scaledServings;           // Otherwise, show up to 2 decimals

    // Adjust ingredients
    const ingredientsList = document.querySelector(`#details-${recipeId} ul`);
    ingredientsList.innerHTML = ""; // Clear existing ingredients

    original.ingredients.forEach(ingredient => {
        const scaledAmount = FractionHelper.scale(ingredient.amount, factor); // Use fraction helper
        const listItem = document.createElement("li");
        listItem.textContent = `${scaledAmount} ${ingredient.unit} ${ingredient.name}`;
        ingredientsList.appendChild(listItem);
    });
}

//Resets the servings to original in the DB
function resetRecipe(recipeId) {
    const original = originalRecipes[recipeId];
    if (!original) {
        console.error("Recipe data not found for ID:", recipeId);
        return;
    }

    // Reset servings
    document.getElementById(`servings-${recipeId}`).textContent = FractionHelper.decimalToFraction(original.servings);

    // Reset ingredients
    const ingredientsList = document.querySelector(`#details-${recipeId} ul`);
    ingredientsList.innerHTML = ""; // Clear existing ingredients

    original.ingredients.forEach(ingredient => {
        const listItem = document.createElement("li");
        listItem.textContent = `${ingredient.amount} ${ingredient.unit} ${ingredient.name}`;
        ingredientsList.appendChild(listItem);
    });

    //console.log(`Recipe ${recipeId} has been reset to original amounts.`);
}
