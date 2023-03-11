export const formatInCurrency = (value, currency = 'USD') => {
    if (isNaN(value)) {
        return value;
    }
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency
    });
    return formatter.format(value);
};


export const sortedCountries = () => {
    const countries = require('../resources/countries.json');
    const sortedCountries = countries.sort((a, b) => a.name.localeCompare(b.name));
    return sortedCountries.map(country => country.name);
}
