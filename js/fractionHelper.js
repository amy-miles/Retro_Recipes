//this file converts a decimal to a fraction for display
//console.log("fractionHelper.js loaded"); debugging

const FractionHelper = {
    // Converts a decimal to a fraction string
    decimalToFraction(decimal) {
        if (decimal % 1 === 0) {
            return decimal.toString(); // It's a whole number
        }

        const tolerance = 1e-6; // Precision tolerance
        let denominator = 1;
        while (Math.abs(decimal * denominator - Math.round(decimal * denominator)) > tolerance) {
            denominator++;
        }

        const numerator = Math.round(decimal * denominator);
        const gcd = (a, b) => (b === 0 ? a : gcd(b, a % b)); // Greatest common divisor
        const divisor = gcd(numerator, denominator);

        const reducedNumerator = numerator / divisor;
        const reducedDenominator = denominator / divisor;

        if (reducedNumerator > reducedDenominator) {
            // Mixed fraction (e.g., 1 1/4)
            const whole = Math.floor(reducedNumerator / reducedDenominator);
            const remainder = reducedNumerator % reducedDenominator;
            return remainder > 0
                ? `${whole} ${remainder}/${reducedDenominator}`
                : whole.toString();
        }

        return `${reducedNumerator}/${reducedDenominator}`;
    },

    // Scales a numeric or fraction string by a factor
    scale(amount, factor) {
        if (typeof amount === "string" && amount.includes("/")) {
            // Handle fractions like "3/4"
            const [numerator, denominator] = amount.split("/").map(Number);
            const scaledNumerator = numerator * factor;
            return this.decimalToFraction(scaledNumerator / denominator);
        } else if (typeof amount === "string" && amount.includes(" ")) {
            // Handle mixed fractions like "1 1/2"
            const [whole, fraction] = amount.split(" ");
            const wholePart = parseFloat(whole) * factor;
            const fractionPart = this.scale(fraction, factor);
            return `${Math.floor(wholePart)} ${fractionPart}`;
        }

        // Handle decimals or whole numbers
        const scaledValue = parseFloat(amount) * factor;
        return this.decimalToFraction(scaledValue);
    },
};
